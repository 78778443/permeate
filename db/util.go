package db

import "fmt"

// Int 从 any 值提取 int64
func Int(v any) int64 {
	switch t := v.(type) {
	case int64:
		return t
	case int:
		return int64(t)
	case int32:
		return int64(t)
	case float64:
		return int64(t)
	case []byte:
		return int64(len(t))
	}
	return 0
}

// Str 从 any 值提取字符串
func Str(v any) string {
	switch t := v.(type) {
	case nil:
		return ""
	case string:
		return t
	case []byte:
		return string(t)
	case int64:
		return itoa(t)
	case int:
		return itoa(int64(t))
	case float64:
		if t == float64(int64(t)) {
			return itoa(int64(t))
		}
		return fmtSprint(t)
	case bool:
		if t {
			return "1"
		}
		return "0"
	}
	return fmtSprint(v)
}

func itoa(n int64) string {
	if n == 0 {
		return "0"
	}
	neg := n < 0
	if neg {
		n = -n
	}
	var b [20]byte
	i := len(b)
	for n > 0 {
		i--
		b[i] = byte('0' + n%10)
		n /= 10
	}
	if neg {
		i--
		b[i] = '-'
	}
	return string(b[i:])
}

func fmtSprint(v any) string {
	return fmt.Sprintf("%v", v)
}