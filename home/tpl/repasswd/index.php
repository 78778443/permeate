<link rel="stylesheet" href="./resource/styles/repasswd.css">
<div id="doc3">
    <div class="wrap-content findpwd-one-step">
        <div class="content-title">
            找回密码
        </div>
        <div class="content-main">
            <div class="con-wrap">
                <form class="check-account-form" action="/home/index.php?m=repasswd&a=_index" method="post">
                    <p class="account-tip">请输入注册的手机号/邮箱/用户名</p>
                    <ul>
                        <li class="account-item gray-outline">
							<span class="quc-fixIe6margin">
								<label class="account-icon">
								</label>
							</span>
                            <span class="input-bg">
								<input type="text" name="username" class="outline-input text-long"
                                       placeholder="手机号/邮箱/用户名">
							</span>
                        </li>
                        <li class="tip-info account-info"></li>
                        <li class="account-item">
							<span class="input-bg gray-outline">
								<input type="text" name="yzm" class="outline-input text-short"
                                       placeholder="请输入图片中的数字或字母">
							</span>
                            <img src="/includes/yzm_func.php"
                                 class="code pic-refresh" height="34" width="95">
                        </li>
                        <span class="tip-info captcha-info"></span>
                        <li class="account-item">
                            <input type="submit" class="findpwd-btn check-account" value="下一步">
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>