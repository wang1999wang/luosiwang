(function (a) {
    var b, c, d, e, f, g;
    var uiv = {};
    if (window.ECommerce) uiv = window.ECommerce;
    uiv.AddStandardSearch = function (id,kwd) {
        a.ajax({
            async: false,
            //cache: false,
            timeout: 6E4,
            type: "POST",
            url: "/Ajax/StandardAjaxPage.aspx?t=addstandardsearch",
            data: { stid: id,
                keyword: kwd               
            },
            dataType: "json",
            //data: $(this).serialize(),                    
            //data: { contact: a("input[name='Contact']").val(), tel: a("input[name='TelNumber']").val(), em: a("input[name='Email']").val(), ad: a("input[name='Address']").val(), ps: a("input[name='PostCode']").val() },
            //dataType: "json",
            success: function (result) {
                if (result.status.code == "1001") {
                }
                else {
                }
            },
            error: function (result) {  }
        });
    }
})(jQuery);
