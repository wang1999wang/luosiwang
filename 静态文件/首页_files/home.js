//华网首页脚本
//Author: deiphi@qq.com 2012/5/5

$(document).ready(function () {

    //自动收缩广告
    $("div#slideAds").hide().slideDown("slow", function () {
        setTimeout(function () { $("div#slideAds").slideUp() }, 10000);
    });

    //把左侧广告进行随机摆放
    $("div.leftAdList span.random a").wrap("<em></em>");
    $leftAdList = $("div.leftAdList span.random em");
    var leftAdArr = new Array();
    for (var i = 0; i < $leftAdList.length; i++) {
        leftAdArr[i] = $leftAdList[i].innerHTML;
    }

    var leftNewAdArr = randomAD(leftAdArr);
    var leftAdStr = "";
    for (var i = 0; i < $leftAdList.length; i++) {
        leftAdStr += leftNewAdArr[i];
    }

    $("div.leftAdList span.random").empty().html(leftAdStr);


    //把右侧广告进行随机摆放
    $("div.rightAdList span.random a").wrap("<em></em>");
    $rightAdList = $("div.rightAdList span.random em");
    var rightAdArr = new Array();
    for (var i = 0; i < $rightAdList.length; i++) {
        rightAdArr[i] = $rightAdList[i].innerHTML;
    }

    var rightNewAdArr = randomAD(rightAdArr);
    var rightAdStr = "";
    for (var i = 0; i < $rightAdList.length; i++) {
        rightAdStr += rightNewAdArr[i];
    }

    $("div.rightAdList span.random").empty().html(rightAdStr);


    //为左右两侧广告添加“鼠标划过放大”事件
    $("div.HomeSideAdList span.fixed img").mouseenter(function () {
        $(this).attr("srcUrl", $(this).attr("src"));
        $(this).attr("widthUrl", $(this).attr("width"));
        $(this).attr("heightUrl", $(this).attr("height"));
        $(this).attr("src", $(this).attr("name"));
        $(this).attr("width", $(this).attr("widthname"));
        $(this).attr("height", $(this).attr("heightname"));
        if ($.browser.msie) {
            $(this).parent().parent().parent().css("width", 262);
        }
    });

    $("div.HomeSideAdList span.fixed img").mouseleave(function () {
        $(this).attr("src", $(this).attr("srcUrl"));
        $(this).attr("width", $(this).attr("widthUrl"));
        $(this).attr("height", $(this).attr("heightUrl"));
        if ($.browser.msie) {
            $(this).parent().parent().parent().css("width", 102);
        }
    });

    $("div.HomeSideAdList span.random img").mouseenter(function () {
        $(this).attr("srcUrl", $(this).attr("src"));
        $(this).attr("widthUrl", $(this).attr("width"));
        $(this).attr("heightUrl", $(this).attr("height"));

        $(this).attr("src", $(this).attr("name"));
        $(this).attr("width", $(this).attr("widthname"));
        $(this).attr("height", $(this).attr("heightname"));

        if ($.browser.msie) {
            $(this).parent().parent().parent().css("width", 262);
        }
    });

    $("div.HomeSideAdList span.random img").mouseleave(function () {
        $(this).attr("src", $(this).attr("srcUrl"));
        $(this).attr("width", $(this).attr("widthUrl"));
        $(this).attr("height", $(this).attr("heightUrl"));

        if ($.browser.msie) {
            $(this).parent().parent().parent().css("width", 102);
        }
    });

    $("div.HomeSideAdList a").before("<span class='clear'></span>"); //hack ie6


    //把华网横幅广告放到相应的位置
    $("#allAds p").each(function () {
        $("#" + $(this).attr("name")).html($(this).html());

        if ($(this).attr("name") == "sda_44") {
            if ($("#sda_23").html().indexOf("/img/ad/zhaozhu") == -1 || $("#sda_24").html().indexOf("/img/ad/zhaozhu") == -1) {
                $("#sda_44").hide();
            }
            else {
                $("#sda_23").hide();
                $("#sda_24").hide();
            }
        }
    });



    //推荐榜签切换
    $("#Recommended div.box ul").hide().eq(0).show();
    $("#Recommended span.more em").hide().eq(0).show();
    $("#Recommended div.tab a").mouseenter(function () {
        $index = $(this).index();
        $("#Recommended div.box ul").hide().eq($index).show();
        $("#Recommended span.more em").hide().eq($index).show();
        $("#Recommended div.tab a").removeClass("on");
        $(this).addClass("on");
    });
    $("#Recommended div.tab a").bind("focus", function () { $(this).blur() });


    //螺丝早报榜签切换
    $("#sideNews div.box").hide().eq(0).show();
    $("#sideNews span.more a").hide().eq(0).show();
    $("#sideNews div.tab a").mouseenter(function () {
        $index = $(this).index();
        $("#sideNews div.box").hide().eq($index).show();
        $("#sideNews span.more a").hide().eq($index).show();
        $("#sideNews div.tab a").removeClass("on");
        $(this).addClass("on");
    });
    $("#sideNews div.tab a").bind("focus", function () { $(this).blur() });


    //商学院标签切换
    $("#educate div.box ul").hide().eq(0).show();
    $("#educate span.more a").hide().eq(0).show();
    $("#educate div.tab a").mouseenter(function () {
        $index = $(this).index();
        $("#educate div.box ul").hide().eq($index).show();
        $("#educate span.more a").hide().eq($index).show();
        $("#educate div.tab a").removeClass("on");
        $(this).addClass("on");
    });
    $("#educate div.tab a").bind("focus", function () { $(this).blur() });

    //积分排行榜标签切换
    $("#score div.tab a").mouseenter(function () {
        $index = $(this).index();
        $("#score div.box div.d1").hide();
        $("#score div.box div.d2").hide();
        $("#score div.box div.d" + parseInt($index + 1)).show();

        $("#score div.tab a").removeClass("on");
        $(this).addClass("on");
    });
    $("#score div.tab a").bind("focus", function () { $(this).blur() });


    //产业链推荐厂商标签切换
    $("#chain div.box ul").hide().eq(0).show();
    $("#chain span.more a").hide().eq(0).show();
    $("#chain div.tab a").mouseenter(function () {
        $index = $(this).index();
        $("#chain div.box ul").hide().eq($index).show();
        $("#chain span.more a").hide().eq($index).show();
        $("#chain div.tab a").removeClass("on");
        $(this).addClass("on");
    });
    $("#chain div.tab a").bind("focus", function () { $(this).blur() });


})

    

