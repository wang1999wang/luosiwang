//获取元素坐标

/**
* 坐标
* @param x
* @param y
* @return
*/
function CPos(x, y) {
    this.x = x;
    this.y = y;
}

/**
* 得到对象的相对浏览器的坐标
* @param ATarget
* @return
*/
function GetObjPos(ATarget) {
    var target = ATarget;
    var pos = new CPos(target.offsetLeft, target.offsetTop);

    var target = target.offsetParent;
    while (target) {
        pos.x += target.offsetLeft;
        pos.y += target.offsetTop;

        target = target.offsetParent
    }
    return pos;
}