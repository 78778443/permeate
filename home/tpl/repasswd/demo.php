<link rel="stylesheet" href="./resource/styles/repasswd.css">
<div id="doc3">
    <div class="wrap-content findpwd-one-step">
        <div class="content-title">
            输入帐号
        </div>
        <div class="content-main">
            <div class="con-wrap">
                <form class="check-account-form">
                    <p class="account-tip">请输入注册的手机号/邮箱/用户名</p>
                    <ul>
                        <li class="account-item gray-outline">
							<span class="quc-fixIe6margin">
								<label class="account-icon">
								</label>
							</span>
                            <span class="input-bg">
								<input type="text" name="account" class="outline-input text-long"
                                       placeholder="手机号/邮箱/用户名">
							</span>
                        </li>
                        <li class="tip-info account-info"></li>
                        <li class="account-item">
							<span class="input-bg gray-outline">
								<input type="text" name="captcha" class="outline-input text-short"
                                       placeholder="请输入图片中的数字或字母">
							</span>
                            <img data-src="http://passport.360.cn/captcha.php?m=create&amp;app=i360&amp;scene=findpwd&amp;userip=&amp;level=default&amp;sign=d6fc05&amp;r=1497539354&amp;r=1497539354"
                                 src="http://passport.360.cn/captcha.php?m=create&amp;app=i360&amp;scene=findpwd&amp;userip=&amp;level=default&amp;sign=d6fc05&amp;r=1497539354&amp;r=1497539354"
                                 class="code pic-refresh" height="34" width="95">
                        </li>
                        <span class="tip-info captcha-info"></span>
                        <li class="account-item">
                            <span class="findpwd-btn check-account">下一步</span>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <div class="wrap-content findpwd-two-step none">
        <div class="content-title">
            验证身份
        </div>
        <div class="content-main">
            <div class="con-wrap">
                <div class="choose-findpwd-type">
                    <p>您正在为帐号<span class="user-account"></span>找回密码,为了保护帐号安全，需要验证身份</p>
                    <ul>
                        <li class="account-item gray-outline clearfix">
							<span class="icon-wrap quc-fixIe6margin">
								<label class="check-icon go-complaint-icon">
								</label>
							</span>
                            <span class="check-type-info">
								通过人工申诉来找回密码
							</span>
                            <a href="http://i.360.cn/complaint?sb_param=10f95f012fb2e85ededa7e83e9c1f9c4"
                               class="begain-check" target="_blank">
                                立即申诉
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap-content none findpwd-three-step">
        <div class="mobile-way sec-ways none">
            <div class="content-title">
                验证密保手机
            </div>
            <div class="content-main">
                <div class="con-wrap">
                    <div class="choose-mobile-type">
                        <p class="mobile-type-tip">短信验证码已发送至<span class="user-account"></span></p>
                        <p class="sms-token-field">
                            <span href="#" class="get-sms-token">重新发送</span>
                            <span class="input-bg gray-outline">
								<input type="text" name="smsToken" class="outline-input text-short"
                                       placeholder="请输入短信验证码" maxlength="6">
							</span>
                            <span class="tip-info smsToken-info"></span>
                        </p>
                        <p class="sms-token-btn">
                            <span class="findpwd-btn check-sms-token">下一步</span>
                        </p>
                        <p class="sms-token-tip clearfix">
                            <a href="http://i.360.cn/findpwd/customerhelper#recievemobilecode" title="短信验证码没收到"
                               class="link no-sms-token" target="_blank">短信验证码没收到</a>
                            <a href="" title="" class="link mobile-type-back go-back">选择其他验证方式</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="email-way sec-ways none">
            <div class="content-title">
                邮箱验证
            </div>
            <div class="content-main">
                <div class="con-wrap">
                    <div class="choose-email-type">
                        <p class="send-email-bg">
                            <span class="send-email-icon"></span>
                        </p>
                        <p class="email-type-tip">设置新密码的链接已经发送至<span class="user-account"></span></p>
                        <p class="send-email-tip">请您在48小时之内登录邮箱，点击邮箱内链接设置新密码</p>
                        <p class="emal-type-btn">
                            <a href="#" class="findpwd-btn email-url" target="_blank">去邮箱收信</a>
                            <span class="findpwd-btn email-type-back go-back">返回</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="question-way sec-ways none">
            <div class="content-title">
                安全验证
            </div>
            <div class="content-main">
                <div class="con-wrap">
                    <div class="choose-question-type">
                        <p class="question-tip">请填写您设置的密保问题的答案</p>
                        <p>
                            <label for="#" class="k">密保问题：</label>
                            <span class="question-text"><em class="sec-way-value"></em></span>
                        </p>
                        <p>
							<span class="question-input input-bg gray-outline">
								<input type="text" name="answer" class="outline-input text-short" placeholder="请输入答案">
							</span>
                            <label for="#" class="k">您的答案：</label>
                            <span class="tip-info answer-info">
								<em class="gray error-info"></em>
							</span>
                        </p>
                        <p>
                            <span class="findpwd-btn check-sec-question">下一步</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="wrap-content findpwd-four-step none">
        <div class="content-title">
            设置新密码
        </div>
        <div class="content-main">
            <div class="con-wrap">
                <div class="set-new-password">
                    <p class="set-password-tip">密码长度8-20位，建议字母、数字与标点的组合来提高帐号安全度</p>
                    <p class="set-new-password">
						<span class="input-bg gray-outline">
							<input type="password" name="password" class="outline-input password-input"
                                   placeholder="请输入密码">
						</span>
                        <span class=" account-info"></span>
                        <span class="tip-info password-info">
							<em class="gray error-info"></em>
						</span>
                    </p>
                    <p class="check-new-password">
						<span class="input-bg gray-outline">
							<input type="password" name="passwordAgain" class="outline-input password-input"
                                   placeholder="请再次确认密码">
						</span>
                        <span class="tip-info passwordAgain-info">
							<em class="gray error-info"></em>
						</span>
                    </p>

                    <span class="findpwd-btn set-password">
						提交
					</span>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap-content findpwd-succeed none" style="z-index:110001;">
        <div class="content-title">修改密码成功
        </div>
        <div class="content-main">
            <p><span class="reg-succeed-icon"></span></p>
            <p>恭喜！您已成功修改了帐号的登录密码</p>
        </div>
    </div>
</div>