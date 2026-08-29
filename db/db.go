package db

import (
	"database/sql"
	"fmt"
	"os"
	"path/filepath"
	"strings"

	_ "modernc.org/sqlite"
)

// DB 全局连接
var DB *sql.DB

// Open 打开（必要时创建）数据库并完成初始化
func Open(dbPath string) error {
	dir := filepath.Dir(dbPath)
	if err := os.MkdirAll(dir, 0o755); err != nil {
		return fmt.Errorf("创建数据目录失败: %w", err)
	}
	dsn := fmt.Sprintf("file:%s?_pragma=busy_timeout(5000)&_pragma=journal_mode(WAL)", dbPath)
	conn, err := sql.Open("sqlite", dsn)
	if err != nil {
		return fmt.Errorf("打开数据库失败: %w", err)
	}
	if err := conn.Ping(); err != nil {
		return fmt.Errorf("连接数据库失败: %w", err)
	}
	DB = conn
	if err := migrate(); err != nil {
		return err
	}
	return seedIfEmpty()
}

// migrate 创建全部数据表与索引
func migrate() error {
	for _, q := range schemaSQL {
		if _, err := DB.Exec(q); err != nil {
			return fmt.Errorf("建表失败: %w", err)
		}
	}
	return nil
}

// Result 复刻 PHP mysql_func() 的返回形态
type Result struct {
	Rows     []map[string]any // SELECT 结果
	LastID   int64            // INSERT
	Affected int64            // UPDATE/DELETE
	Ok       bool             // 操作是否成功 / SELECT 是否有数据
}

// Exec 危险入口：直接执行拼接 SQL（复刻 PHP mysql_func，保留注入教学）。
func Exec(sql string) *Result {
	sql = strings.TrimSpace(sql)
	if sql == "" {
		return nil
	}
	first := strings.ToUpper(strings.Fields(sql)[0])
	switch first {
	case "SELECT", "SHOW", "PRAGMA":
		rows, err := DB.Query(sql)
		if err != nil {
			return nil
		}
		defer rows.Close()
		cols, _ := rows.Columns()
		var list []map[string]any
		for rows.Next() {
			values := make([]any, len(cols))
			ptrs := make([]any, len(cols))
			for i := range values {
				ptrs[i] = &values[i]
			}
			if err := rows.Scan(ptrs...); err != nil {
				return nil
			}
			m := make(map[string]any, len(cols))
			for i, c := range cols {
				m[c] = values[i]
			}
			list = append(list, m)
		}
		if len(list) == 0 {
			return &Result{Ok: false}
		}
		return &Result{Rows: list, Ok: true}
	case "INSERT":
		res, err := DB.Exec(sql)
		if err != nil {
			return nil
		}
		id, _ := res.LastInsertId()
		return &Result{LastID: id, Ok: id > 0}
	case "UPDATE", "DELETE":
		res, err := DB.Exec(sql)
		if err != nil {
			return nil
		}
		n, _ := res.RowsAffected()
		return &Result{Affected: n, Ok: n > 0}
	default: // CREATE / ALTER / DROP / INDEX / 其他
		if _, err := DB.Exec(sql); err != nil {
			return nil
		}
		return &Result{Ok: true}
	}
}