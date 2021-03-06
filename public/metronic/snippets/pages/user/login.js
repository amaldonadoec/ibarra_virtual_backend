var SnippetLogin = function () {
    var e = $("#m_login"), i = function (e, i, a) {
        var r = $('<div class="m-alert m-alert--outline alert alert-' + i + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
        e.find(".alert").remove(), r.prependTo(e), r.animateClass("fadeIn animated"), r.find("span").html(a)
    }, a = function () {
        e.removeClass("m-login--forget-password"), e.removeClass("m-login--signup"), e.addClass("m-login--signin"), e.find(".m-login__signin").animateClass("flipInX animated")
    }, r = function () {
        $("#m_login_forget_password").click(function (i) {
            i.preventDefault(), e.removeClass("m-login--signin"), e.removeClass("m-login--signup"), e.addClass("m-login--forget-password"), e.find(".m-login__forget-password").animateClass("flipInX animated")
        }), $("#m_login_forget_password_cancel").click(function (e) {
            e.preventDefault(), a()
        }), $("#m_login_signup").click(function (i) {
            i.preventDefault(), e.removeClass("m-login--forget-password"), e.removeClass("m-login--signin"), e.addClass("m-login--signup"), e.find(".m-login__signup").animateClass("flipInX animated")
        }), $("#m_login_signup_cancel").click(function (e) {
            e.preventDefault(), a()
        })
    };
    return {
        init: function () {
            r(), $("#m_login_signin_submit").click(function (e) {
                e.preventDefault();
                var a = $(this), r = $(this).closest("form");
                r.validate({
                    rules: {
                        email: {required: !0, email: !0},
                        password: {required: !0}
                    }
                }), r.valid() && (a.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), r.ajaxSubmit({
                    url: "",
                    success: function (e, l, t, s) {
                        setTimeout(function () {
                            a.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), i(r, "danger", "Incorrect username or password. Please try again.")
                        }, 2e3)
                    }
                }))
            }), $("#m_login_signup_submit").click(function (r) {
                r.preventDefault();
                var l = $(this), t = $(this).closest("form");
                t.validate({
                    rules: {
                        fullname: {required: !0},
                        email: {required: !0, email: !0},
                        password: {required: !0},
                        rpassword: {required: !0},
                        agree: {required: !0}
                    }
                }), t.valid() && (l.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), t.ajaxSubmit({
                    url: "",
                    success: function (r, s, n, o) {
                        setTimeout(function () {
                            l.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), t.clearForm(), t.validate().resetForm(), a();
                            var r = e.find(".m-login__signin form");
                            r.clearForm(), r.validate().resetForm(), i(r, "success", "Thank you. To complete your registration please check your email.")
                        }, 2e3)
                    }
                }))
            }), $("#m_login_forget_password_submit").click(function (r) {
                r.preventDefault();
                var l = $(this), t = $(this).closest("form");
                t.validate({
                    rules: {
                        email: {
                            required: !0,
                            email: !0
                        }
                    }
                }), t.valid() && (l.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0), t.ajaxSubmit({
                    url: "",
                    success: function (r, s, n, o) {
                        setTimeout(function () {
                            l.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1), t.clearForm(), t.validate().resetForm(), a();
                            var r = e.find(".m-login__signin form");
                            r.clearForm(), r.validate().resetForm(), i(r, "success", "Cool! Password recovery instruction has been sent to your email.")
                        }, 2e3)
                    }
                }))
            })
        }
    }
}();
jQuery(document).ready(function () {
    SnippetLogin.init()
});