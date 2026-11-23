<footer class="footer">
    <div class="container">
        <div class="footer-main">
            <div class="footer-brand-col">
                <div class="footer-brand">
                    <span class="brand-icon"><i class="fas fa-shield-alt"></i></span>
                    Permeate <span class="fw-normal text-muted">v1.0</span>
                </div>
                <p>面向 Web 安全教学的 PHP 漏洞靶场，内置 8 类常见漏洞与完整后台，安装后即可开始练习。</p>
            </div>

            <nav class="footer-links" aria-label="页脚导航">
                <a href="/home/index.php">首页</a>
                <a href="/home/index.php#range-zones">靶场分区</a>
                <a href="/home/search.php">搜索</a>
                <a href="/admin/public/login.php">后台管理</a>
                <a href="https://github.com/78778443/permeate" target="_blank" rel="noopener">GitHub</a>
                <a href="https://github.com/78778443/permeate/blob/master/doc/VULNERABILITIES.md" target="_blank" rel="noopener">漏洞清单</a>
            </nav>

            <div class="footer-note">
                <span class="warn"><i class="fas fa-exclamation-triangle"></i>仅供学习研究使用</span>
                本系统故意包含安全漏洞，请部署在隔离的内网环境中，切勿暴露到公网。
            </div>
        </div>

        <div class="footer-bottom">
            <span>© 2017–2026 汤青松 · MIT License · 微信 songboy8888</span>
            <span>PHP + SQLite · 零配置启动</span>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="/public/vendor/bootstrap-5.3.2/bootstrap.bundle.min.js"></script>

<script>
    var _hmt = _hmt || [];
    (function() {
        // 本地/离线部署时不加载外部统计，避免无谓的失败请求
        if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') return;
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?f0092c8ab65af74302f93fa3f4d78101";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

</body>
</html>
