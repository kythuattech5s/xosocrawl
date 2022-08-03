var trialInterval,
    SLOW_INTERVAL = 6e3,
    FAST_INTERVAL = 4000,
    xsmn = {
        httpUrl: "",
        is_alert: !1,
        checkInterval: FAST_INTERVAL,
        topic: "",
        load_type: "html",
        recent_load: 0,
        loadUrl: "",
        updateBlock: "",
        data: null,
        dataType: 0,
        socket_client: null,
        socketUri: null,
        socketRooms: [],
        data_md5: "a",
        timeout_count: 0,
        messageEvents: [],
        isLive: !1,
        isShowingEvent: !1,
        isEnableEvent: !1,
        resultEventData: null,
        isToggleBackground: !0,
        provinces: [
            {
                id: 1,
                code: "mb",
                name: "Miền Bắc",
                position: 1,
                region: 1,
                live: [2, 3, 4, 5, 6, 7, 8],
            },
            {
                id: 18,
                code: "tn",
                name: "Tây Ninh",
                position: 2,
                region: 3,
                live: [5],
            },
            {
                id: 4,
                code: "bt",
                name: "Bến Tre",
                position: 3,
                region: 3,
                live: [3],
            },
            {
                id: 22,
                code: "vt",
                name: "Vũng Tàu",
                position: 4,
                region: 3,
                live: [3],
            },
            {
                id: 21,
                code: "vl",
                name: "Vĩnh Long",
                position: 5,
                region: 3,
                live: [6],
            },
            {
                id: 14,
                code: "hcm",
                name: "TP Hồ Chí Minh",
                position: 6,
                region: 3,
                live: [2, 7],
            },
            {
                id: 2,
                code: "ag",
                name: "An Giang",
                position: 7,
                region: 3,
                live: [5],
            },
            {
                id: 16,
                code: "la",
                name: "Long An",
                position: 8,
                region: 3,
                live: [7],
            },
            {
                id: 11,
                code: "dn",
                name: "Đồng Nai",
                position: 9,
                region: 3,
                live: [4],
            },
            {
                id: 19,
                code: "tg",
                name: "Tiền Giang",
                position: 10,
                region: 3,
                live: [8],
            },
            {
                id: 9,
                code: "ct",
                name: "Cần Thơ",
                position: 11,
                region: 3,
                live: [4],
            },
            {
                id: 12,
                code: "dt",
                name: "Đồng Tháp",
                position: 12,
                region: 3,
                live: [2],
            },
            {
                id: 6,
                code: "bp",
                name: "Bình Phước",
                position: 13,
                region: 3,
                live: [7],
            },
            {
                id: 8,
                code: "cm",
                name: "Cà Mau",
                position: 14,
                region: 3,
                live: [2],
            },
            {
                id: 15,
                code: "kg",
                name: "Kiên Giang",
                position: 15,
                region: 3,
                live: [8],
            },
            {
                id: 13,
                code: "hg",
                name: "Hậu Giang",
                position: 16,
                region: 3,
                live: [7],
            },
            {
                id: 17,
                code: "st",
                name: "Sóc Trăng",
                position: 17,
                region: 3,
                live: [4],
            },
            {
                id: 7,
                code: "bth",
                name: "Bình Thuận",
                position: 18,
                region: 3,
                live: [5],
            },
            {
                id: 10,
                code: "dl",
                name: "Đà Lạt",
                position: 19,
                region: 3,
                live: [8],
            },
            {
                id: 5,
                code: "bd",
                name: "Bình Dương",
                position: 20,
                region: 3,
                live: [6],
            },
            {
                id: 20,
                code: "tv",
                name: "Trà Vinh",
                position: 21,
                region: 3,
                live: [6],
            },
            {
                id: 3,
                code: "bl",
                name: "Bạc Liêu",
                position: 22,
                region: 3,
                live: [3],
            },
            {
                id: 23,
                code: "bdi",
                name: "Bình Định",
                position: 23,
                region: 2,
                live: [5],
            },
            {
                id: 24,
                code: "dng",
                name: "Đà Nẵng",
                position: 24,
                region: 2,
                live: [4, 7],
            },
            {
                id: 25,
                code: "dlk",
                name: "Đắc Lắc",
                position: 25,
                region: 2,
                live: [3],
            },
            {
                id: 33,
                code: "qng",
                name: "Quảng Ngãi",
                position: 26,
                region: 2,
                live: [7],
            },
            {
                id: 27,
                code: "gl",
                name: "Gia Lai",
                position: 27,
                region: 2,
                live: [6],
            },
            {
                id: 28,
                code: "kh",
                name: "Khánh Hòa",
                position: 28,
                region: 2,
                live: [4, 8],
            },
            {
                id: 29,
                code: "kt",
                name: "Kon Tum",
                position: 29,
                region: 2,
                live: [8],
            },
            {
                id: 30,
                code: "nt",
                name: "Ninh Thuận",
                position: 30,
                region: 2,
                live: [6],
            },
            {
                id: 36,
                code: "tth",
                name: "Thừa Thiên Huế",
                position: 31,
                region: 2,
                live: [2, 8],
            },
            {
                id: 35,
                code: "qt",
                name: "Quảng Trị",
                position: 32,
                region: 2,
                live: [5],
            },
            {
                id: 26,
                code: "dno",
                name: "Đắc Nông",
                position: 33,
                region: 2,
                live: [7],
            },
            {
                id: 34,
                code: "qnm",
                name: "Quảng Nam",
                position: 34,
                region: 2,
                live: [3],
            },
            {
                id: 32,
                code: "qb",
                name: "Quảng Bình",
                position: 35,
                region: 2,
                live: [5],
            },
            {
                id: 31,
                code: "py",
                name: "Phú Yên",
                position: 36,
                region: 2,
                live: [2],
            },
            {
                id: 37,
                code: "hn",
                name: "Hà Nội",
                position: 37,
                region: 1,
                live: [2, 5],
            },
            {
                id: 38,
                code: "qn",
                name: "Quảng Ninh",
                position: 38,
                region: 1,
                live: [3],
            },
            {
                id: 39,
                code: "bn",
                name: "Bắc Ninh",
                position: 39,
                region: 1,
                live: [4],
            },
            {
                id: 40,
                code: "hp",
                name: "Hải Phòng",
                position: 40,
                region: 1,
                live: [6],
            },
            {
                id: 41,
                code: "nd",
                name: "Nam Định",
                position: 41,
                region: 1,
                live: [7],
            },
            {
                id: 42,
                code: "tb",
                name: "Thái Bình",
                position: 42,
                region: 1,
                live: [8],
            },
        ],
        resultLabels: {
            mb: {
                db: "Đặc biệt",
                g1: "Giải nhất",
                g2: "Giải nhì",
                g3: "Giải ba",
                g4: "Giải tư",
                g5: "Giải năm",
                g6: "Giải sáu",
                g7: "Giải bảy",
                madb: "Mã ĐB:",
            },
            mt: {
                db: "ĐB",
                g1: "G1",
                g2: "G2",
                g3: "G3",
                g4: "G4",
                g5: "G5",
                g6: "G6",
                g7: "G7",
                g8: "G8",
            },
            mn: {
                db: "ĐB",
                g1: "G1",
                g2: "G2",
                g3: "G3",
                g4: "G4",
                g5: "G5",
                g6: "G6",
                g7: "G7",
                g8: "G8",
            },
            tinh: {
                db: "Đặc biệt",
                g1: "Giải nhất",
                g2: "Giải nhì",
                g3: "Giải ba",
                g4: "Giải tư",
                g5: "Giải năm",
                g6: "Giải sáu",
                g7: "Giải bảy",
                g8: "Giải tám",
            },
        },
        lotoLength: {
            mb: 1,
            mt: 1,
            mn: 1,
            tinh: 1,
        },
        layoutStyle: {
            mb: 4,
            mt: 4,
            mn: 4,
            tinh: 4,
        },
        intervals: {},
    },
    xsCommon = xsCommon || {};
xsCommon.mayManBox = function () {
    var t = document.getElementById("mySelect_ngay").value,
        e = document.getElementById("mySelect_thang").value,
        n = document.getElementById("mySelect").value;
    if (0 == t || 0 == e || 0 == n)
        0 == t
            ? ($("#thongbao").remove(),
              $(".submitmm").before(
                  "<p id='thongbao' class='clnote'>Vui lòng chọn ngày sinh của bạn</p>"
              ))
            : 0 == e
            ? ($("#thongbao").remove(),
              $(".submitmm").before(
                  "<p id='thongbao' class='clnote'>Vui lòng chọn tháng sinh của bạn</p>"
              ))
            : 0 == n &&
              ($("#thongbao").remove(),
              $(".submitmm").before(
                  "<p id='thongbao' class='clnote'>Vui lòng chọn năm sinh của bạn</p>"
              ));
    else {
        if (
            ($("#bmayman").addClass("loading-opacity"),
            setTimeout(() => $("#bmayman").removeClass("loading-opacity"), 3e3),
            $(".ketqua").delay(3e3).fadeIn(2e3),
            $("#mySelect_ngay").attr("disabled", "disabled"),
            $("#mySelect_thang").attr("disabled", "disabled"),
            $("#mySelect").attr("disabled", "disabled"),
            $(".submitmm").fadeOut(3e3),
            $(".xemlai").delay(3e3).fadeIn(),
            1 == e)
        )
            if ((t = document.getElementById("mySelect_ngay").value) > 20)
                var o = "Bảo Bình",
                    a = "Thiên Vương",
                    i = "Xanh da trời, Bạc, Ngọc lam";
            else (o = "Ma Kết"), (a = "Thổ Tinh"), (i = "Đen, Nâu");
        else if (2 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 19)
                (o = "Song Ngư"),
                    (a = "Hải Vương Tinh"),
                    (i = "Xanh biển, Trắng, Đen");
            else
                (o = "Bảo Bình"),
                    (a = "Thiên Vương"),
                    (i = "Xanh da trời, Bạc, Ngọc lam");
        } else if (3 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 20)
                (o = "Bạch Dương"), (a = "Hoả Tinh"), (i = "Đỏ, Trắng");
            else
                (o = "Song Ngư"),
                    (a = "Hải Vương Tinh"),
                    (i = "Xanh biển, Trắng, Đen");
        } else if (4 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 20)
                (o = "Kim Ngưu"), (a = "Kim Tinh"), (i = "Xanh lá, Vàng");
            else (o = "Bạch Dương"), (a = "Hoả Tinh"), (i = "Đỏ, Trắng");
        } else if (5 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 21)
                (o = "Song Tử"), (a = "Thuỷ Tinh"), (i = "Vàng, Xám");
            else (o = "Kim Ngưu"), (a = "Kim Tinh"), (i = "Xanh lá, Vàng");
        } else if (6 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 21)
                (o = "Cự Giải"), (a = "Mặt Trăng"), (i = "Vàng, Nâu đất, Xám");
            else (o = "Song Tử"), (a = "Thuỷ Tinh"), (i = "Vàng, Xám");
        } else if (7 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 22)
                (o = "Sư Tử"), (a = "Mặt Trời"), (i = "Vàng, Trắng");
            else (o = "Cự Giải"), (a = "Mặt Trăng"), (i = "Vàng, Nâu đất, Xám");
        } else if (8 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 22)
                (o = "Xử Nữ"), (a = "Thuỷ Tinh"), (i = "Xanh lá, Vàng");
            else (o = "Sư Tử"), (a = "Mặt Trời"), (i = "Vàng, Trắng");
        } else if (9 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 23)
                (o = "Thiên Bình"),
                    (a = "Kim Tinh"),
                    (i = "Hồng, Vàng chanh, Xanh dương");
            else (o = "Xử Nữ"), (a = "Thuỷ Tinh"), (i = "Xanh lá, Vàng");
        } else if (10 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 23)
                (o = "Thần Nông"),
                    (a = "Diêm Vương Tinh"),
                    (i = "Đỏ, Nâu, Đen");
            else
                (o = "Thiên Bình"),
                    (a = "Kim Tinh"),
                    (i = "Hồng, Vàng chanh, Xanh dương");
        } else if (11 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 22)
                (o = "Nhân Mã"), (a = "Mộc Tinh"), (i = "Tím, Vàng, Đỏ tươi");
            else
                (o = "Thần Nông"),
                    (a = "Diêm Vương Tinh"),
                    (i = "Đỏ, Nâu, Đen");
        } else if (12 == e) {
            if ((t = document.getElementById("mySelect_ngay").value) > 21)
                (o = "Ma Kết"), (a = "Thổ Tinh"), (i = "Đen, Nâu");
            else (o = "Nhân Mã"), (a = "Mộc Tinh"), (i = "Tím, Vàng, Đỏ tươi");
        }
        (document.getElementById("cung_hd").innerHTML = o),
            (document.getElementById("sao").innerHTML = a),
            (document.getElementById("mau_sac").innerHTML = i);
        var s = new Date();
        e = s.getMonth() + 1;
        var r = s.getDate() + "/" + e + "/" + s.getFullYear();
        (document.getElementById("show_ngay").innerHTML = r),
            $(".showkq1").html(xsCommon.soDep(Math.floor(100 * Math.random()))),
            $(".showkq2").html(xsCommon.soDep(Math.floor(100 * Math.random()))),
            $(".showkq3").html(xsCommon.soDep(Math.floor(100 * Math.random()))),
            $(".showkq12").html(
                xsCommon.soDep(Math.floor(100 * Math.random()))
            ),
            $(".showkq22").html(
                xsCommon.soDep(Math.floor(100 * Math.random()))
            ),
            $(".showkq32").html(
                xsCommon.soDep(Math.floor(100 * Math.random()))
            );
    }
};
xsCommon.mayManLai = function () {
    $(".submitmm").fadeIn(),
        $(".xemlai").fadeOut(500),
        $("#mySelect_ngay").removeAttr("disabled"),
        $("#mySelect_thang").removeAttr("disabled"),
        $("#mySelect").removeAttr("disabled"),
        $("#ketqua").fadeOut(),
        $("#thongbao").remove(),
        $("#loading").remove();
};
xsCommon.soDep = function (t) {
    return t < 10 ? "0" + t : t;
};
xsmn.startTrialRolling = function (t, e, n) {
    let o,
        a = "",
        i = "",
        s = 0;
    o = Array.isArray(e) ? [] : {};
    let r = (t, e, n) => {
            let o = 0,
                a = 0;
            (e.provinceCode = t.provinceCode),
                (e.provinceName = t.provinceName),
                (e.resultDate = t.resultDate),
                (e.lotData = {});
            let i = ["8", "7", "6", "5", "4", "3", "2", "1", "DB"];
            return (
                "MB" == t.provinceCode &&
                    (i = ["1", "2", "3", "4", "5", "6", "7", "MaDb", "DB"]),
                i.forEach((i) => {
                    t.lotData.hasOwnProperty(i) &&
                        t.lotData[i].forEach((t) => {
                            e.lotData.hasOwnProperty(i) || (e.lotData[i] = []),
                                o < n
                                    ? (e.lotData[i].push(t), o++)
                                    : e.lotData[i].push(""),
                                a++;
                        });
                }),
                a == n
            );
        },
        l = () => {
            let n = ((t, e, n) => {
                let o = !1;
                if (t.hasOwnProperty("lotData")) o = r(t, e, n);
                else {
                    let a = [];
                    (o = !0),
                        t.forEach((e) => {
                            a.push(Math.floor(n / t.length));
                        });
                    for (let e = 0; e < n % t.length; e++) a[e] += 1;
                    for (let n = 0; n < t.length; n++) {
                        e[n] = {};
                        let i = r(t[n], e[n], a[n]);
                        o = o && i;
                    }
                }
                return o;
            })(e, o, ++s);
            Array.isArray(o)
                ? 4 == xsmn.layoutStyle.mn
                    ? (xsmn.drawRegionById(o),
                      xsmn.drawRegionLotoById(o, xsmn.lotoLength.mn))
                    : ((i = xsmn.drawRegionLoto(o)), (a = xsmn.drawRegion(o)))
                : "MB" == o.provinceCode
                ? 4 == xsmn.layoutStyle.mb
                    ? (xsmn.drawMbById(o),
                      xsmn.drawMbLotoById(o, xsmn.lotoLength.mb))
                    : ((a =
                          2 == xsmn.layoutStyle.mb
                              ? xsmn.drawMbHorizontal(o)
                              : xsmn.drawMb(o)),
                      (i = xsmn.drawMbLoto(o, xsmn.lotoLength.mb)),
                      (html2 =
                          3 == xsmn.layoutStyle.mb
                              ? xsmn.drawMbBangLoto(o)
                              : ""))
                : 4 == xsmn.layoutStyle.tinh
                ? (xsmn.drawProvinceById(o),
                  xsmn.drawMbLotoById(o, xsmn.lotoLength.mb))
                : ((a = xsmn.drawProvince(o)),
                  (i = xsmn.drawMbLoto(o, xsmn.lotoLength.tinh))),
                (o.hasOwnProperty("lotData") &&
                    (("MB" == o.provinceCode && 4 == xsmn.layoutStyle.mb) ||
                        ("MB" != o.provinceCode &&
                            4 == xsmn.layoutStyle.tinh))) ||
                    (!o.hasOwnProperty("lotData") &&
                        4 == xsmn.layoutStyle.mn) ||
                    ($(t + " [data-id='kq'] table tbody").html(a),
                    $(t + " [data-id='dd']").html(i)),
                xsmn.refreshCtrlPanel(
                    document.querySelector(t + " [data-id='kq'] table")
                ),
                n && clearInterval(trialInterval);
        };
    clearInterval(trialInterval), l(), (trialInterval = setInterval(l, n));
};
xsmn.drawMbHorizontal = function (t) {
    var e = t.lotData;
    (t = xsmn.generateLotoValue(t)), (e = xsmn.getLastValMb(e));
    var n = "";
    (n += '<tr class=\'madb\'><td colspan="13" class="">Mã ĐB:'),
        e.hasOwnProperty("MaDb") &&
            (e.MaDb.forEach(function (t) {
                n += " <b" + ("" == t ? " class=''>" : ">" + t) + "</b> -";
            }),
            n.endsWith(" -") && (n = n.substr(0, n.length - 2)));
    var o = t.lotData.DB + "",
        a = "" == o ? "" : o.slice(-2),
        i = "" == a ? "" : a.slice(-1);
    drawDauLoto = function (e) {
        var n = "";
        return (
            t.dau[e].forEach(function (t) {
                n +=
                    "," +
                    ("" != t && t == i && e == a
                        ? "<span class='clnote'>" + t + "</span>"
                        : t);
            }),
            "" != n ? n.substring(1) : ""
        );
    };
    var s = 0;
    return (
        (n += "</td><td class='bold'>Đầu</td><td class='bold'>Đuôi</td></tr>"),
        (n +=
            "<tr class='db'><td class='txt-giai'>ĐB</td><td colspan='12' class='number'><b data-nc=5 " +
            ("" == e.DB ? " class='imgloadig'>" : ">" + e.DB) +
            "</b></td><td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr>"),
        (n +=
            "<tr class=''><td class='txt-giai'>G1</td><td colspan='12' class='number'><b data-nc=5 " +
            ("" == e[1] ? " class='imgloadig'>" : ">" + e[1]) +
            "</b></td><td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr>"),
        (n += "<tr><td class='txt-giai'>G2</td>"),
        e[2].forEach(function (t) {
            n +=
                "<td colspan='6' class='number'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "<td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr><tr class='giai3 '><td class='txt-giai' rowspan='2'>G3</td>"),
        e[3].slice(0, 3).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "<td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr><tr class=''>"),
        e[3].slice(3, 6).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "<td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr><tr><td class='txt-giai'>G4</td>"),
        e[4].forEach(function (t) {
            n +=
                "<td class='number' colspan='3'><b data-nc=4 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "<td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr><tr class='giai5 '><td class='txt-giai' rowspan='2'>G5</td>"),
        e[5].slice(0, 3).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=4 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "<td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr><tr class=''>"),
        e[5].slice(3, 6).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=4 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "<td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr><tr><td class='txt-giai'>G6</td>"),
        e[6].forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=3 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "<td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr><tr class=''><td class='txt-giai'>G7</td>"),
        e[7].forEach(function (t) {
            n +=
                "<td class='number' colspan='3'><b data-nc=2 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "<td class='bold clnote'>" +
            s +
            "</td><td>" +
            drawDauLoto(s++) +
            "</td></tr>")
    );
};
xsmn.drawMb = function (t) {
    var e = t.lotData;
    e = xsmn.getLastValMb(e);
    var n = "";
    return (
        (n +=
            "<tr class='madb'><td colspan=\"13\">" + xsmn.resultLabels.mb.madb),
        e.hasOwnProperty("MaDb") &&
            (e.MaDb.forEach(function (t) {
                n += " <b" + ("" == t ? " class=''>" : ">" + t) + "</b> -";
            }),
            n.endsWith(" -") && (n = n.substr(0, n.length - 2))),
        (n += "</td></tr>"),
        (n +=
            "<tr class='db'><td class='txt-giai'>" +
            xsmn.resultLabels.mb.db +
            "</td><td colspan='12' class='number'><b data-nc=5 " +
            ("" == e.DB ? " class='imgloadig'>" : ">" + e.DB) +
            "</b></td></tr>"),
        (n +=
            "<tr><td class='txt-giai'>" +
            xsmn.resultLabels.mb.g1 +
            "</td><td colspan='12' class='number'><b data-nc=5 " +
            ("" == e[1] ? " class='imgloadig'>" : ">" + e[1]) +
            "</b></td></tr>"),
        (n += "<tr><td class='txt-giai'>" + xsmn.resultLabels.mb.g2 + "</td>"),
        e[2].forEach(function (t) {
            n +=
                "<td colspan='6' class='number'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "</tr><tr class='giai3'><td class='txt-giai' rowspan='2'>" +
            xsmn.resultLabels.mb.g3 +
            "</td>"),
        e[3].slice(0, 3).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n += "</tr><tr>"),
        e[3].slice(3, 6).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "</tr><tr><td class='txt-giai'>" +
            xsmn.resultLabels.mb.g4 +
            "</td>"),
        e[4].forEach(function (t) {
            n +=
                "<td class='number' colspan='3'><b data-nc=4 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "</tr><tr class='giai5'><td class='txt-giai' rowspan='2'>" +
            xsmn.resultLabels.mb.g5 +
            "</td>"),
        e[5].slice(0, 3).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=4 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n += "</tr><tr>"),
        e[5].slice(3, 6).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=4 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "</tr><tr><td class='txt-giai'>" +
            xsmn.resultLabels.mb.g6 +
            "</td>"),
        e[6].forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=3 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "</tr><tr class='g7'><td class='txt-giai'>" +
            xsmn.resultLabels.mb.g7 +
            "</td>"),
        e[7].forEach(function (t) {
            n +=
                "<td class='number' colspan='3'><b data-nc=2 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n += "</tr>")
    );
};
xsmn.getLastValMb = function (t) {
    for (var e = "", n = 1; n < 8; n++)
        t[n].forEach(function (t) {
            e = "" != t ? t : e;
        });
    if ("" == (e = "" != t.DB ? t.DB : e)) return t;
    var o = {};
    t.DB == e
        ? ((o.DB = ['<span class="cl-red">' + t.DB + "</span>"]), (e = ""))
        : (o.DB = t.DB),
        t.hasOwnProperty("MaDb") && (o.MaDb = t.MaDb);
    for (n = 7; n > 0; n--)
        (o[n] = []),
            t[n].forEach(function (t) {
                t.trim() == e.trim() &&
                    (t = '<span class="clnote">' + t + "</span>"),
                    o[n].push(t);
            });
    return o;
};
xsmn.drawMbLoto = function (t, e) {
    for (
        var n = (t.lotData.DB + "").slice(-2), o = [], a = [], i = 0;
        i < 10;
        i++
    )
        (o[i + ""] = []), (a[i + ""] = []);
    for (var s in t.lotData)
        t.lotData.hasOwnProperty(s) &&
            "MaDb" != s &&
            t.lotData[s].forEach(function (t) {
                "" != t.replace(/\D+/g, "") &&
                    (o[t.slice(-2, -1)].push(t.slice(1 == e ? -1 : -2)),
                    a[t.slice(-1)].push(
                        1 == e ? t.slice(-2, -1) : t.slice(-2)
                    ));
            });
    (t.dau = o), (t.duoi = a);
    var r = "" == n ? "" : n.slice(-2, -1),
        l = "" == r ? "" : n.slice(-1),
        c = !1,
        d = "",
        u =
            "<table class='firstlast-mb fl'><tbody><tr class='header'><th>Đầu</th><th>Đuôi</th></tr>";
    for (i = 0; i < 10; i++)
        (u += "<tr><td><b class='clnote'>" + i + "</b></td><td>"),
            (d = ""),
            (c = !1),
            t.dau[i].sort(),
            t.dau[i].forEach(function (t) {
                !c &&
                ((1 == e && "" != t && t == l && i == r) ||
                    (2 == e && "" != t && t == n))
                    ? ((c = !0),
                      (d += ",<span class='clnote'>" + t + "</span>"))
                    : (d += "," + t);
            }),
            (u += ("" != d ? d.substring(1) : "") + "</td></tr>");
    u +=
        "</tbody></table><table class='firstlast-mb fr'><tbody><tr class='header'><th>Đầu</th><th>Đuôi</th></tr>";
    for (i = 0; i < 10; i++)
        (u += "<tr><td>"),
            (d = ""),
            (c = !1),
            t.duoi[i].sort(),
            t.duoi[i + ""].forEach(function (t) {
                !c &&
                ((1 == e && "" != t && t == r && i == l) ||
                    (2 == e && "" != t && t == n))
                    ? ((c = !0),
                      (d += ",<span class='clnote'>" + t + "</span>"))
                    : (d += "," + t);
            }),
            (u +=
                ("" != d ? d.substring(1) : "") +
                "</td><td><b class='clnote'>" +
                i +
                "</b></td></tr>");
    return (u += "</tbody></table>");
};
xsmn.addTableCtrlPanel = function (t, e) {
    function n(t, e, n) {
        var o = document.createElement(t.toUpperCase());
        if ("string" == typeof e) o.className = e;
        else if ("object" == typeof e) {
            var a;
            for (a in e) e.hasOwnProperty(a) && o.setAttribute(a, e[a]);
        }
        return (
            "string" == typeof n
                ? (o.innerHTML = n)
                : n instanceof HTMLElement
                ? o.appendChild(n)
                : n instanceof Array &&
                  (function (t, e) {
                      if (!(e instanceof Array)) throw TypeError();
                      e.forEach(function (e) {
                          "string" == typeof e
                              ? (t.innerHTML += e)
                              : e instanceof HTMLElement && t.appendChild(e);
                      });
                  })(o, n),
            o
        );
    }
    [].forEach.call(t, function (t) {
        var o = !!t.parentNode.querySelector(".control-panel"),
            a =
                t.parentNode.querySelector(".control-panel") ||
                n("DIV", "control-panel"),
            i = t.parentNode.parentNode.getAttribute("id"),
            s =
                (t.parentNode.getAttribute("data-region"),
                t.parentNode.getAttribute("data-zoom")),
            r = t.parentNode.getAttribute("data-sub"),
            l = t.parentNode.getAttribute("data-sound"),
            c = t.parentNode.getAttribute("data-capture"),
            d =
                t.parentNode.querySelector("caption.title") ||
                n("CAPTION", "title", t.getAttribute("data-title") || ""),
            u =
                t.parentNode.querySelector("span.zoom-in-button") ||
                n("SPAN", "zoom-in-button", [
                    n("I", "icon zoom-in-icon"),
                    n("SPAN"),
                ]),
            m =
                t.parentNode.querySelector("span.capture-button") ||
                n("SPAN", "capture-button-button", [
                    n("I", "icon capture-button-icon"),
                    n("SPAN"),
                ]),
            g =
                (t.parentNode.querySelector("span.share-button") ||
                    n("SPAN", "share-button", [
                        n("I", "icon share-icon"),
                        n("SPAN"),
                    ]),
                t.parentNode.querySelector("div.subscription-button") ||
                    n("DIV", "subscription-button dspnone", [
                        n("INPUT", {
                            id: i + "_chx",
                            type: "checkbox",
                            class: "ntf-sub cbx dspnone",
                            "sub-type-id":
                                t.parentNode.getAttribute("data-region"),
                        }),
                        n("LABEL", {
                            id: i + "_chx_lbl",
                            "sub-type-id":
                                t.parentNode.getAttribute("data-region"),
                            class: "lbl1",
                            for: i + "_chx",
                        }),
                        n("SPAN"),
                    ])),
            h =
                t.parentNode.querySelector("span.sound-button") ||
                n("SPAN", "sound-button", [
                    n("I", "icon sound-icon"),
                    n("SPAN"),
                ]),
            p =
                t.parentNode.querySelector("span.zoom-out-button") ||
                n("SPAN", "zoom-out-button", n("I", "icon zoom-out-icon")),
            f = [];
        (null != s && 1 != s) || f.push(u),
            (null != c && 1 != c) || f.push(m),
            (null != r && 1 != r) || f.push(g),
            null != l && 1 == l && f.push(h);
        var b =
                t.parentNode.querySelector("div.buttons-wrapper") ||
                n("DIV", "buttons-wrapper", f),
            v =
                t.parentNode.querySelector("form.digits-form") ||
                n("FORM", "digits-form"),
            x = e(t);
        [].forEach.call(x, function (t) {
            t.children[0] || (t.number = t.innerHTML);
        }),
            void 0 === t.showedDigits && (t.showedDigits = 0),
            [0, 2, 3].forEach(function (e) {
                var a =
                    t.parentNode.querySelector(
                        "form.digits-form input[value='" + e + "']"
                    ) ||
                    n("INPUT", {
                        type: "radio",
                        name: "showed-digits",
                        value: e,
                    });
                e === t.showedDigits && (a.checked = !0);
                var s =
                    t.parentNode.querySelector(
                        "form.digits-form label[data-value='" + e + "']"
                    ) ||
                    n(
                        "LABEL",
                        {
                            class: "radio",
                            "data-value": e,
                        },
                        [a, n("B"), n("SPAN")]
                    );
                function r() {
                    [].forEach.call(x, function (e) {
                        e.number &&
                            (e.innerHTML = e.number.slice(-t.showedDigits));
                    });
                }
                (a.onchange = function () {
                    !0 === a.checked && ((t.showedDigits = e), r()),
                        (i = t.parentNode.parentNode.getAttribute("id"));
                }),
                    r(),
                    o || v.appendChild(s);
            }),
            o ||
                (a.appendChild(v),
                a.appendChild(b),
                t.parentNode.insertBefore(a, t.nextElementSibling)),
            (t.ctrlPanel = a);
        var y = function () {
            var e = t.clientWidth,
                n = t.clientHeight,
                o = window.innerWidth,
                a = window.innerHeight;
            t.style.transform = "scale(" + o / e + "," + a / n + ")";
        };
        if (
            ((u.onclick = function () {
                t.insertBefore(d, t.firstChild),
                    t.classList.add("full-screen"),
                    d.appendChild(p),
                    y(),
                    window.addEventListener("resize", y),
                    t.requestFullscreen
                        ? t.requestFullscreen()
                        : t.mozRequestFullScreen
                        ? t.mozRequestFullScreen()
                        : t.webkitRequestFullscreen &&
                          t.webkitRequestFullscreen(),
                    ga("send", "event", "zoom-in-btn", "click", "phong to");
            }),
            (p.onclick = function () {
                t.removeChild(d),
                    t.classList.remove("full-screen"),
                    (t.style.transform = ""),
                    window.removeEventListener("resize", y),
                    d.removeChild(p),
                    document.exitFullscreen
                        ? document.exitFullscreen()
                        : document.mozCancelFullScreen
                        ? document.mozCancelFullScreen()
                        : document.webkitExitFullscreen &&
                          document.webkitExitFullscreen();
            }),
            c)
        )
            if (window.Promise && !navigator.userAgent.match("CriOS")) {
                m.onclick = function () {
                    ga(
                        "send",
                        "event",
                        "capture-btn",
                        "click",
                        "try to save image"
                    ),
                        window.scrollTo(0, 0),
                        (elem = t.parentNode),
                        (title = (
                            t.parentNode.parentNode.parentNode.querySelector(
                                ".kq-title"
                            ) ||
                            t.parentNode.parentNode.parentNode.querySelector(
                                "h2"
                            )
                        ).cloneNode(!0)),
                        t.parentNode.insertBefore(
                            title,
                            t.parentNode.firstChild
                        ),
                        (t.parentNode.lastChild.style.display = "none"),
                        elem.classList.add("hide-scrollbar"),
                        (regionId = t.parentNode.getAttribute("data-region")),
                        (provinceId =
                            t.parentNode.getAttribute("data-province")),
                        (rollingDate = t.parentNode.getAttribute("data-date")),
                        (fileName =
                            1 == regionId
                                ? "xsmb_"
                                : 2 == regionId
                                ? "xsmt_"
                                : 3 == regionId
                                ? "xsmn_"
                                : ""),
                        "" == fileName &&
                            ((province = xsmn.provinces.find(
                                (t) => t.id == provinceId
                            )),
                            province &&
                                (fileName = "xs" + province.code + "_")),
                        (fileName += rollingDate || ""),
                        html2canvas(elem, {}).then(function (e) {
                            t.parentNode.removeChild(title),
                                (t.parentNode.lastChild.style.display =
                                    "block"),
                                (function (t, e = "untitled.png") {
                                    var n = document.createElement("a");
                                    (n.href = t),
                                        (n._target = "blank"),
                                        (n.download = e),
                                        document.body.appendChild(n),
                                        n.click(),
                                        n.remove();
                                })(e.toDataURL("image/png"), fileName + ".png");
                        }),
                        ga(
                            "send",
                            "event",
                            "capture-btn",
                            "click",
                            "save image success"
                        );
                };
            } else m.classList.add("hidden");
        if (l) {
            var w = document.getElementById("lottery-sound");
            null == w &&
                ((w = n(
                    "audio",
                    {
                        id: "lottery-sound",
                    },
                    [
                        n("source", {
                            src: "theme/frontend/audio/xo-so-mien-bac.mp3",
                            type: "audio/mpeg",
                        }),
                    ]
                )),
                document.body.appendChild(w)),
                (h.onclick = () => {
                    h.querySelector(".sound-icon").classList.contains("off")
                        ? (w.play(),
                          h
                              .querySelector(".sound-icon")
                              .classList.remove("off"))
                        : (w.pause(),
                          h.querySelector(".sound-icon").classList.add("off"));
                });
        }
    });
};
xsmn.addTableCtrlPanel_Old = function (t, e) {
    function n(t, e, n) {
        var o = document.createElement(t.toUpperCase());
        if ("string" == typeof e) o.className = e;
        else if ("object" == typeof e) {
            var a;
            for (a in e) e.hasOwnProperty(a) && o.setAttribute(a, e[a]);
        }
        return (
            "string" == typeof n
                ? (o.innerHTML = n)
                : n instanceof HTMLElement
                ? o.appendChild(n)
                : n instanceof Array &&
                  (function (t, e) {
                      if (!(e instanceof Array)) throw TypeError();
                      e.forEach(function (e) {
                          "string" == typeof e
                              ? (t.innerHTML += e)
                              : e instanceof HTMLElement && t.appendChild(e);
                      });
                  })(o, n),
            o
        );
    }
    [].forEach.call(t, function (t) {
        parentId = t.parentNode.parentNode.getAttribute("id");
        t.parentNode.getAttribute("data-region");
        var o = t.parentNode.getAttribute("data-zoom"),
            a = t.parentNode.getAttribute("data-sub"),
            i = t.parentNode.getAttribute("data-sound"),
            s =
                t.querySelector("caption.title") ||
                n("CAPTION", "title", t.getAttribute("data-title") || ""),
            r =
                t.querySelector("span.zoom-in-button") ||
                n("SPAN", "zoom-in-button", [
                    n("I", "icon zoom-in-icon"),
                    n("SPAN"),
                ]),
            l =
                (t.querySelector("span.share-button") ||
                    n("SPAN", "share-button", [
                        n("I", "icon share-icon"),
                        n("SPAN"),
                    ]),
                t.querySelector("div.subscription-button") ||
                    n("DIV", "subscription-button dspnone", [
                        n("INPUT", {
                            id: parentId + "_chx",
                            type: "checkbox",
                            class: "ntf-sub cbx dspnone",
                            "sub-type-id":
                                t.parentNode.getAttribute("data-region"),
                        }),
                        n("LABEL", {
                            id: parentId + "_chx_lbl",
                            "sub-type-id":
                                t.parentNode.getAttribute("data-region"),
                            class: "lbl1",
                            for: parentId + "_chx",
                        }),
                        n("SPAN"),
                    ])),
            c =
                t.querySelector("span.sound-button") ||
                n("SPAN", "sound-button", [
                    n("I", "icon sound-icon"),
                    n("SPAN"),
                ]),
            d = [];
        (null != o && 1 != o) || d.push(r),
            (null != a && 1 != a) || d.push(l),
            null != i && 1 == i && d.push(c);
        var u =
                t.querySelector("div.buttons-wrapper") ||
                n("DIV", "buttons-wrapper", d),
            m = t.querySelector("form.digits-form") || n("FORM", "digits-form"),
            g = e(t);
        [].forEach.call(g, function (t) {
            t.children[0] ||
                ((t.number = t.innerHTML),
                console.log("number is : " + t.innerHTML));
        }),
            void 0 === t.showedDigits && (t.showedDigits = 0),
            [0, 2, 3].forEach(function (e) {
                var o = n("INPUT", {
                    type: "radio",
                    name: "showed-digits",
                    value: e,
                });
                e === t.showedDigits && (o.checked = !0);
                var a = n(
                    "LABEL",
                    {
                        class: "radio",
                        "data-value": e,
                    },
                    [o, n("B"), n("SPAN")]
                );
                function i() {
                    [].forEach.call(g, function (e) {
                        e.number &&
                            (e.innerHTML = e.number.slice(-t.showedDigits));
                    });
                }
                (o.onchange = function () {
                    !0 === o.checked && ((t.showedDigits = e), i()),
                        (parentId = t.parentNode.parentNode.getAttribute("id")),
                        ga(
                            "send",
                            "event",
                            parentId + ":" + e,
                            "click",
                            "xem n so cuoi"
                        );
                }),
                    i(),
                    m.appendChild(a);
            });
        var h = n("DIV", "control-panel", [m, u]);
        t.parentNode.insertBefore(h, t.nextElementSibling), (t.ctrlPanel = h);
        var p = n("SPAN", "zoom-out-button", n("I", "icon zoom-out-icon")),
            f = function () {
                var e = t.clientWidth,
                    n = t.clientHeight,
                    o = window.innerWidth,
                    a = window.innerHeight;
                t.style.transform = "scale(" + o / e + "," + a / n + ")";
            };
        if (
            ((r.onclick = function () {
                t.insertBefore(s, t.firstChild),
                    t.classList.add("full-screen"),
                    s.appendChild(p),
                    f(),
                    window.addEventListener("resize", f),
                    t.requestFullscreen
                        ? t.requestFullscreen()
                        : t.mozRequestFullScreen
                        ? t.mozRequestFullScreen()
                        : t.webkitRequestFullscreen &&
                          t.webkitRequestFullscreen(),
                    ga("send", "event", "zoom-in-btn", "click", "phong to");
            }),
            (p.onclick = function () {
                t.removeChild(s),
                    t.classList.remove("full-screen"),
                    (t.style.transform = ""),
                    window.removeEventListener("resize", f),
                    s.removeChild(p),
                    document.exitFullscreen
                        ? document.exitFullscreen()
                        : document.mozCancelFullScreen
                        ? document.mozCancelFullScreen()
                        : document.webkitExitFullscreen &&
                          document.webkitExitFullscreen();
            }),
            i)
        ) {
            var b = document.getElementById("lottery-sound");
            null == b &&
                ((b = n(
                    "audio",
                    {
                        id: "lottery-sound",
                    },
                    [
                        n("source", {
                            src: "theme/frontend/audio/xo-so-mien-bac.mp3",
                            type: "audio/mpeg",
                        }),
                    ]
                )),
                document.body.appendChild(b)),
                (c.onclick = () => {
                    c.querySelector(".sound-icon").classList.contains("off")
                        ? (b.play(),
                          c
                              .querySelector(".sound-icon")
                              .classList.remove("off"))
                        : (b.pause(),
                          c.querySelector(".sound-icon").classList.add("off"));
                });
        }
    });
};
xsmn.removeTableCtrlPanel = function (t) {
    [].forEach.call(t, function (t) {
        t.ctrlPanel && t.ctrlPanel.parentNode.removeChild(t.ctrlPanel);
    });
};
xsmn.refreshCtrlPanel = function (t) {
    xsmn.removeTableCtrlPanel([t]),
        xsmn.addTableCtrlPanel([t], function (t) {
            return [].filter.call(t.querySelectorAll("td, td *"), function (t) {
                return !isNaN(t.innerHTML);
            });
        });
};
xsmn._showNumber = function (t, e) {
    t &&
        ("" != e
            ? (t.removeClass("imgloadig cl-rl"), t.html(e))
            : (t.addClass("imgloadig"), t.html("")));
};
xsmn.drawMbById = function (t) {
    var e = t.lotData;
    e = xsmn.getLastValMb(e);
    var n = $(xsmn.updateBlock + " [data-id='kq']");
    if (
        (Object.keys(xsmn.intervals).forEach(function (t, e) {
            clearInterval(xsmn.intervals[t]);
        }),
        e.hasOwnProperty("MaDb"))
    ) {
        var o = "";
        e.MaDb.forEach(function (t) {
            o += " <b" + ("" == t ? " class=''>" : ">" + t) + "</b> -";
        }),
            o.endsWith(" -") && (o = o.substr(0, o.length - 2)),
            n.find(".v-madb").html(o);
    }
    for (
        xsmn._showNumber(n.find(".v-gdb"), e.DB),
            xsmn._showNumber(n.find(".v-g1"), e[1]),
            i = 0;
        i < e[2].length;
        i++
    )
        xsmn._showNumber(n.find(".v-g2-" + i), e[2][i]);
    for (i = 0; i < e[3].length; i++)
        xsmn._showNumber(n.find(".v-g3-" + i), e[3][i]);
    for (i = 0; i < e[4].length; i++)
        xsmn._showNumber(n.find(".v-g4-" + i), e[4][i]);
    for (i = 0; i < e[5].length; i++)
        xsmn._showNumber(n.find(".v-g5-" + i), e[5][i]);
    for (i = 0; i < e[6].length; i++)
        xsmn._showNumber(n.find(".v-g6-" + i), e[6][i]);
    for (i = 0; i < e[7].length; i++)
        xsmn._showNumber(n.find(".v-g7-" + i), e[7][i]);
};
xsmn.drawMbLotoById = function (t, e) {
    for (
        var n = (t.lotData.DB + "").slice(-2),
            o = $(xsmn.updateBlock + " [data-id='dd']"),
            a = [],
            i = [],
            s = 0;
        s < 10;
        s++
    )
        (a[s + ""] = []), (i[s + ""] = []);
    for (var r in t.lotData)
        t.lotData.hasOwnProperty(r) &&
            "MaDb" != r &&
            t.lotData[r].forEach(function (t) {
                let n = t.replace(/\D+/g, "");
                n.length >= 2 &&
                    (a[n.slice(-2, -1)].push(n.slice(1 == e ? -1 : -2)),
                    i[n.slice(-1)].push(
                        1 == e ? n.slice(-2, -1) : n.slice(-2)
                    ));
            });
    (t.dau = a), (t.duoi = i);
    var l = "" == n ? "" : n.slice(-2, -1),
        c = "" == l ? "" : n.slice(-1),
        d = !1,
        u = "";
    for (s = 0; s < 10; s++)
        (u = ""),
            (d = !1),
            t.dau[s].sort(),
            t.dau[s].forEach(function (t) {
                !d &&
                ((1 == e && "" != t && t == c && s == l) ||
                    (2 == e && "" != t && t == n))
                    ? ((d = !0),
                      (u += ",<span class='clnote'>" + t + "</span>"))
                    : (u += "," + t);
            }),
            o.find(".v-loto-dau-" + s).html("" != u ? u.substring(1) : "");
    for (s = 0; s < 10; s++)
        (u = ""),
            (d = !1),
            t.duoi[s].sort(),
            t.duoi[s + ""].forEach(function (t) {
                !d &&
                ((1 == e && "" != t && t == l && s == c) ||
                    (2 == e && "" != t && t == n))
                    ? ((d = !0),
                      (u += ",<span class='clnote'>" + t + "</span>"))
                    : (u += "," + t);
            }),
            o.find(".v-loto-duoi-" + s).html("" != u ? u.substring(1) : "");
};
xsmn.drawProvince = function (t) {
    var e = t.lotData;
    e = xsmn.getLastValProvince(e);
    var n = "";
    return (
        (n +=
            "<tr class='giai8'><td class='txt-giai'>" +
            xsmn.resultLabels.tinh.g8 +
            "</td><td colspan='12' class='number'><b data-nc=2 " +
            ("" == e[8] ? " class='imgloadig'>" : ">" + e[8]) +
            "</b></td></tr>"),
        (n +=
            "<tr><td class='txt-giai'>" +
            xsmn.resultLabels.tinh.g7 +
            "</td><td colspan='12' class='number'><b data-nc=3 " +
            ("" == e[7] ? " class='imgloadig'>" : ">" + e[7]) +
            "</b></td></tr>"),
        (n +=
            "<tr><td class='txt-giai'>" + xsmn.resultLabels.tinh.g6 + "</td>"),
        e[6].forEach(function (t) {
            n +=
                "<td colspan='4' class='number'><b data-nc=4 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "</tr><tr><td class='txt-giai'>" +
            xsmn.resultLabels.tinh.g5 +
            "</td><td colspan='12' class='number'><b data-nc=4 " +
            ("" == e[5] ? " class='imgloadig'>" : ">" + e[5]) +
            "</b></td></tr>"),
        (n +=
            "</tr><tr class='giai4'><td rowspan='2' class='txt-giai'>" +
            xsmn.resultLabels.tinh.g4 +
            "</td>"),
        e[4].slice(0, 4).forEach(function (t) {
            n +=
                "<td class='number' colspan='3'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n += "</tr><tr>"),
        e[4].slice(4, 7).forEach(function (t) {
            n +=
                "<td class='number' colspan='4'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "</tr><tr><td class='txt-giai'>" +
            xsmn.resultLabels.tinh.g3 +
            "</td>"),
        e[3].forEach(function (t) {
            n +=
                "<td class='number' colspan='6'><b data-nc=5 " +
                ("" == t ? " class='imgloadig'>" : ">" + t) +
                "</b></td>";
        }),
        (n +=
            "</tr><tr><td class='txt-giai'>" +
            xsmn.resultLabels.tinh.g2 +
            "</td><td colspan='12' class='number'><b data-nc=5 " +
            ("" == e[2] ? " class='imgloadig'>" : ">" + e[2]) +
            "</b></td></tr>"),
        (n +=
            "<tr><td class='txt-giai'>" +
            xsmn.resultLabels.tinh.g1 +
            "</td><td colspan='12' class='number'><b data-nc=5 " +
            ("" == e[1] ? " class='imgloadig'>" : ">" + e[1]) +
            "</b></td></tr>"),
        (n +=
            "<tr class='db'><td class='txt-giai'>" +
            xsmn.resultLabels.tinh.db +
            "</td><td colspan='12' class='number'><b data-nc=6 " +
            ("" == e.DB ? " class='imgloadig'>" : ">" + e.DB) +
            "</b></td></tr>"),
        (n += "")
    );
};
xsmn.drawProvinceById = function (t) {
    var e = t.lotData;
    e = xsmn.getLastValProvince(e);
    var n = $(xsmn.updateBlock + " [data-id='kq']");
    for (
        Object.keys(xsmn.intervals).forEach(function (t, e) {
            clearInterval(xsmn.intervals[t]);
        }),
            xsmn._showNumber(n.find(".v-gdb"), e.DB),
            xsmn._showNumber(n.find(".v-g1"), e[1]),
            xsmn._showNumber(n.find(".v-g2"), e[2]),
            i = 0;
        i < e[3].length;
        i++
    )
        xsmn._showNumber(n.find(".v-g3-" + i), e[3][i]);
    for (i = 0; i < e[4].length; i++)
        xsmn._showNumber(n.find(".v-g4-" + i), e[4][i]);
    for (xsmn._showNumber(n.find(".v-g5"), e[5]), i = 0; i < e[6].length; i++)
        xsmn._showNumber(n.find(".v-g6-" + i), e[6][i]);
    xsmn._showNumber(n.find(".v-g7"), e[7]),
        xsmn._showNumber(n.find(".v-g8"), e[8]);
};
$(document).ready(function () {
    $(".submitmm").on("click", () => xsCommon.mayManBox());
    $(".xemlai").on("click", () => xsCommon.mayManLai());
});
