/*每五分钟更新一次最新求购*/
function clickTime() {
    var thistime = new Date();
    var years = thistime.getYear();
    var days = thistime.getDay();
    var hours = thistime.getHours();
    var minutes = thistime.getMinutes();
    var seconds = thistime.getSeconds();
    var lastDate = new Date(thistime.getYear(), thistime.getMonth(), thistime.getDate(), hours, 5 * parseInt(minutes / 5));
    minutes = 4 - minutes % 5;
    seconds = 59 - seconds;
    var smin = lastDate.getMinutes();
    if (smin < 10) smin = "0" + smin;
    if (minutes == 0 && seconds == 0) {

        $.ajax({
            async: false,
            cache: false,
            timeout: 6E4,
            type: "post",
            url: "/Ajax/AjaxPage.aspx?t=getindexbuylist",
            dataType: "json",
            beforeSend: function () {
            },
            success: function (data) {
                if (data == null) {
                }
                else {
                    if (data.status.code == "1001") {
                        $("#ulbuylist").html(data.result);
                    }
                    else {
                    }
                }
            },
            error: function () {
            }
        });

    } else {
        if (minutes < 10) minutes = "0" + minutes;
        if (seconds < 10) seconds = "0" + seconds;
        thistime = minutes + ":" + seconds;
        document.getElementById("timebody").innerHTML = thistime;
    }
    setTimeout("clickTime()", 1000);
}

clickTime();
/**/

/*订阅周刊开始*/
function Subscribe() {
    var WeeklyEmail = $("input[name='weeklyemail']").val();
    if (WeeklyEmail == "" || WeeklyEmail == "订阅周刊，请输入您的Email地址") {
        alert('请输入您的邮箱地址');
        return false;
    }
    if (!isEmail(WeeklyEmail)) {
        alert('请输入正确的邮箱地址');
        return false;
    }
    $.ajax({
        async: false,
        cache: false,
        timeout: 6E4,
        type: "post",
        url: "/Ajax/OfficeAjaxPage.aspx?t=subscribeweekly",
        data: { Email: WeeklyEmail },
        dataType: "json",
        success: function (data) {
            if (data == null) return;
            if (data.status.code == "1001") {
                alert(data.status.msg);
            } else {
                alert(data.status.msg);

            }
        },
        error: function (a, b) {
            if (b == "timeout") {

            }
        }

    });
}

function Subscribe1() {
    var WeeklyEmail = $("input[name='weeklyemail1']").val();
    if (WeeklyEmail == "" || WeeklyEmail == "订阅周刊，输入Email") {
        alert('请输入您的邮箱地址');
        return false;
    }
    if (!isEmail(WeeklyEmail)) {
        alert('请输入正确的邮箱地址');
        return false;
    }
    $.ajax({
        async: false,
        cache: false,
        timeout: 6E4,
        type: "post",
        url: "/Ajax/OfficeAjaxPage.aspx?t=subscribeweekly",
        data: { Email: WeeklyEmail },
        dataType: "json",
        success: function (data) {
            if (data == null) return;
            if (data.status.code == "1001") {
                alert(data.status.msg);
            } else {
                alert(data.status.msg);

            }
        },
        error: function (a, b) {
            if (b == "timeout") {

            }
        }

    });
}
/*订阅周刊结束*/


/*排名三甲*/
function ShowCompanyThree(tobj, tposition, tcompany1, tlinkurl1, tcompany2, tlinkurl2, tcompany3, tlinkurl3) {
    var theElement = tobj;
    var _lc0 = document.getElementById("position" + tposition);
    var fixWidth = getCompanyThreePosition(_lc0)[0];
    var _lx = getCompanyThreePosition(theElement)[0];
    var _ty = getCompanyThreePosition(theElement)[1];

    var _span = document.getElementById("show_box_bw");
    var _div = document.getElementById("show_box_bw_con");
    if (_span) {
        _span.style.visibility = "visible";
        _div.style.visibility = "visible";
    }
    else {
        _span = document.createElement("span");
        _div = document.createElement("div");
        _span.setAttribute("id", "show_box_bw");
        _div.setAttribute("id", "show_box_bw_con");
        document.body.appendChild(_span);
        document.body.appendChild(_div);
    }

    var dataTag = "";
    if (tcompany1 != "") {
        dataTag += "<li><a href='" + tlinkurl1 + "' target='_blank'>" + tcompany1 + "</a></li>";
    }
    if (tcompany2 != "") {
        dataTag += "<li><a href='" + tlinkurl2 + "' target='_blank'>" + tcompany2 + "</a></li>";
    }
    if (tcompany3 != "") {
        dataTag += "<li><a href='" + tlinkurl3 + "' target='_blank'>" + tcompany3 + "</a></li>";
    }

    _div.innerHTML = "<div class='out_top_bg'><div><ul>" + dataTag + "</ul></div></div>";

    var _url = tobj.href;

    _span.innerHTML = "<a href='" + _url + "'  class='" + tobj.className + "' target='_blank'>" + tobj.innerHTML + "</a>"

    var _spana = _span.getElementsByTagName("a")[0];
    var _ieffNum = document.all ? 9 : 10;

    var _spanleft = _lx;
    var _spantop = _ty;

    _span.style.left = _spanleft + "px";
    _span.style.top = _spantop + "px";

    var _pd = _lx - _ieffNum - fixWidth - 29;
    _leftDis = _pd + _span.offsetWidth / 2;

    _span.style.fontWeight = "normal";
    _span.style.marginLeft = "0px";

    if (_leftDis < 50)
        _div.style.left = _spanleft + "px";
    else if (50 <= _leftDis && _leftDis < 80)
        _div.style.left = _spanleft - 30 + "px";
    else if (80 <= _leftDis && _leftDis < 300)
        _div.style.left = _spanleft - 80 + "px";
    else if (300 <= _leftDis && _leftDis < 350)
        _div.style.left = (_spanleft + _span.offsetWidth - _div.offsetWidth) + 10 + "px";
    else {
        _span.style.left = (_spanleft - 13) + "px"
        _div.style.left = (_spanleft - 13) + _span.offsetWidth - _div.offsetWidth + "px";
    }

    _div.style.top = _spantop + 19 + "px";

    _span.onmouseover = function () {
        this.style.visibility = "visible";
        _div.style.visibility = "visible";
    }
    _span.onmouseout = function () {
        this.style.visibility = "hidden";
        _div.style.visibility = "hidden";
    }
    _div.onmouseover = function () {
        this.style.visibility = "visible";
        _span.style.visibility = "visible";
    }
    _div.onmouseout = function () {
        this.style.visibility = "hidden";
        _span.style.visibility = "hidden";
    }
}

function getCompanyThreePosition(theElement) {
    var positionX = 0;
    var positionY = 0;
    while (theElement != null) {
        positionX += theElement.offsetLeft;
        positionY += theElement.offsetTop;
        theElement = theElement.offsetParent;
    }
    return [positionX, positionY];
}
/**/