lastScrollY = 0;
function heartBeat() {
    var diffY;
    if (document.documentElement && document.documentElement.scrollTop)
        diffY = document.documentElement.scrollTop;
    else if (document.body)
        diffY = document.body.scrollTop
    else
    { /*Netscape stuff*/ }


    percent = .1 * (diffY - lastScrollY);
    if (percent > 0) percent = Math.ceil(percent);
    else percent = Math.floor(percent);
    document.getElementById("ALayer1").style.top = parseInt(document.getElementById("ALayer1").style.top) + percent + "px";
    document.getElementById("ALayer2").style.top = parseInt(document.getElementById("ALayer1").style.top) + percent + "px";

    lastScrollY = lastScrollY + percent;

}
suspendcode12 = "<DIV id=\"ALayer1\" style='left:12px;PosITION:absolute;TOP:148px;FILTER: alpha(opacity=100);'><a href=\"http://magazine.luosi.com/\" target=\"_blank\"><img id='leftfloatad' src='/images/couplet_ad/leftbigad.gif' /></a><div align=left><img src='/images/couplet_close.gif' border=0 onclick='closeBanner();' /></div></div>"
suspendcode14 = "<div id=\"ALayer2\" style='right:12px;PosITION:absolute;TOP:148px;FILTER: alpha(opacity=100);'><a href=\"http://srcrivet.luosi.com/\" onclick=\"window.open('http://www.srcrivet.com/','_blank');\" target=\"_blank\"><img id='rightfloatad' src='/images/couplet_ad/rightbigad.gif' /></a><div align=right><img src='/images/couplet_close.gif' border=0 onclick='closeBanner();' /></div></div>"
document.write(suspendcode12);
document.write(suspendcode14);
window.setInterval("heartBeat()", 1);

function closeBanner() {
    document.getElementById("ALayer1").style.display = 'none';
    document.getElementById("ALayer2").style.display = 'none';
}

var stoleftfloat;
var storightfloat;

$(function () {
    stoleftfloat = setTimeout("$('#leftfloatad').attr('src', '/images/couplet_ad/leftsmallad.gif')", 10000);
    storightfloat = setTimeout("$('#rightfloatad').attr('src', '/images/couplet_ad/rightsmallad.gif')", 10000);

    $("#leftfloatad").mouseenter(function () { clearTimeout(stoleftfloat); $(this).attr("src", "/images/couplet_ad/leftbigad.gif"); });
    $("#leftfloatad").mouseleave(function () { stoleftfloat = setTimeout("$('#leftfloatad').attr('src', '/images/couplet_ad/leftsmallad.gif')", 5000); });

    $("#rightfloatad").mouseenter(function () { clearTimeout(storightfloat); $(this).attr("src", "/images/couplet_ad/rightbigad.gif"); });
    $("#rightfloatad").mouseleave(function () { storightfloat = setTimeout("$('#rightfloatad').attr('src', '/images/couplet_ad/rightsmallad.gif')", 5000); });

});



//setTimeout("closeBanner()",6000);