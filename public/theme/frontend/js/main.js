let MAIN = {
    init: function () {
        this.initDatePicker();
        this.initShowDigit();
        this.initExitFullScreen();
    },
    initShowDigit: function () {
        let self = this;
        self.on("change", "[name=showed-digits]", function (event) {
            let item = event.target;
            let nonum = item.value;
            let parent = self.findAncestor(item, "[data-id='kq']");
            let numbers = parent.querySelectorAll(".v-giai.number span");
            for (let i = 0; i < numbers.length; i++) {
                const element = numbers[i];
                let f = element.getAttribute("data-full");
                if (f == undefined) {
                    element.setAttribute("data-full", element.innerText);
                }
                f = element.getAttribute("data-full");
                element.innerText = f.slice(-parseInt(nonum));
            }
        });
        self.on("click", ".zoom-in-button", function (event) {
            let item = event.target;
            let parent = self.findAncestor(item, "[data-id='kq']");
            let table = parent.querySelector("table");
            self.fullscreen(table);
        });
    },
    initExitFullScreen: function () {
        let self = this;
        document.addEventListener("fullscreenchange", this.exitHandler, false);
        document.addEventListener(
            "mozfullscreenchange",
            this.exitHandler,
            false
        );
        document.addEventListener(
            "MSFullscreenChange",
            this.exitHandler,
            false
        );
        document.addEventListener(
            "webkitfullscreenchange",
            this.exitHandler,
            false
        );
        self.on("click", ".zoom-out-button", function (event) {
            let item = event.target;
            let element = document.querySelector(".full-screen");
            if (element) {
                self.fullscreen(element);
            }
        });
    },
    exitHandler: function () {
        if (
            !document.webkitIsFullScreen &&
            !document.mozFullScreen &&
            !document.msFullscreenElement
        ) {
            let element = document.querySelector(".full-screen");
            if (element) {
                element.classList.remove("full-screen");
            }
        }
    },
    fullscreen: function (element) {
        if (
            document.fullscreenElement ||
            document.webkitFullscreenElement ||
            document.mozFullScreenElement ||
            document.msFullscreenElement
        ) {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
            element.querySelector(".title").remove();
        } else {
            element.classList.add("full-screen");
            element.insertAdjacentHTML(
                "afterbegin",
                '<caption class="title"><span class="zoom-out-button"><i class="icon zoom-out-icon"></i></span></caption>'
            );
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen();
            }
        }
    },

    on: function (eventName, elementSelector, callback) {
        document.addEventListener(
            eventName,
            function (e) {
                for (
                    var target = e.target;
                    target && target != this;
                    target = target.parentNode
                ) {
                    if (target.matches(elementSelector)) {
                        callback(e);
                        break;
                    }
                }
            },
            false
        );
    },

    findAncestor: function (el, sel) {
        while (
            (el = el.parentElement) &&
            !(el.matches || el.matchesSelector).call(el, sel)
        );
        return el;
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
