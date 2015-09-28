(function (a) {
    var b, c, d, e, f, g;
    var uiv = {};
    if (window.ECommerce) uiv = window.ECommerce;
    uiv.PositionObj_Show_init = function (t) {
        //alert("11");
        a.post("/ajax/common/PositionAndAreaData.aspx?t=" + t, function (result) {
            $("#boxPosition").html(result);
            $(".close").click(function () {
                $("#boxPosition").hide();
                $(".detailInfo select").show();
            });

            $(".save input").click(function () {
                //alert("1");
                var text316 = $("#other316").val();
                var text335 = $("#other335").val();
                var text351 = $("#other351").val();
                if (text316 != "") {
                    $("#Otherval316").val(text316);
                }
                if (text335 != "") {
                    $("#Otherval335").val(text335);
                }
                if (text351 != "") {
                    $("#Otherval351").val(text351);
                }
                var Position = $("#Position").val();
                savearr = Position.split(',');
                $("#PositionSelect em").remove();
                for (var i = 0; i < savearr.length - 1; i++) {
                    var categryname = $("#" + savearr[i]).attr("name");
                    if (savearr[i] == 316 && text316!="") {
                        categryname = categryname + "(" + text316 + ")";
                    }
                    if (savearr[i] == 335 && text335 != "") {
                        categryname = categryname + "(" + text335 + ")";
                    }
                    if (savearr[i] == 351 && text351 != "") {
                        categryname = categryname + "(" + text351 + ")";
                    }
                    $("#PositionSelect").append("<em id=\"" + savearr[i] + "\">" + categryname + "<a href=\"javascript:;\" id=\"" + savearr[i] + "\" title=\"移除\">×</a></em>");
                }


                $("#boxPosition").hide();
                $(".detailInfo select").show();
            });

            $(".detailInfo select").toggle();

            a("#boxPosition input").bind("click", function () { ECommerce.SelectPosition(this) });
            a("#boxPosition a").bind("click", function () { ECommerce.HrefSelectPosition(this) });
            $("#PositionSelect a").live("click", function () { ECommerce.MovePositionEM(this) });
            $("#AllPosition").click(function () {
                $("#CategoryID").val("0");
                $("#position").html("职位不限");
                $("#boxPosition").hide();
            });
            if (t == 1) {
                var str = $("#Position").val();
                var str316 = $("#Otherval316").val();
                var str335 = $("#Otherval335").val();
                var str351 = $("#Otherval351").val();
                var arr = new Array();
                if (str != "") {
                    //alert(str);
                    arr = str.split(','); //注split可以用字符或字符串分割
                    for (var i = 0; i < arr.length; i++) {
                        //alert(arr[i]);
                        if (arr[i] != "") {
                            //$("#boxPosition").find("#selectPosition" + arr[i]).attr("checked", true);
                            $("#boxPosition").find("#" + arr[i]).attr("checked", true);
                            if (arr[i] == 316) {
                                $("#other316").show();
                                $("#other316").val(str316);
                            }
                            if (arr[i] == 335) {
                                $("#other335").show();
                                $("#other335").val(str335);
                            }
                            if (arr[i] == 351) {
                                $("#other351").show();
                                $("#other351").val(str351);
                            }
                        }
                    }
                }
            }
        });
    };
    uiv.SelectPosition = function (o) {
        b = a(o).attr("id");
        c = a(o).attr("name");
        if (a(o).attr("checked")) {
            if ($("#Position").val().split(',').length <= 3) {
                //$(".detailInfo .selected:first").append("<em id=\"em" + b + "\">" + c + "<a href=\"javascript:;\" id=\"aaa\" onclick=\"move(this," + b + ")\" title=\"移除\">×</a></em>");
                $("#PositionSelect").append("<em id=\"" + b + "\">" + c + "<a href=\"javascript:;\" id=\"" + b + "\" title=\"移除\">×</a></em>");
                //alert($("#PositionSelect").html());
                //$("#PositionSelect a").bind("click", function () { ECommerce.MovePositionEM(this) });

                $(o).attr("checked", true);
                $("#Position").val(b + "," + $("#Position").val());
                if (b == 316 || b == 335 || b == 351) {
                    $("#other" + b).show();
                }
            }
            else {
                $(o).attr("checked", false);
            }
        }
        else {
            //$("#em" + b).remove();
            //$("#" + b).remove();
            if (b == 316 || b == 335 || b == 351) {
                $("#other" + b).hide();
                $("#other" + b).val("");
            }
            $("#PositionSelect").find("#" + b).remove();
            $(o).attr("checked", false);
            var str = $("#Position").val();
            $("#Position").val(str.replace(b + ",", ""));
        }
    }
    uiv.MovePositionEM = function (o) {
        //alert(a(o).html());
        b = a(o).attr("id");
        
        $(o).parent().remove();
        $("#boxPosition").find("#" + b).attr("checked", false);
        var str = $("#Position").val();
        $("#Position").val(str.replace(b + ",", ""));
        if (b == 316) {
            $("#Otherval316").val("");
        }
        if (b == 335) {
            $("#Otherval335").val("");
        }
        if (b == 351) {
            $("#Otherval351").val("");
        }
    }
    uiv.HrefSelectPosition = function (o) {
        b = a(o).attr("id");
        $("#position").html(a(o).html());
        $("#jobCategray").val(a(o).html());
        $("#CategoryID").val(a(o).attr("id"));
        $("#boxPosition").hide();
    }
    uiv.PositionObj_Popup_init = function (t, x, y) {
        //b = '<div class="LuosiWinBoxWrap" id="popup_box_category"><div class="LuosiWinBox"><div class="LuosiInner"><div class="LuosiSubject"><a class="close" href="javascript:;" title="关闭窗口" onfocus="this.blur()"></a><b>请选择产品类别</b></div><div class="LuosiContentWrap"><div class="LuosiContent">正在加载中,请稍后...</div></div></div></div></div>';
        //uiv.Popup_init("popup_box_category",b);
        //b='<div class=\"selectBox\" id=\"selectBoxPosition\"><div class=\"innerbox\"><div class=\"closeBox\"><a class=\"close\" title=\"关闭\" href=\"javascript:;\">×</a></div></div></div>';
        b = '<div class=\"innerbox\"><div class=\"closeBox\"><a class=\"close\" title=\"关闭\" href=\"javascript:;\">×</a></div><p>正在加载中,请稍后...</p></div>';
        uiv.PopupPosition_init("selectBoxPosition", b, t, x, y);
        //         a.post("/ajax/common/PositionAndAreaData.aspx", function (result) {
        //                //alert("111");
        //                //a("#selectData").html(result);
        //                //uiv.Popup_init("selectBoxPosition",b);
        //                uiv.Popup_init("selectBoxPosition",result,x,y);
        //            });
    };
    uiv.PopupPosition_init = function (b, c, t, d, e) {
        $("body").append("<div class='selectBox' id='boxPosition' style='display:none'></div>");
        $(".selectBox").hide();
        //$("#boxPosition").html($("#selectBoxPosition").html());
        $("#boxPosition").html(c);
        $("#boxPosition").css("left", d);
        $("#boxPosition").css("top", e);
        //alert($("#boxPosition").html());
        $("#boxPosition").slideToggle();

        $(".close").click(function () {
            $("#boxPosition").hide();
            $(".detailInfo select").show();
        });

        $("#AllPosition").click(function () {
            $("#CategoryID").val("0");
            $("#position").html("职位不限");
            $("#boxPosition").hide();
        });

        if (t != 1) {
            $("#boxPosition").mouseleave(function () {
                //alert("1");
                $("#boxPosition").hide();
                $(".detailInfo select").show();
            })
            $("#boxPosition").mouseenter(function () {
                //alert("1");
                $("#boxPosition").show();
            })
            $(".position").mouseleave(function () {
                //alert("1");
                $("#boxPosition").hide();
                $(".detailInfo select").show();
            })
            $(".position").mouseenter(function () {
                //alert("1");
                $("#boxPosition").show();
            })
        }
    }
})(jQuery);



(function (a) {
    var b, c, d, e, f, g;
    var uiv = {};
    if (window.ECommerce) uiv = window.ECommerce;
    uiv.AreaObj_Show_init = function (t) {
        a.post("/ajax/common/AreaData.aspx?t=" + t, function (result) {            
            $("#boxArea").html(result);
            $("#AllArea").click(function(){
            $("#Area").val("0");
            $("#area1").html("地区不限");
            $("#boxArea").hide();
        })
            $(".close").click(function () {
                $("#boxArea").hide();
                $(".detailInfo select").show();
            });

            $(".save input").click(function () {
                //alert("1");
               

                $("#boxArea").hide();
                $(".detailInfo select").show();
            });

            $(".detailInfo select").toggle();
            a("#boxArea .hotCity input").bind("click", function () { ECommerce.SelectCity(this) });
            a("#boxArea .city input").bind("click", function () { ECommerce.SelectCity(this) });
            a("#boxArea .province a").bind("click", function () { ECommerce.SelectProvince(this, t) });
            //a("#boxArea .province a").bind("click", function () { ECommerce.HrefSelectArea(this) });
            a("#boxArea .hotCity a").bind("click", function () { ECommerce.HrefSelectCity(this) });
            a("#boxArea .city a").bind("click", function () { ECommerce.HrefSelectCity(this) });
            a("#AreaSelect a").live("click", function () { ECommerce.MoveAreaEM(this) });
             $("#AllArea").click(function(){
            $("#Area").val("0_0");            
            $("#area1").html("地区不限");
            $("#boxArea").hide();
        });
            if (t == 1) {
                var str = $("#Area").val();
                var arr = new Array();
                if (str != "") {
                    arr = str.split(','); //注split可以用字符或字符串分割
                    for (var i = 0; i < arr.length; i++) {
                        if (arr[i] != "") { 
                            //alert(1);
                            if (arr[i].split("_")[1] != "0"){
                                $("#boxArea").find("#" + arr[i]).attr("checked", true);
                            }
                            else{
                                $(".hotCity").find("input").each(function () {
                                    if (arr[i].split("_")[0] ==  a(this).attr("id").split("_")[0]){
                                        a(this).attr("checked", true);
                                        a(this).attr("disabled", true);
                                    }
                                });                                
                            }
                        }
                        
                    }
                }
            }
        });
    };
    uiv.SelectProvince = function (o, t) {
        //b = a(o).attr("id");        
        c = a(o).attr("name");
        if (t == 2) {
            b = a(o).attr("id");
            $("#area1").html(a(o).html());
            $("#Area").val(a(o).attr("id").replace("p",""));
        }
        $cityName = c;
        //alert($(".currentCity").html());
        $(".currentCity").html("");
        $(".currentCity").hide();
        $(".currentCity").html($("#" + $cityName).html());
        //alert($("#" + $cityName).html());
        $(".currentCity").attr("id", c.replace("city", ""));
        //$(".currentCity").show();
        $(".hotCity").slideUp("slow", function () {
            $(".currentCity").slideDown();
        });
        $(".province a").removeClass();
        a(o).addClass("red bold");
        $(".currentCity").find("input").attr("checked", false);
        if (t == 1) {
            var str = $("#Area").val();
            var arr = new Array();
            if (str != "") {
                arr = str.split(','); //注split可以用字符或字符串分割
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i] != "") {
                        //alert(arr[i]);
                        //$("#boxArea").find("#" + arr[i]).attr("checked", true);
                        if (arr[i].split("_")[1]=="0" && arr[i].split("_")[0] ==  $(".currentCity").attr("id")){
                            $(".currentCity").find("input").attr("checked", true);
                            $(".currentCity").find("input").attr("disabled", true);
                            $(".currentCity").find("#" + arr[i]).attr("disabled", false);
                        }
                        else{
                            $(".currentCity").find("#" + arr[i]).attr("checked", true);                            
                        }
                        
                        //$("#hotCity").find("#" + arr[i]).attr("checked", true);
                    }
                }
            }
        }
        $(".currentCity :checkbox").bind("click", function () { ECommerce.SelectCity(this) });
        a(".currentCity a").bind("click", function () { ECommerce.HrefSelectCity(this) });
    }
    uiv.SelectCity = function (o) {
        b = a(o).attr("id");
        c = a(o).attr("name");
        e = $(".currentCity").attr("id");
        //alert(b);
        //alert(a(o).parent().parent().parent().parent().parent().html());
        //alert($(".currentCity").attr("id"));
        //d=a(o).parent();       
        if (b.split("_")[1] == "0" && e == b.split("_")[0]) {
            //全省
            if (a(o).attr("checked")) {
                //选择全省                
                //$("#boxArea").find("input").attr("checked", true);
                //$("#boxArea").find("input").each(function(){
                var areastr;
                $(".currentCity").find("input").each(function () {
                    //alert(a(this).attr("id"));
                    if (a(this).attr("id").split("_")[1] != "0" && $("#Area").val().indexOf(a(this).attr("id")) > -1) {
                        //alert(a(this).attr("checked"));
                        //如果之前选择了其他城市,先清空城市
                        $("#AreaSelect").find("#" + a(this).attr("id")).remove();
                        $("#Area").val($("#Area").val().replace(a(this).attr("id") + ",", ""));
                        //$("#AreaSelect").append("<em id=\"" + a(this).attr("id") + "\" >" + a(this).attr("name") + "<a href=\"javascript:;\" id=\"" + a(this).attr("id") + "\" title=\"移除\">×</a></em>");
                        //$("#Area").val(a(this).attr("id") + "," + $("#Area").val());
                    }
                });
                if($("#Area").val().split(",").length<=3){
                    $(".currentCity").find("input").attr("checked", true);                    
                    $("#AreaSelect").append("<em id=\"" + a(o).attr("id") + "\" >" + a(o).attr("name") + "<a href=\"javascript:;\" id=\"" + a(o).attr("id") + "\" title=\"移除\">×</a></em>");
                    $(".currentCity").find("input").attr("disabled", true);
                    a(o).attr("disabled", false);
                    $("#Area").val(b + "," + $("#Area").val());
                }
                else{
                    a(o).attr("checked",false);
                    //ECommerce.Job_Edit_Validate();
                }
                $(".currentCity").find("input").eq(0).focus();
            }
            else {
                //取消全省
                $(".currentCity").find("input").each(function () {
                    //alert(a(this).attr("id"));
                    if (a(this).attr("id").split("_")[1] != "0") {
                        //$("#AreaSelect").append("<em id=\"" + a(this).attr("id") + "\" >" + a(this).attr("name") + "<a href=\"javascript:;\" id=\""+a(this).attr("id")+"\" title=\"移除\">×</a></em>");
                        //$("#AreaSelect").find("#" + a(this).attr("id")).remove();                        
                        a(this).attr("checked", false);
                        //$("#Area").val($("#Area").val().replace(a(this).attr("id") + ",", ""));
                    }
                }); 
                $("#AreaSelect").find("#" + a(o).attr("id")).remove();               
                $(".currentCity").find("input").attr("disabled", false);
                $("#Area").val($("#Area").val().replace(b + ",", ""));
            }
        }
        else {
            if (a(o).attr("checked")) {
                if($("#Area").val().split(",").length<=3){
                    $("#AreaSelect").append("<em id=\"" + b + "\" >" + c + "<a href=\"javascript:;\" id=\"" + b + "\" title=\"移除\">×</a></em>");
                    //alert($("#AreaSelect").html());
                    $(o).attr("checked", true);
                    $("#Area").val(b + "," + $("#Area").val());
                    //如果全省未选择,又是最后一个选项.就选择全省
                    if ($("#Area").val().indexOf(b.split("_")[0] + "_0") == -1) {
                        f = 0;
                        g = 0;
                        $(".currentCity").find("input").each(function () {
                            g++;
                            if (a(this).attr("checked")) {
                                f++;
                            }
                        });
                        //alert(f);
                        //alert(g);
                        if (f + 1 == g) {
                            $(".currentCity").find("#" + b.split("_")[0] + "_0").attr("checked", true);
                            $("#Area").val(b.split("_")[0] + "_0" + "," + $("#Area").val());
                            //$("#Area").val($("#Area").val().replace(b.split("_")[0]+"_0" + ",", ""));
                        }
                    }
                }
                else{
                    a(o).attr("checked",false);
                    //ECommerce.Job_Edit_Validate();
                }                
            }
            else {
                $("#AreaSelect").find("#" + b).remove();
                $(o).attr("checked", false);
                var str = $("#Area").val();
                $("#Area").val(str.replace(b + ",", ""));
                //如果全省被选择,就取消全省
                //alert(b.split("_")[0]+"_0");
                //alert($("#Area").val().indexOf(b.split("_")[0]+"_0"));
                if ($("#Area").val().indexOf(b.split("_")[0] + "_0") > -1) {
                    //$("#AreaSelect").find("#" + b.split("_")[0]+"_0").remove();
                    //alert($(".currentCity").find(b.split("_")[0]+"_0").html());
                    $(".currentCity").find("#" + b.split("_")[0] + "_0").attr("checked", false);
                    $("#Area").val($("#Area").val().replace(b.split("_")[0] + "_0" + ",", ""));
                }
            }
        }        
    }
    uiv.MoveAreaEM = function (o) {
        //alert(a(o).html());
        b = a(o).attr("id");
        //alert(b);
        $(o).parent().remove();
        $("#boxArea").find("#" + b).attr("checked", false);
        var str = $("#Area").val();
        $("#Area").val(str.replace(b + ",", ""));
    }
    uiv.HrefSelectCity = function (o) {
        b = a(o).attr("id");
        $("#area1").html(a(o).html());
        //alert(b);
        //$("#jobArea").val(a(o).html());
        $("#Area").val(a(o).attr("id"));
        $("#boxArea").hide();
    }
    uiv.AreaObj_Popup_init = function (t,x, y) {
        //alert("1");
        b = '<div class=\"innerbox\"><div class=\"closeBox\"><a class=\"close\" title=\"关闭\" href=\"javascript:;\">×</a></div><p>正在加载中,请稍后...</p></div>';
        uiv.PopupArea_init("selectBoxArea", b,t, x, y);
    };
    uiv.PopupArea_init = function (b, c,t, d, e) {
        $("body").append("<div class='selectBox' id='boxArea' style='display:none'></div>");
        $(".selectBox").hide();
        $("#boxArea").html(c);
        $("#boxArea").css("left", d);
        $("#boxArea").css("top", e);
        $("#boxArea").slideToggle();

        $("#AllArea").click(function(){
            $("#Area").val("0_0");            
            $("#area1").html("地区不限");
            $("#boxArea").hide();
        });
        $(".close").click(function () {
            $("#boxArea").hide();
            $(".detailInfo select").show();
        });   
        if(t!=1)
        {     
            $("#boxArea").mouseleave(function () {
                //alert("1");
                $("#boxArea").hide();
                $(".detailInfo select").show();
            })      
            $("#boxArea").mouseenter(function () {
                //alert("1");
                $("#boxArea").show();            
            })
            $(".area").mouseleave(function () {
                //alert("1");
                $("#boxArea").hide();
                $(".detailInfo select").show();
            })
            $(".area").mouseenter(function () {
                //alert("1");
                $("#boxArea").show();
            })
        }
    }
})(jQuery);


(function (a) {
    var b, c, d, e, f, g;
    var uiv = {};
    if (window.ECommerce) uiv = window.ECommerce;
    uiv.TagObj_Show_init = function () {
        a.post("/ajax/common/ResumeTagData.aspx", function (result) {
            $("#boxTag").html(result);
            $("#boxTag a").click(function () {
                if ($(this).attr("class") != "on") {
                    $(this).addClass("on");
                } else {
                    $(this).removeClass("on");
                }
            });
            $(".close").click(function () {
                $("#boxTag").hide();
                $(".detailInfo select").show();
            });


            $(".detailInfo select").toggle();
            //$("#boxPosition input").bind("click", function () { ECommerce.SelectPosition(this) });
            $("#boxTag a").bind("click", function () { ECommerce.HrefSelectTag(this) });
            $("#TagSelect a").live("click", function () { ECommerce.MoveTagEM(this) });
//            a("#boxArea .hotCity input").bind("click", function () { ECommerce.SelectCity(this) });
//            a("#boxArea .city input").bind("click", function () { ECommerce.SelectCity(this) });
//            a("#boxArea .province a").bind("click", function () { ECommerce.SelectProvince(this, t) });
//            //a("#boxArea .province a").bind("click", function () { ECommerce.HrefSelectArea(this) });
//            a("#boxArea .hotCity a").bind("click", function () { ECommerce.HrefSelectCity(this) });
//            a("#boxArea .city a").bind("click", function () { ECommerce.HrefSelectCity(this) });
//            $("#AreaSelect a").live("click", function () { ECommerce.MoveAreaEM(this) });
//            if (t == 1) {
                var str = $("#Tag").val();
                var arr = new Array();
                if (str != "") {
                    arr = str.split(','); //注split可以用字符或字符串分割
                    for (var i = 0; i < arr.length; i++) {
                        if (arr[i] != "") {
                            $("#boxTag").find("#" + arr[i]).addClass("on");
                            //$("#hotCity").find("#" + arr[i]).attr("checked", true);
                        }
                    }
                }
//            }
        });
    };        
    uiv.HrefSelectTag = function (o) {
        //alert(a(o).attr("class"));
        b = a(o).attr("id");
        c = a(o).attr("name");
        if(a(o).attr("class")=="on"){
            $("#TagSelect").append("<em id=\"" + b + "\">" + c + "<a href=\"javascript:;\" id=\"" + b + "\" title=\"移除\">×</a></em>");
            //alert($("#PositionSelect").html());
            //$("#PositionSelect a").bind("click", function () { ECommerce.MovePositionEM(this) });

            $(o).addClass("on");
            $("#Tag").val(b + "," + $("#Tag").val());
        }
        else{
            $("#TagSelect").find("#" + b).remove();
            $(o).removeClass();
            var str = $("#Tag").val();
            $("#Tag").val(str.replace(b + ",", ""));
        }        
        //$("#boxTag").hide();
    }
     uiv.MoveTagEM = function (o) {
        //alert(a(o).html());
        b = a(o).attr("id");
        //alert(b);
        $(o).parent().remove();
        //alert($("#boxTag").find("#" + b).html());
        $("#boxTag").find("#" + b).removeClass();
        var str = $("#Tag").val();
        $("#Tag").val(str.replace(b + ",", ""));
    }
    uiv.TagObj_Popup_init = function (x, y) {
        //alert("1");
        b = '<div class=\"innerbox\"><div class=\"closeBox\"><a class=\"close\" title=\"关闭\" href=\"javascript:;\">×</a></div><p>正在加载中,请稍后...</p></div>';
        uiv.PopupTag_init("selectBoxTag", b, x, y);
    };
    uiv.PopupTag_init = function (b, c, d, e) {
        $("body").append("<div class='selectBox' id='boxTag' style='display:none'></div>");
        $(".selectBox").hide();
        $("#boxTag").html(c);
        $("#boxTag").css("left", d);
        $("#boxTag").css("top", e);
        $("#boxTag").slideToggle();       

        $(".close").click(function () {
            $("#boxTag").hide();
            $(".detailInfo select").show();
        });
        
        $("#boxTag").mouseleave(function () {
            //alert("1");
            $("#boxTag").hide();
            $(".detailInfo select").show();
        })   
         $("#boxTag").mouseenter(function () {
            //alert("1");
            $("#boxTag").show();            
        })
        $(".area").mouseleave(function () {
            //alert("1");
            $("#boxTag").hide();
            $(".detailInfo select").show();
        })
        $(".area").mouseenter(function () {
            //alert("1");
            $("#boxTag").show();
        })
    }
})(jQuery);


(function (a) {
    var b, c, d, e, f, g;
    var uiv = {};
    if (window.ECommerce) uiv = window.ECommerce;
//    uiv.DateObj_Show_init = function () {
//       $(".detailInfo select").toggle();
//       $("#boxTime").show();
//       a("#boxTime .timeBox a").bind("click", function () { ECommerce.HrefSelectDate(this) });
//            };
    uiv.HrefSelectDate = function (o) {
        b = a(o).attr("id");
        $("#postTime").html(a(o).html());
        //alert(b);
        //$("#jobArea").val(a(o).html());
        $("#LMDate").val(a(o).attr("id"));
        $("#boxTime").hide();
    };
    uiv.DateObj_Popup_init = function (x, y) {
        //salert("1");
        b = '<div class="innerbox"><div class="timeBox"><a href="#" id="1">一天内</a> <a href="#" id="3">三天内</a> <a href="#" id="7">一周内</a> <a href="#" id="30">一个月内</a> <a href="#" id="60">两个月内</a> <a href="#" id="90">三个月内</a> <a href="#" id="180">半年内</a> <a href="#" id="0">时间不限</a></div></div>';
        uiv.PopupDate_init("selectBoxArea", b, x, y);
//        alert($("#boxTime").html());
    };
    uiv.PopupDate_init = function (b, c, d, e) {
        $(".selectBox").remove();
        $("body").append("<div class='selectBox' id='boxTime' style='display:none'></div>");
        $(".selectBox").hide();
        $("#boxTime").html(c);
        $("#boxTime").css("left", d);
        $("#boxTime").css("top", e);
        $("#boxTime").slideToggle();
        a("#boxTime .timeBox a").bind("click", function () { ECommerce.HrefSelectDate(this) });

        $(".close").click(function () {
            $("#boxTime").hide();
            $(".detailInfo select").show();
        });
        
        $("#boxTime").mouseleave(function () {
            //alert("1");
            $("#boxTime").hide();
            $(".detailInfo select").show();
        })     
         $("#boxTime").mouseenter(function () {
            //alert("1");
            $("#boxTime").show();            
        })
        $(".postTime").mouseleave(function () {
            //alert("1");
            $("#boxTime").hide();
            $(".detailInfo select").show();
        })
        $(".postTime").mouseenter(function () {
            //alert("1");
            $("#boxTime").show();
        })
    }
})(jQuery);