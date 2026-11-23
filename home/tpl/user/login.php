<section class="auth-page">
    <div class="container">
        <div class="auth-shell">
            <aside class="auth-aside">
                <div class="aside-brand">
                    <span class="brand-icon"><i class="fas fa-shield-alt"></i></span>
                    Permeate
                </div>

                <div>
                    <h3>把 8 类漏洞，<br>亲手打一遍。</h3>
                    <p class="lead">从 SQL 注入到 SSRF，配套原理教程与实战版块。登录后即可发帖、回复，记录你的练习过程。</p>
                </div>

                <div class="aside-vulns">
                    <div class="aside-vuln"><span class="idx">01</span><span class="name">SQL 注入</span><span class="sev sev-high">高危</span></div>
                    <div class="aside-vuln"><span class="idx">02</span><span class="name">XSS 跨站</span><span class="sev sev-high">高危</span></div>
                    <div class="aside-vuln"><span class="idx">03</span><span class="name">命令执行</span><span class="sev sev-critical">严重</span></div>
                    <div class="aside-vuln"><span class="idx">04</span><span class="name">文件上传</span><span class="sev sev-high">高危</span></div>
                    <div class="aside-vuln"><span class="idx">05</span><span class="name">密码找回</span><span class="sev sev-medium">中危</span></div>
                    <div class="aside-vuln"><span class="idx">06</span><span class="name">越权访问</span><span class="sev sev-medium">中危</span></div>
                    <div class="aside-vuln"><span class="idx">07</span><span class="name">SSRF 漏洞</span><span class="sev sev-high">高危</span></div>
                    <div class="aside-vuln"><span class="idx">08</span><span class="name">验证码绕过</span><span class="sev sev-low">低危</span></div>
                </div>

                <div class="aside-foot">
                    <i class="fas fa-exclamation-triangle"></i>
                    仅供学习研究使用，请部署在隔离的内网环境
                </div>
            </aside>

            <main class="auth-container">
                <div class="auth-header">
                    <h2>欢迎回来</h2>
                    <p>登录后即可发帖与参与讨论</p>
                </div>

                <div class="auth-card">
                    <form action="./public/login.php" method="post">
                        <div class="mb-3">
                            <label class="form-label" for="login-username">账号</label>
                            <input class="form-control" id="login-username" type="text" name="username" maxlength="16" placeholder="请输入账号" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="login-password">密码</label>
                            <input class="form-control" id="login-password" type="password" name="password" maxlength="16" placeholder="请输入密码" required>
                        </div>

                        <button class="btn btn-primary btn-lg w-100" type="submit">
                            <i class="fas fa-sign-in-alt"></i>登录
                        </button>
                    </form>

                    <div class="auth-divider"><span>还没有账号</span></div>

                    <a class="btn btn-ghost w-100" href="./index.php?m=user&a=register">
                        <i class="fas fa-rocket"></i>注册一个学习账号
                    </a>
                </div>

                <div class="auth-points">
                    <span><i class="fas fa-check-circle"></i>8 个练习版块</span>
                    <span><i class="fas fa-check-circle"></i>19 篇实战教程</span>
                    <span><i class="fas fa-check-circle"></i>完整后台管理</span>
                </div>
            </main>
        </div>
    </div>
</section>
