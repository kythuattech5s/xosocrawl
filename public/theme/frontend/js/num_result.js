let NUM_RESULT = {
    init: function () {
        this.initPagination();
    },
    initPagination: function () {
        let self = this;
        let button = document.querySelector("#result-see-more");
        if (!button) return;
        button.addEventListener("click", async function (e) {
            let nextLink = this.getAttribute("data-href");
            if (nextLink) {
                self.loadMoreResult(nextLink);
            }
        });
    },
    loadMoreResult: async function (link) {
        let content = await fetch(link, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });
        content = await content.text();
        var parser = new DOMParser();
        var doc = parser.parseFromString(content, "text/html");
        let button = doc.querySelector("#result-see-more");

        let nextLink = "";
        if (button) {
            button.remove();
            nextLink = button.getAttribute("data-href");
        }
        let result = doc.querySelector("#result-box-content");
        let buttonDoc = document.querySelector("#result-see-more");
        buttonDoc.insertAdjacentHTML("beforebegin", result.innerHTML);
        if (nextLink == "") {
            buttonDoc.remove();
        } else {
            buttonDoc.setAttribute("data-href", nextLink);
        }
    },
};
NUM_RESULT.init();
