$(document).ready(function () {

    //加载搜索模块下拉列表数据
    //    $("#selectData").load("ajax_selectData.html");

    //搜索的下拉列表
    $(".selectBox a").attr("href", "javascript:;");

    //    $(".position").click(function () { //选择职位
    //        $("body").append("<div class='selectBox' id='boxPosition' style='display:none'></div>");
    //        $(".selectBox").hide();
    //        $("#boxPosition").html($("#selectBoxPosition").html());
    //        $("#boxPosition").css("left", GetObjPos(this).x);
    //        $("#boxPosition").css("top", GetObjPos(this).y + 21 + "px");
    //        $("#boxPosition").slideToggle();

    //        $("#boxPosition a").click(function () {
    //            $("#position").html($(this).html());
    //            $("#boxPosition").hide();
    //        });
    //    });


    //    $(".area").click(function () { //选择地区
    //        $("body").append("<div class='selectBox' id='boxArea' style='display:none'></div>");
    //        $(".selectBox").hide();
    //        $("#boxArea").html($("#selectBoxArea").html());
    //        $("#boxArea").css("left", GetObjPos(this).x);
    //        $("#boxArea").css("top", GetObjPos(this).y + 21 + "px");
    //        $("#boxArea").slideToggle();
    //        $(".hotCity").show();

    //        $(".hotCity a").click(function () {
    //            $("#area").html($(this).html());
    //            $("#boxArea").hide();
    //        });

    //        $(".spcity a").click(function () {
    //            $("#area").html($(this).html());
    //            $("#boxArea").hide();
    //            $(".city").hide();
    //        });

    //        $(".province a").click(function () {
    //            $cityName = $(this).attr("name");
    //            $(".currentCity").hide();
    //            $(".currentCity").html($("#" + $cityName).html());
    //            $(".hotCity").slideUp("slow", function () {
    //                $(".currentCity").slideDown();
    //            });

    //            $(".province a").removeClass();
    //            $(this).addClass("red bold");
    //            $(".currentCity a").click(function () {
    //                $("#area").html($(this).html());
    //                $("#boxArea").hide();
    //                $(".currentCity").hide();
    //            });
    //        });

    //    });


    //    $(".postTime").click(function () {//选择时间
    //        $("body").append("<div class='selectBox' id='boxTime' style='display:none'></div>");
    //        $(".selectBox").hide();
    //        $("#boxTime").html($("#selectBoxTime").html());
    //        $("#boxTime").css("left", GetObjPos(this).x);
    //        $("#boxTime").css("top", GetObjPos(this).y + 21 + "px");
    //        $("#boxTime").slideToggle();

    //        $("#boxTime a").click(function () {
    //            $("#postTime").html($(this).html());
    //            $("#boxTime").hide();
    //        });
    //    });

    //搜索标签切换
    $("#searchTab a").click(function () {
        $("#searchTab a").removeClass("on");
        $(this).addClass("on");
        if ($(this).html() == "找工作") {
            $(".key").val("职位搜索：请输入公司或职位名称");
            document.getElementById("jobKey").defaultValue = "职位搜索：请输入公司或职位名称";
            $("#Type").val("1");
        } else {
            $(".key").val("人才搜索：请输入岗位名称");
            document.getElementById("jobKey").defaultValue = "人才搜索：请输入岗位名称";
            $("#Type").val("2");
        }
    });

    //页面加载时设置搜索框默认值,默认为职位搜索
    if (document.getElementById("jobKey")) {
        //if (window.location.pathname.indexOf("/resumelist.aspx") > 0) {        
        if (window.location.pathname.indexOf("/jianli") > -1) {
            $("#searchTab a").eq(1).addClass("on");
            //if (window.location.search.indexOf("keyword") < 0) { 
            if ($("#jobKey").val() == "" || $("#jobKey").val() == "职位搜索：请输入公司或职位名称") {
                $(".key").val("人才搜索：请输入岗位名称");
            }
            else {
                //document.getElementById("jobKey").defaultValue = "人才搜索：请输入岗位名称";
            }
        }
        else {
            $("#searchTab a").eq(0).addClass("on");
            //if (window.location.search.indexOf("keyword") < 0) {           
            if ($("#jobKey").val() == "") {
                $(".key").val("职位搜索：请输入公司或职位名称");
            }
            else {
                //document.getElementById("jobKey").defaultValue = "职位搜索：请输入公司或职位名称";
            }
        }
    }

    //处理右侧诚信易图标
    $(".clist img").attr("align", "absmiddle");
    //    $("#btnJP").click(function () {        
    //        if (ECommerce.userObj.User_IsLogin()) {
    //            if (Luosi.current_user.membertype == 1) {
    //                window.open("/MyOffice/Job/JobsEdit.aspx");
    //            }
    //            else {
    //                // $(this).colorbox.close();
    //                $.fn.colorbox.close();
    //                ShowSuccessMsg("企业会员才能发布招聘!");
    //            }
    //        }
    //        else {
    //            ECommerce.userObj.User_Login_Popup_Init();
    //            ECommerce.userObj.User_Login_Popup_Form_Init();
    //        }
    //    });
    $("#UpdateResume").click(function () {
        //alert("1");
        var e = false;
        $.ajax({
            async: false,
            timeout: 6E4,
            type: "post",
            url: "/Ajax/AjaxPage.aspx?t=updateresumelmdate",
            data: { id: $("#UpdateResume").attr("name") },
            dataType: "json",
            success: function (data) {
                //if (data == null) { alert('网络超时！'); e = false; }
                if (data.status.code == "1001") {
                    alert("刷新成功!");
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
        //alert(e);
        return e;
    });
});

(function (a) {
    var uiv = {};
    if (window.ECommerce) uiv = window.ECommerce;
    uiv.resumeObj = {//判断会员是否提交简历
        User_HaveResume: function () {           
            var e = false;            
            $.ajax({
                async: false,
                timeout: 6E4,
                type: "post",
                url: "/Ajax/JobAjaxPage.aspx?t=haveresume",
                dataType: "json",
                success: function (data) {                    
                    //if (data == null) { alert('网络超时！'); e = false; }
                    if (data.status.code == "1001") {                                             
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
            //alert(e);
            return e;
        }
    }
})(jQuery);