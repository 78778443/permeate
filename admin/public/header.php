<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Permeate 后台管理</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-50: #eef2ff;
            --primary-100: #e0e7ff;
            --primary-500: #6366f1;
            --primary-600: #4f46e5;
            --primary-700: #4338ca;
            --sidebar-width: 260px;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        * { box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--gray-100);
            min-height: 100vh;
            font-size: 14px;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--gray-900);
            z-index: 1030;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .sidebar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 0;
        }

        .nav-section {
            padding: 8px 24px;
            font-size: 11px;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 8px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 24px;
            color: var(--gray-400);
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            text-decoration: none;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: white;
            border-left-color: var(--primary-500);
        }

        .sidebar-nav .nav-link.active {
            background: rgba(99, 102, 241, 0.15);
            color: white;
            border-left-color: var(--primary-500);
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 15px;
        }

        .sidebar-nav .nav-link .badge {
            margin-left: auto;
            font-size: 10px;
            padding: 3px 8px;
        }

        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-footer .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 0;
            color: var(--gray-400);
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .sidebar-footer .nav-link:hover {
            color: var(--danger);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 16px 24px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Content Area */
        .content-wrapper {
            flex: 1;
            padding: 24px;
        }

        /* Cards */
        .card {
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--gray-100);
            padding: 16px 20px;
            font-weight: 600;
            font-size: 15px;
            color: var(--gray-800);
            border-radius: 16px 16px 0 0 !important;
        }

        /* Tables */
        .table {
            margin-bottom: 0;
            font-size: 15px;
        }

        .table thead th {
            background-color: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            font-weight: 600;
            color: var(--gray-600);
            padding: 14px 18px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table tbody td {
            padding: 16px 18px;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-100);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: var(--primary-50);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary-600);
            border-color: var(--primary-600);
        }

        .btn-primary:hover {
            background: var(--primary-700);
            border-color: var(--primary-700);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary-600);
            border-color: var(--primary-300);
        }

        .btn-outline-primary:hover {
            background: var(--primary-600);
            border-color: var(--primary-600);
            color: white;
        }

        .btn-outline-danger {
            color: var(--danger);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .btn-outline-danger:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
        }

        .btn-outline-success {
            color: var(--success);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .btn-outline-success:hover {
            background: var(--success);
            border-color: var(--success);
            color: white;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 6px;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .badge.bg-danger { background: rgba(239, 68, 68, 0.15); color: var(--danger); }
        .badge.bg-warning { background: rgba(245, 158, 11, 0.15); color: #b45309; }
        .badge.bg-info { background: rgba(6, 182, 212, 0.15); color: #0891b2; }
        .badge.bg-secondary { background: var(--gray-100); color: var(--gray-600); }
        .badge.bg-success { background: rgba(16, 185, 129, 0.15); color: var(--success); }

        /* Forms */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid var(--gray-300);
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-400);
            box-shadow: 0 0 0 3px var(--primary-100);
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 13px;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #92400e;
        }

        .alert-warning h6 {
            color: #92400e;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="/" class="sidebar-brand">
                <span class="brand-icon"><i class="fas fa-shield-alt"></i></span>
                <span>Permeate</span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">导航</div>
            <a href="../index.php" class="nav-link">
                <i class="fas fa-home"></i>前台首页
            </a>

            <div class="nav-section">用户管理</div>
            <a href="<?=U('user/lists')?>" class="nav-link">
                <i class="fas fa-users"></i>用户列表
            </a>

            <div class="nav-section">内容管理</div>
            <a href="?m=part&a=lists" class="nav-link">
                <i class="fas fa-layer-group"></i>分区管理
            </a>
            <a href="?m=cate&a=lists" class="nav-link">
                <i class="fas fa-th-large"></i>版块管理
            </a>
            <a href="?m=post&a=lists" class="nav-link">
                <i class="fas fa-file-alt"></i>帖子管理
            </a>
            <a href="?m=reply&a=lists" class="nav-link">
                <i class="fas fa-comments"></i>回帖管理
            </a>
            <a href="?m=reply&a=list_pb" class="nav-link">
                <i class="fas fa-ban"></i>屏蔽回帖
            </a>

            <div class="nav-section">系统设置</div>
            <a href="?m=fri&a=lists" class="nav-link">
                <i class="fas fa-link"></i>友情链接
            </a>
            <a href="?m=ipre&a=lists" class="nav-link">
                <i class="fas fa-shield-alt"></i>IP黑名单
            </a>
            <a href="?m=fil&a=lists" class="nav-link">
                <i class="fas fa-filter"></i>敏感词过滤
            </a>
            <a href="?m=manage&a=lists" class="nav-link">
                <i class="fas fa-cog"></i>网站设置
            </a>

            <div class="nav-section">高级功能</div>
            <a href="?m=backup&a=index" class="nav-link">
                <i class="fas fa-database"></i>数据库备份
                <span class="badge bg-danger">RCE</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="<?=U('public/logout')?>" class="nav-link">
                <i class="fas fa-sign-out-alt"></i>退出登录
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-secondary d-lg-none" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h5 class="mb-0 d-none d-lg-block fw-semibold">后台管理系统</h5>
            <div class="d-flex align-items-center gap-3">
                <a href="/" class="btn btn-outline-primary btn-sm" target="_blank">
                    <i class="fas fa-external-link-alt"></i>访问前台
                </a>
            </div>
        </header>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
