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

let ROLLING_RESULT = (function () {
    let interval = null;
    let fullPrize = false;
    let count = 0;
    let getLink = function () {
        count++;
        let link =
            "convert-thu-cong-du-lieu-crawl?" +
            new URLSearchParams({
                cate: LOTTO_CATEGORY,
                count: count,
                t: Date.now(),
            }).toString();
        return link;
    };

    let init = function () {
        initFetch();
    };
    let initFetch = function () {
        let allow = checkAllow();
        interval = setInterval(
            async function () {
                await intervalFetch();
                if (fullPrize) {
                    clearInterval(interval);
                }
            },
            allow ? 4000 : 10000
        );
    };
    let checkAllow = function () {
        let currentDate = new Date(Date.parse(CURRENT_TIME));
        let hour = currentDate.getHours();
        let minute = currentDate.getMinutes();
        let allow =
            allowMienBac(hour, minute) ||
            allowMienNam(hour, minute) ||
            allowMienTrung(hour, minute);
        return allow;
    };

    let intervalFetch = async function (allow) {
        if (checkAllow()) {
            let link = getLink();
            let content = await fetch(link, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });
            let json = await content.json();
            if (!Array.isArray(json)) {
                json = [json];
            }
            fillHtml(json);
        }
    };
    let fillHtml = function (json) {
        let currentDate = new Date(Date.parse(CURRENT_TIME));
        let tmpFull = false;
        for (let i = 0; i < json.length; i++) {
            const item = json[i];
            tmpFull &= item.isFull || false;
            let provinceCode = item.provinceCode.toUpperCase();
            let lotData = item.lotData;
            let resultDate = new Date(item.resultDate);
            if (
                currentDate.getDate() == resultDate.getDate() &&
                currentDate.getMonth() == resultDate.getMonth()
            ) {
                for (const [key, values] of Object.entries(lotData)) {
                    for (let j = 0; j < values.length; j++) {
                        const value = values[j];
                        if (value == "") {
                            continue;
                        }
                        let tr = document.querySelector(
                            `.rolling-table tr.g${key.toLowerCase()}`
                        );
                        if (!tr) continue;
                        let loadig = tr.querySelector(
                            `[data-code="${provinceCode}"] .imgloadig`
                        );
                        if (!loadig) continue;
                        if (value == ".") {
                            loadig.classList.add("cl-rl");
                            rollingNumber(loadig);
                        }
                        let clrl = tr.querySelector(
                            `[data-code="${provinceCode}"] .cl-rl`
                        );
                        if (!clrl) continue;

                        if (value != "." && value != "") {
                            clrl.innerText = value;
                            clrl.classList.remove("imgloadig");
                            clrl.classList.remove("cl-rl");
                        }
                    }
                }
            }
        }
        fullPrize = tmpFull;
    };
    let lastTimestamp = 0;
    let rollingNumber = function (element) {
        window.requestAnimFrame = (function () {
            return (
                window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                window.oRequestAnimationFrame ||
                window.msRequestAnimationFrame ||
                function (callback) {
                    window.setTimeout(callback, 1000 / 60);
                }
            );
        })();
        (function animloop() {
            if (Date.now() - lastTimestamp < 1000 / 2) return;
            if (!element.classList.contains("cl-rl")) {
                cancelAnimationFrame(animloop);
                return;
            }
            requestAnimFrame(animloop);
            let no = element.getAttribute("data-nonum");
            let str = "";
            for (let i = 0; i < no; i++) {
                str += Math.floor(Math.random() * 10);
            }
            element.innerText = str;
        })();
    };
    let allowMienBac = function (hour, minute) {
        return (
            LOTTO_CATEGORY &&
            LOTTO_CATEGORY == 1 &&
            hour == 18 &&
            minute > 10 &&
            minute < 40
        );
    };
    let allowMienNam = function (hour, minute) {
        return true;
        return (
            LOTTO_CATEGORY &&
            LOTTO_CATEGORY == 1 &&
            hour == 16 &&
            minute > 10 &&
            minute < 40
        );
    };
    let allowMienTrung = function (hour, minute) {
        return (
            LOTTO_CATEGORY &&
            LOTTO_CATEGORY == 1 &&
            hour == 17 &&
            minute > 10 &&
            minute < 40
        );
    };
    init();
})();
