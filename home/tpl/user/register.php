<section class="auth-page">
    <div class="container">
        <div class="auth-shell">
            <aside class="auth-aside">
                <div class="aside-brand">
                    <span class="brand-icon"><i class="fas fa-shield-alt"></i></span>
                    Permeate
                </div>

                <div>
                    <h3>从第一条漏洞，<br>开始你的靶场记录。</h3>
                    <p class="lead">注册后可以发布练习笔记、回复讨论、上传头像，并在个人中心管理自己的学习资料。</p>
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
                    <h2>创建账号</h2>
                    <p>加入安全学习社区，开始动手练习</p>
                </div>

                <div class="auth-card">
                    <form action="./public/reg.php" method="post">
                        <div class="mb-3">
                            <label class="form-label" for="reg-username">账号</label>
                            <input class="form-control" id="reg-username" type="text" name="username" maxlength="16" placeholder="请输入账号" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="reg-password">密码</label>
                            <input class="form-control" id="reg-password" type="password" name="password" maxlength="16" placeholder="请输入密码" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="reg-repass">确认密码</label>
                            <input class="form-control" id="reg-repass" type="password" name="repass" maxlength="16" placeholder="请再次输入密码" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="reg-email">邮箱</label>
                            <input class="form-control" id="reg-email" type="email" name="email" maxlength="32" placeholder="请输入邮箱" required>
                        </div>

                        <button class="btn btn-primary btn-lg w-100" type="submit">
                            <i class="fas fa-rocket"></i>开始学习
                        </button>
                    </form>

                    <div class="auth-divider"><span>已有账号</span></div>

                    <a class="btn btn-ghost w-100" href="./index.php?m=user&a=login">
                        <i class="fas fa-sign-in-alt"></i>直接用账号登录
                    </a>
                </div>

                <div class="auth-points">
                    <span><i class="fas fa-check-circle"></i>免费注册</span>
                    <span><i class="fas fa-check-circle"></i>无需邮箱验证</span>
                    <span><i class="fas fa-check-circle"></i>数据保存在本地</span>
                </div>
            </main>
        </div>
    </div>
</section>
