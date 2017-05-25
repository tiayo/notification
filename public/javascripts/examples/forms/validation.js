
$(function() {

    "use strict";

    //INLINE VALIDATION
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $("#inline-validation").validate({

        highlight: function(label) {
            $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(label) {
            $(label).closest('.form-group').removeClass('has-error');
            label.remove();
        },

        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 8
            },
            username: {
                required: true,
                minlength: 2,
                maxlength: 8
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4,
                maxlength: 10
            },
            'confirmation': {
                required: true,
                minlength: 4,
                maxlength: 10,
                equalTo: "#password"
            },
            age: {
                required: true,
                number: true,
                range: [18, 100]
            },
            url: {
                url: true
            }
        }
    });

    //MESSAGE BOX VALIDATION
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    var form = $("#messagebox-validation");

    $("#messagebox-validation").validate({

        errorContainer: form.find('.message-container'),
        errorLabelContainer: form.find('.message-container ul'),
        wrapper: 'li',

        rules: {
            title: {
                required: true
            },
            start_time: {
                required: true,
                email: true
            },
            plan: {
                required: true
            },
            phone: {
                required: true
            },
            email: {
                required: true
            },
            content: {
                required: true
            }
        },

        messages: {
            title: {
                required: "请输入标题！"
            },
            start_time: {
                required: "请选择提醒时间！"
            },
            plan: {
                required: "请选择计划！"
            },
            phone: {
                required: "请输入接收提醒的手机号码！"
            },
            email: {
                required: "请输入接收提醒的邮箱！",
                email: "请输入有效的邮箱！"
            },
            content: {
                required: "请输入提醒的内容！"
            }
        }
    });
});

