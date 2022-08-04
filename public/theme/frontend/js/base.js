var BASE_GUI = {
    showNotifyWhenLoadPage: function () {
        if (
            typeof typeNotify != "undefined" &&
            typeNotify != undefined &&
            typeNotify != "" &&
            typeof messageNotify != "undefined" &&
            messageNotify != undefined &&
            messageNotify != ""
        ) {
            BASE_GUI.showNotify(typeNotify, messageNotify);
        }
    },
    showNotify: function (code, message) {
        console.log(code);
        console.log(message);
        if (typeof Toastify !== "function") {
            alert(message);
            return;
        }
        /* Before show then clear all toastr previous */
        for (const toastr of document.querySelectorAll(".toastify")) {
            toastr.remove();
        }
        Toastify({
            text: message,
            close: true,
            backgroundColor:
                code == 200
                    ? "linear-gradient(to right, rgb(0, 176, 155), rgb(150, 201, 61))"
                    : "linear-gradient(to right, rgb(255, 95, 109), rgb(255, 195, 113))",
        }).showToast();
    },
};
document.addEventListener("DOMContentLoaded", function () {
    BASE_GUI.showNotifyWhenLoadPage();
});
