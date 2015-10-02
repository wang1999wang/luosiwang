document.documentElement.onclick = function (e) {
    e = window.event ? window.event : e;
    var e_tar = e.srcElement ? e.srcElement : e.target;

    if (e_tar.id == "wwwluosicomtowcode") {
        return;
    }
    else {
        $("#two_code_open").hide();
    }

}

function ToggleTwoDimensionCode() {
    $("#fb_open").hide();
    $("#two_code_open").show();
}

function ToggleFeedback() {
    $("#two_code_open").hide();
    $("#fb_open").toggle();
}


$(document).ready(function () {
    
    $("#fb_open").mouseleave(function () {
        $("#fb_open").hide();
    });

    $("#two_code_open").mouseleave(function () {
        $("#two_code_open").hide();
    });


    /*提交意见反馈内容开始*/
    $("input[name='submitfeekback']").click(function () {
        var content = $("textarea[name='feedbackCnt']").val();
        if (trim(content) == "" || content == "提示：如果您希望反馈的内容得到华人螺丝网回复，请留下您的联系方式，谢谢!") {
            $("#errorTips").removeClass();
            $("#errorTips").addClass("onError");
            $("#errorTips").html("请输入您的意见或建议");
        }
        else {
            if (!checkByteLength(trim(content), 8, 400)) {
                $("#errorTips").removeClass();
                $("#errorTips").addClass("onError");
                $("#errorTips").html("请输入4-200字以内的内容");
                return false;
            }
            else {
                $.ajax({
                    async: false,
                    cache: false,
                    timeout: 6E4,
                    type: "post",
                    url: "/Ajax/OfficeAjaxPage.aspx?t=addfeedback",
                    data: { MesContent: content },
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (data) {
                        if (data == null) {
                            $("#errorTips").removeClass();
                            $("#errorTips").addClass("onError");
                            $("#errorTips").html("服务器繁忙，请稍候重试...");
                        }
                        else {
                            if (data.status.code == "1001") {
                                alert("反馈已发送！谢谢您对华网的支持！");
                                $("#fb_open").hide();
                                $("#errorTips").removeClass();
                                $("#errorTips").html("");
                            }
                            else {
                                $("#errorTips").removeClass();
                                $("#errorTips").addClass("onError");
                                $("#errorTips").html(data.status.msg);
                            }
                        }
                    },
                    error: function () {
                        $("#errorTips").removeClass();
                        $("#errorTips").addClass("onError");
                        $("#errorTips").html("程序错误，请联系华网客服");
                    }
                });
            }
        }
    });

    /*提交意见反馈内容结束*/

});