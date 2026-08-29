package handler

import (
	"strconv"
)

// toAdmin 判断登录用户是否管理员（bbs_user.admins==1）
func toAdmin(u map[string]any) int64 {
	if u == nil {
		return 0
	}
	return toIntAny(u["admins"])
}

// toIntAny 通用 int64 转换
func toIntAny(v any) int64 {
	switch t := v.(type) {
	case int64:
		return t
	case int:
		return int64(t)
	case float64:
		return int64(t)
	case string:
		n, _ := strconv.ParseInt(t, 10, 64)
		return n
	}
	return 0
}

// toStrAny 通用字符串转换（兼容 DB int64/[]byte 与 session JSON float64）
func toStrAny(v any) string {
	switch t := v.(type) {
	case nil:
		return ""
	case string:
		return t
	case []byte:
		return string(t)
	case int64:
		return strconv.FormatInt(t, 10)
	case int:
		return strconv.Itoa(t)
	case int32:
		return strconv.FormatInt(int64(t), 10)
	case float64:
		if t == float64(int64(t)) {
			return strconv.FormatInt(int64(t), 10)
		}
		return strconv.FormatFloat(t, 'f', -1, 64)
	case bool:
		if t {
			return "1"
		}
		return "0"
	}
	return ""
}