xsmn.getStaticUrl = function (t) {
    let id = Math.floor(100 * Math.random());
    let id1 = 1;
    if (id < 35) {
        id1 = 1;
    } else if (id < 55) {
        id1 = 3;
    } else if (id < 60) {
        id1 = 4;
    } else if (id < 82) {
        id1 = 5;
    } else {
        id1 = 8;
    }
    return "https://s" + id1 + ".ketquaveso.com" + t;
};

function loadMiennam(loadUrl, updateBlock) {
    var linkFull = xsmn.getStaticUrl(loadUrl) + "?t=" + new Date().getTime();
    xsmn.loadKetquaMiennam(linkFull, updateBlock);
}
//https://s5.ketquaveso.com/ttkq/json_kqmt.html
loadKetquaMiennam = function (t, e) {
    $.ajax({
        type: "GET",
        url:
            "https://s5.ketquaveso.com/ttkq/json_kqmt/c90cb556c48c529d9845be8919727081?t=1660731983670" -
                1 !==
            t.indexOf("/ttkq")
                ? t.replace(".html", "/" + xsmn.data_md5)
                : t,
        data: {},
        beforeSend: function () {},
        error: function (t, e) {},
        success: function (t) {
            if ("" != t)
                if ("json" == xsmn.load_type) {
                    var n = JSON.parse(t);
                    xsmn.generateHtml(n, e) &&
                        (xsmn.data_md5 = CryptoJS.MD5(t).toString());
                } else
                    xsmn.remainInBlock(e) > (t.match(/imgloadig/g) || []).length
                        ? ((html = $.parseHTML(t)),
                          $(e + " [data-id='kq']").replaceWith(html[0]),
                          $(e + " [data-id='dd']").replaceWith(html[4]),
                          1 == xsmn.is_alert && xsmn.alertToApp())
                        : console.log("too slow, donot update");
        },
    });
};
