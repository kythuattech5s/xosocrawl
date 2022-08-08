let MAIN = {
    init: function () {
        this.initDatePicker();
    },
    initDatePicker: function () {
        const elem = document.querySelector("#searchDate");
        const datepicker = new Datepicker(elem, {
            autohide: true,
            format: "dd/mm/yyyy",
            todayBtn: true,
            todayHighlight: true,
            weekStart: 1,
            language: "vi",
        });
    },
};
MAIN.init();
