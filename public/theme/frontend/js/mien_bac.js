let MIEN_BAC = {
    init: function () {
        this.loadResultInit();
        this.initPagination();
    },
    initPagination: function () {
        let self = this;
        document
            .querySelector("#result-see-more")
            .addEventListener("click", async function (e) {
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
        let result = doc.querySelector("#ajax-result-table");
        let box = document.querySelector("#box-result-more");
        box.innerHTML += result.innerHTML;
        let linkNext = doc.querySelector('#hidden-paginate-links [rel="next"]');
        if (linkNext) {
            document
                .querySelector("#result-see-more")
                .setAttribute("data-href", linkNext.href);
        }
    },
    loadResultInit: async function () {
        let box = document.querySelector("#box-result-more");
        if (!box) return;
        let id = box.getAttribute("lotto-record-id");
        let type = box.getAttribute("lotto-type");
        this.loadMoreResult(
            "xo-so-mien-bac-more?lotto_recrod_id=" + id + "&lotto_type=" + type
        );
    },
};
MIEN_BAC.init();
