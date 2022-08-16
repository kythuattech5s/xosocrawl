let MAIN = {
    init: function () {
        this.initDatePicker();
    },
    initShowDigit: function () {
        let inputs = document.querySelectorAll("[name=showed-digits]");
    },
    initDatePicker: function () {
        const elem = document.querySelector("#searchDate");
        if (!elem) return;
        const datepicker = new Datepicker(elem, {
            autohide: true,
            format: "dd/mm/yyyy",
            todayBtn: true,
            todayHighlight: true,
            weekStart: 1,
            language: "vi",
        });
        elem.addEventListener("changeDate", async function (event) {
            let date = event.detail.date;
            let month = date.getMonth() + 1;
            month = month < 10 ? "0" + month : month;
            let day = date.getDate();
            day = day < 10 ? "0" + day : day;
            let strDate = date.getFullYear() + "-" + month + "-" + day;
            let link =
                "get-link-lotto-target?" +
                new URLSearchParams({
                    date: strDate,
                    type: LOTTO_TYPE,
                    category: LOTTO_CATEGORY,
                    item: LOTTO_ITEM,
                }).toString();
            let content = await fetch(link, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });
            let json = await content.json();
            if (json.code == 200 && json.link != "") {
                window.location.href = json.link;
            }
        });
    },
};
MAIN.init();
