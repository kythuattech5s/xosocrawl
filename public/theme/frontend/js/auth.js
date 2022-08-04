var AUTH_GUI = {
    registerDone(data) {
        BASE_GUI.showNotify(data.code, data.message);
        if (data.code == 200) {
            if (data.redirect) {
                window.location.href = data.redirect;
            }
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            }
        }
    },
    loginDone(data) {
        BASE_GUI.showNotify(data.code, data.message);
        if (data.code == 200) {
            if (data.redirect) {
                window.location.href = data.redirect;
            }
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            }
        }
    },
};
