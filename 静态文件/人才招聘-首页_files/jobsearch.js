//处理表单，自动清空获取焦点的文本框
    $(".onFocusAutoClear").css("color", "#999");

    $(".onFocusAutoClear").click(function () {
        if ($(this).val() == this.defaultValue) {
            $(this).val("");
            $(this).css("color", "black");
        }
    });

    $(".onFocusAutoClear").blur(function () {
        if ($(this).val() == "") {
            $(this).val(this.defaultValue);
        }
        if ($(this).val() == this.defaultValue) {
            $(this).css("color", "#999");
        }
    });