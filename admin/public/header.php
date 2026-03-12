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
    <!-- Custom Styles -->
    <link href="/home/resource/dist/style.css" rel="stylesheet">
    <style>
        body {
            padding-left: 220px;
        }
        .left-nav {
            top: 0;
            padding-top: 70px;
        }
        .navbar {
            padding: 0.75rem 1rem;
        }
        .admin-content {
            padding: 20px;
        }
        table tr > td:first-child {
            width: 120px;
            font-weight: 500;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <i class="fas fa-shield-alt me-2"></i>Permeate
        </a>

        <div class="ms-auto">
            <a class="btn btn-outline-primary btn-sm" target="_parent" href="./index.php?m=user&a=logout">
                <i class="fas fa-sign-out-alt me-1"></i>退出登录
            </a>
        </div>
    </div>
</nav>

<!-- 左侧导航 -->
<div class="left-nav">
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action" href="/admin/index.php">
            <i class="fas fa-tachometer-alt me-2"></i>后台首页
        </a>
        <a class="list-group-item list-group-item-action" href="/admin/index.php?m=user&a=list">
            <i class="fas fa-users me-2"></i>用户管理
        </a>
        <a class="list-group-item list-group-item-action" href="/admin/index.php?m=part&a=list">
            <i class="fas fa-folder me-2"></i>分区管理
        </a>
        <a class="list-group-item list-group-item-action" href="/admin/index.php?m=cate&a=list">
            <i class="fas fa-th-large me-2"></i>版块管理
        </a>
        <a class="list-group-item list-group-item-action" href="/admin/index.php?m=post&a=list">
            <i class="fas fa-file-alt me-2"></i>帖子管理
        </a>
        <a class="list-group-item list-group-item-action" href="/admin/index.php?m=reply&a=list">
            <i class="fas fa-comments me-2"></i>回复管理
        </a>
        <a class="list-group-item list-group-item-action" href="/admin/index.php?m=fil&a=list">
            <i class="fas fa-filter me-2"></i>敏感词管理
        </a>
        <a class="list-group-item list-group-item-action" href="/admin/index.php?m=ipre&a=list">
            <i class="fas fa-ban me-2"></i>IP黑名单
        </a>
        <a class="list-group-item list-group-item-action" href="/admin/index.php?m=fri&a=list">
            <i class="fas fa-link me-2"></i>友情链接
        </a>
    </div>
</div>

<section class="section" style="padding-top: 20px; padding-bottom: 0;">
    <div class="container-fluid">
