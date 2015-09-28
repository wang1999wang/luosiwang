(function (a) {
    var uiv = {};
    if (window.ECommerce) uiv = window.ECommerce;
    uiv.userObj = {//判断会员是否已经登录
        User_IsLogin: function () {
            var e = true;
            $.ajax({
                async: false,
                timeout: 6E4,
                type: "post",
                url: "/Ajax/AjaxPage.aspx?t=checkislogin",
                dataType: "json",
                success: function (data) {
                    if (data == null) { alert('网络超时！'); e = false; }
                    if (data.status.code == "1001") {
                        current_user_id = data.result.memberid;
                        Luosi.current_user.id = data.result.memberid;
                        Luosi.current_user.membertype = data.result.membertype;
                        e = true;
                    } else {
                        e = false;
                    }
                },
                error: function (a, b) {
                    if (b == "timeout") {
                        alert('网络超时！');
                    }
                    e = false;
                }
            });
            return e;
        },
        User_Login_Popup_Init: function (b) {
            $("#popup_box_login").remove();
            $(".light_box_fullbg").remove();
            $("body").append('<div class="light_box_fullbg"></div>');
            b = template.popup_login_template;
            $("body").append(b);
            $("#popup_box_login").css("width", 365);
            var c = $(window).width(), e = $("#popup_box_login").width(), d = (c - e) / 2 + "px";
            $("#popup_box_login").show();
            if ($.browser.msie && $.browser.version == "6.0") {
                var f = $(document).height(), g = (document.documentElement.scrollTop || document.body.scrollTop) + Math.round(20 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + "px";
                $("#popup_box_login").css({ position: "absolute", left: d, top: g });
                $(".light_box_fullbg").css("height", f);
                $(window).scroll(function () {
                    g = (document.documentElement.scrollTop || document.body.scrollTop) + Math.round(20 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + "px";
                    $("#popup_box_login").css("top", g);
                    $(".light_box_fullbg").css("height", f);
                });
            } else {
                $("#popup_box_login").css({ position: "fixed", left: d, top: "30%" });
                $(window).resize(function () {
                    c = $(window).width();
                    e = $("#popup_box_login").width();
                    d = (c - e) / 2 + "px";
                    $("#popup_box_login").css("left", d)
                });
            }
            $("#popup_box_login .close").live("click", function () { $("#popup_box_login").remove(); $("div.light_box_fullbg").remove(); });
        },
        User_Login_Popup_Form_Init: function (b) {
            var e = $("#popup_box_login .error");
            var c = $("#popup_box_login input[name='membername']");
            var d = $("#popup_box_login input[name='memberpassword']");
            c.focus();
            c.focus(function () { if (c.val() == '登录名 或 邮箱') { c.val(""); } });
            c.blur(function () { if (trim(c.val()) == "") { c.val('登录名 或 邮箱'); } });
            d.blur(function () { if (trim(d.val()) == '') { e.html('请输入密码'); } });
            c.keyup(function (event) { if (event.keyCode == "13") { uiv.userObj.User_Login__Popup_Form_Valida(); } });
            d.keyup(function (event) { if (event.keyCode == "13") { uiv.userObj.User_Login__Popup_Form_Valida(); } });
            // $("#popup_box_login .submit").click(function () { alert('sdf'); uiv.userObj.User_Login__Popup_Form_Valida(); });
            $("#popup_box_login .submit").bind("click", function () { uiv.userObj.User_Login__Popup_Form_Valida(); });
        },
        User_Login__Popup_Form_Valida: function (b) {
            var c = $("#popup_box_login input[name='membername']");
            var d = $("#popup_box_login input[name='memberpassword']");
            var e = c.val();
            var f = d.val();
            if (trim(e) == "" || $.trim(e) == '登录名 或 邮箱') {
                $("#popup_box_login .error").text('请输入用户名');
                c.focus();
                return false;
            }
            if (trim(f) == "") {
                $("#popup_box_login .error").text('请输入密码');
                d.focus();
                return false;
            }
            var h = $("#popup_box_login :checkbox").attr("checked");
            $("#popup_box_login .error").text('登录中，请稍后...');
            h = uiv.userObj.User_Login(e, f, h);
            if (h == true) {
                $("#companyinfo").hide();
                $(".LoginContent").replaceWith('<div class="LoginContent">登录成功<div>');

                setTimeout(function () {
                    $("div.LoginWinBoxWrap").fadeOut("3000");
                    $("div.light_box_fullbg").fadeOut("3000");
                    //
                    if ($("#popup_box_login_success").size() != 0) {
                        PopupBoxLoginSuccess();
                    }
                    //
                    b && window.location.reload()
                }, 1E3);

            } else {
                $("#popup_box_login .error").text(h);
            }
        },
        User_Login__Popup_Form_Post: function () {
            var c = $("#popup_box_login input[name='membername']");
            var d = $("#popup_box_login input[name='memberpassword']");
            var e = c.val();
            var f = d.val();
            if (trim(e) == "" || $.trim(e) == '登录名 或 邮箱') {
                $("#popup_box_login .error").text('请输入用户名');
                c.focus();
                return false;
            }
            if (trim(f) == "") {
                $("#popup_box_login .error").text('请输入密码');
                d.focus();
                return false;
            }
            var h = $("#popup_box_login :checkbox").attr("checked");
            $("#popup_box_login .error").text('登录中，请稍后...');

            h = uiv.userObj.User_Login(e, f, h);
            if (h == true) {
                $("div.LoginWinBoxWrap").hide();
                $("div.light_box_fullbg").hide();
                return true;

            } else {
                $("#popup_box_login .error").text(h);
                return false;
            }

        },
        User_Login: function (b, c, d) {
            var e = false;
            $.ajax({
                async: false,
                type: "post",
                timeout: 6E4,
                url: "/Ajax/AjaxPage.aspx?t=memberlogin",
                data: { membername: b, memberpassword: c, savestate: d },
                dataType: "json",
                success: function (data) {
                    if (data == null) { e = '网络超时！'; }
                    if (data.status.code == "1001") {
                        current_user_id = data.result.memberid;
                        Luosi.current_user.id = data.result.memberid;
                        Luosi.current_user.membertype = data.result.membertype;
                        e = true;


                    } else {
                        e = data.status.msg;
                    }
                },
                error: function (a, b) {
                    if (b == "timeout") {
                        e = '网络超时！';
                    }
                    e = '参数问题';
                }
            });
            return e;
        }
    }
})(jQuery);



