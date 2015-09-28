//华网资讯中心焦点图轮播脚本
//Author: deiphi@qq.com 2012-2-14

function adv() {
    adv.Imgs = document.getElementById("advFocus").getElementsByTagName("img");
    adv.Links = document.getElementById("advFocus").getElementsByTagName("a");
    adv.Clicks = document.getElementById("advFocus").getElementsByTagName("onclick");
    adv.TotalImg = adv.Imgs.length;
    adv.switchBox = document.getElementById("switchBox");
    adv.switchLinks = document.getElementById("switchBox").getElementsByTagName("a");
    adv.currentImg = document.getElementById("currentAdvImg");
    adv.currentLink = document.getElementById("currentAdvLink");
    adv.currentNum = 0;

    adv.advBox = document.getElementById("advbox");
    adv.title = document.createElement("div");
    adv.titleLink = document.createElement("a");
    adv.title.setAttribute("id", "advTitle");
    adv.titleLink.setAttribute("id", "advTitleLink");
    adv.advBox.appendChild(adv.title);
    adv.advBox.appendChild(adv.titleLink);
}

function setAdvs() {
    if (adv.TotalImg <= 0) { return false; }
    var switchLink = new Array();
    for (i = 0; i < adv.TotalImg; i++) {
        switchLink[i] = document.createElement("a");
        var switchLinkText = document.createTextNode(i + 1);
        switchLink[i].appendChild(switchLinkText);
        switchLink[i].href = "javascript:;";
        if (i == 0) {
            //adv.switchBox.insertBefore(switchLink[i]);//firefox不支持改用appendChild
            adv.switchBox.appendChild(switchLink[i]);
        }
        else {
            adv.switchBox.insertBefore(switchLink[i], switchLink[i - 1]);
        }
        switchLink[i].count = i;
        switchLink[i].onmouseover = function () { showAdv(this.count); clearTimeout(autoRunAdv); };
        switchLink[i].onmouseout = function () { autoRunAdv = setTimeout("autoShowAdv()", 3000); this.className = "on"; };
    }
}

function showAdv(num) {
    adv.currentImg.src = adv.Imgs[num].src;
    adv.currentImg.style.display = "none";
    $(adv.currentImg).fadeTo("slow", 1);
    adv.currentLink.href = adv.Links[num].href;

    //alert($("#advFocus").children('a').eq(num).attr("onclick"));
    $("#currentAdvLink").attr("onclick", $("#advFocus").children('a').eq(num).attr("onclick"));
    //adv.currentLink.arrt("onclick", adv.Clicks[num].arrt("onclick"));

    if (adv.Links[num].title.length != 0) {
        $("#advTitle").show();
        adv.titleLink.innerHTML = adv.Links[num].title;
        adv.titleLink.href = adv.Links[num].href;
    }
    else {
        $("#advTitle").hide();
    }

    adv.currentImg.onmouseover = function () { clearTimeout(autoRunAdv); };
    adv.currentImg.onmouseout = function () { autoShowAdv(); };
    adv.titleLink.onmouseover = function () { clearTimeout(autoRunAdv); };
    adv.titleLink.onmouseout = function () { autoShowAdv(); };

    for (var i = 0; i < adv.TotalImg; i++) {
        if (i != num) { adv.switchLinks[i].className = ""; }
    }
}

function autoShowAdv() {
    if (adv.TotalImg <= 0) {
        adv.currentLink.style.display = "none";
        return false;
    }

    if (adv.currentNum <= adv.TotalImg - 1) {
        
        showAdv(adv.currentNum);
        adv.currentNum++;
        //adv.switchLinks[adv.currentNum].className = "on";
        autoRunAdv = setTimeout("autoShowAdv()", 3000);
    }
    else {
        adv.currentNum = 0;
        clearTimeout(autoRunAdv);
        autoShowAdv();
    }
}

function ie6Or7() {
    var browser = navigator.appName;
    var b_version = navigator.appVersion;
    var version = b_version.split(";");
    if (version[1] == null) return false;
    var trim_Version = version[1].replace(/[ ]/g, "");
    if (browser == "Microsoft Internet Explorer" && trim_Version == "MSIE6.0") {
        return true;
    }
    else if (browser == "Microsoft Internet Explorer" && trim_Version == "MSIE7.0") {
        return true;
    }
    else {
        return false;
    }
}

$(document).ready(function () {
    adv();
    setAdvs();
    autoShowAdv();
});
