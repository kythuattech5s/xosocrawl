$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
function flyToElement(flyer, flyingTo) {
    var $func = $(this);
    var divider = 1;
    var flyerClone = $(flyer).clone();
    $(flyerClone).css({
        position: "absolute",
        top: $(flyer).offset().top + "px",
        left: $(flyer).offset().left + "px",
        opacity: 1,
        overflow: "hidden",
        "border-radius": "50%",
        "z-index": 1000,
    });
    $("body").append($(flyerClone));
    var gotoX =
        $(flyingTo).offset().left +
        $(flyingTo).width() / 2 -
        $(flyer).width() / divider / 2;
    var gotoY =
        $(flyingTo).offset().top +
        $(flyingTo).height() / 2 -
        $(flyer).height() / divider / 2;

    $(flyerClone).animate(
        {
            opacity: 0.4,
            left: gotoX,
            top: gotoY,
            width: $(flyer).width() / divider,
            height: $(flyer).height() / divider,
        },
        500,
        function () {
            $(flyerClone).fadeOut("fast", function () {
                $(flyerClone).remove();
            });
        }
    );
}
function _defineProperty(obj, key, value) {
    if (key in obj) {
        Object.defineProperty(obj, key, {
            value: value,
            enumerable: true,
            configurable: true,
            writable: true,
        });
    } else {
        obj[key] = value;
    }
    return obj;
}
function setCursorToEnd(ele) {
    var range = document.createRange();
    var sel = window.getSelection();
    range.setStart(ele, 1);
    range.collapse(true);
    sel.removeAllRanges();
    sel.addRange(range);
    ele.focus();
}
class ClickAndHold {
    constructor(target, callback) {
        _defineProperty(this, "target", void 0);
        _defineProperty(this, "callback", void 0);
        _defineProperty(this, "isHeld", void 0);
        _defineProperty(this, "activeHoldTimeoutId", void 0);
        this.target = target;
        this.callback = callback;
        this.isHeld = false;
        this.activeHoldTimeoutId = null;

        [
            // "mousedown",
            "touchstart",
        ].forEach((type) => {
            this.target.addEventListener(type, this._onHoldStart.bind(this));
        });
        [
            // "mouseup",
            // "mouseleave",
            // "mouseout",
            "touchend",
            "touchcancel",
        ].forEach((type) => {
            this.target.addEventListener(type, this._onHoldEnd.bind(this));
        });
    }
    _onHoldStart() {
        var self = this;
        this.isHeld = true;
        this.activeHoldTimeoutId = setTimeout(() => {
            if (self.isHeld) {
                this.callback();
            }
        }, 600);
    }
    _onHoldEnd() {
        this.isHeld = false;
    }
    static apply(target, callbackIn) {
        new ClickAndHold(target, callbackIn);
    }
}
class SimpleFormCommentBox {
    constructor(element, autoForcus = true) {
        _defineProperty(this, "element", void 0);
        _defineProperty(this, "autoForcus", void 0);
        _defineProperty(this, "contentBox", void 0);
        _defineProperty(this, "commentBoxIdx", void 0);
        _defineProperty(this, "commentBoxIdentifier", void 0);
        _defineProperty(this, "referrer", void 0);
        _defineProperty(this, "parent", void 0);
        _defineProperty(this, "btnSendComment", void 0);
        _defineProperty(this, "btnSendCommentText", void 0);
        _defineProperty(this, "maxLengthInput", void 0);
        _defineProperty(this, "listTagUser", void 0);
        this.element = $(element);
        this.autoForcus = autoForcus;
        this.element.addClass("executed");
        var simpleCommentBox = this.element.closest(".simple-comment-box");
        this.commentBoxIdx = simpleCommentBox.attr("idx");
        this.commentBoxIdentifier = simpleCommentBox.attr("identifier");
        this.referrer = simpleCommentBox.attr("referrer");
        this.parent = this.element.attr("target");
        this.btnSendComment = this.element.find(".btn-send-comment");
        this.btnSendCommentText = this.btnSendComment.html();
        this.listTagUser = this.element.find(".list-tag-user");
        this.maxLengthInput = 1000;
        this.initContentBox();
        this.initSendCommentAction();
        this.initBaseTagUser();
        return this;
    }
    initContentBox() {
        var self = this;
        this.contentBox = this.element.find(".comment-content").emojioneArea({
            hideSource: true,
            search: false,
            textcomplete: {
                maxCount: 5,
            },
            events: {
                ready: function () {
                    if (self.autoForcus) {
                        this.setFocus();
                    }
                },
                focus: function (editor, event) {
                    if (this.getText().length > 0) {
                        setCursorToEnd(editor[0]);
                    }
                },
                keypress: function (editor, event) {
                    var status = self.limitTextEditor(this, editor, event);
                    if (status) {
                        if (event.keyCode == 13 && !event.shiftKey) {
                            self.btnSendComment.click();
                        }
                    }
                },
            },
        });
        return this;
    }
    limitTextEditor(_this, editor, event) {
        var text = _this.getText();
        if (text.length >= this.maxLengthInput) {
            event.preventDefault();
            _this.setText(text.slice(0, this.maxLengthInput));
            editor.blur();
            return false;
        }
        return true;
    }
    initBaseTagUser() {
        this.listTagUser.find(".item-tag-user .close-icon").click(function () {
            $(this).closest(".item-tag-user").remove();
        });
    }
    openLoadTagUser(emojioneArea) {
        setTimeout(() => {
            emojioneArea.editor.blur();
        }, 0);
        this.element.append(`<div class="user-list-item-popup">
            <div class="search-user">
                <input type="text" placeholder="Nhập tên người muốn tag...">
            </div>
            <div class="user-popup-list-user">
                <div class="loader-dot">
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
                    <div class="loader-item"></div>
                </div>
                <div class="user-popup-list-user-result">
                </div>
            </div>
        </div>`);
        var userListItemPopup = $(".user-list-item-popup");
        var searchInput = userListItemPopup.find(".search-user input");
        setTimeout(() => {
            searchInput.focus();
        }, 0);
        searchInput[0].addEventListener("keydown", function (e) {
            if (e.keyCode == 27) {
                userListItemPopup.remove();
                emojioneArea.setFocus();
            }
        });
        this.initSearchTagUser(searchInput, userListItemPopup, emojioneArea);
        $(window).click(function (e) {
            if (
                userListItemPopup.has(e.target).length == 0 &&
                !userListItemPopup.is(e.target)
            ) {
                userListItemPopup.remove();
            }
        });
    }
    getListUserTagReady() {
        var listUserTagReady = "";
        this.listTagUser.find(".item-tag-user").each(function (index, element) {
            listUserTagReady += "," + $(this).attr("idx");
        });
        return listUserTagReady;
    }
    initSearchTagUser(searchInput, userListItemPopup, emojioneArea) {
        var getAuto = null;
        var self = this;
        var listUserTagReady = this.getListUserTagReady();
        $(document).on("input", searchInput, function () {
            var val = searchInput.val();
            clearTimeout(getAuto);
            var valueBox = userListItemPopup.find(".user-popup-list-user");
            var loaderDot = userListItemPopup.find(".loader-dot");
            var resultBox = userListItemPopup.find(
                ".user-popup-list-user-result"
            );
            resultBox.html("");
            if (val != "") {
                loaderDot.css("display", "block");
                valueBox.css("display", "block");
            }
            getAuto = setTimeout(function () {
                if (val == "") {
                    valueBox.css({ display: "none" });
                } else {
                    if (val.length < 3) {
                        loaderDot.css("display", "none");
                        resultBox.html(
                            `<p style="text-align:center;padding: 8px">Vui lòng nhập từ khóa it nhất 3 kí tự</p>`
                        );
                    } else {
                        $.ajax({
                            url: "basiccomment/load-user-tag-list",
                            type: "POST",
                            global: false,
                            data: {
                                val: val,
                                base_user: listUserTagReady,
                            },
                        }).done(function (data) {
                            loaderDot.css("display", "none");
                            resultBox.html(data);
                            userListItemPopup
                                .find(".item-user-popup")
                                .click(function () {
                                    var idx = $(this).attr("idx");
                                    var fullname = $(this).attr("fullname");
                                    // var htmlAdd = `<div class="item-tag-user" idx="${idx}">${fullname}<div class="close-icon">
                                    // <i class="fa-solid fa-xmark"></i>
                                    // </div></div>`;
                                    // self.listTagUser.append(htmlAdd);
                                    self.listTagUser
                                        .find(".item-tag-user .close-icon")
                                        .click(function () {
                                            $(this)
                                                .closest(".item-tag-user")
                                                .remove();
                                        });
                                    userListItemPopup.remove();
                                    var commentContent = emojioneArea.getText();
                                    var lastChar = commentContent.slice(
                                        commentContent.length - 1
                                    );
                                    emojioneArea.setFocus();
                                });
                        });
                    }
                }
            }, 300);
        });
    }
    starSending() {
        this.btnSendComment.addClass("in-loading");
        this.btnSendComment.prop("disabled", true);
        this.btnSendComment.html(`<i class="fa-solid fa-spinner fa-spin"></i>`);
    }
    endSending() {
        this.btnSendComment.removeClass("in-loading");
        this.btnSendComment.prop("disabled", false);
        this.btnSendComment.html(this.btnSendCommentText);
    }
    initSendCommentAction() {
        var self = this;
        self.btnSendComment.click(function () {
            var listUserTagReady = self.getListUserTagReady();
            var contentCommentBox = $(self.contentBox[0]).data("emojioneArea");
            var commentContent = contentCommentBox.getText();
            if (commentContent.length == 0 && listUserTagReady == "") {
                self.createNotification(
                    "Vui lòng nhập nội dung tin nhắn!",
                    "error"
                );
                return;
            }
            if (commentContent.length >= self.maxLengthInput) {
                contentCommentBox.setText(
                    commentContent.slice(0, self.maxLengthInput)
                );
                self.createNotification(
                    `Tin nhắn không thế dài quá ${self.maxLengthInput}ký tự.`,
                    "error"
                );
                return;
            }
            self.starSending();
            $.ajax({
                url: "basiccomment/send-comment",
                type: "POST",
                global: false,
                dataType: "json",
                data: {
                    content: commentContent,
                    referrer: self.referrer,
                    tagUser: listUserTagReady,
                    commentBoxIdx: self.commentBoxIdx,
                    commentBoxIdentifier: self.commentBoxIdentifier,
                    parent: self.parent,
                },
            }).done(function (data) {
                self.clearAllContent();
                self.endSending();
                if (data.code == 200) {
                    var simpleCommentBox = self.element.closest(
                        ".simple-comment-box"
                    );
                    if (self.parent == 0) {
                        simpleCommentBox
                            .find(`[cmt-target=${self.parent}]`)
                            .prepend(data.html);
                    } else {
                        simpleCommentBox
                            .find(`[cmt-target=${self.parent}]`)
                            .append(data.html);
                    }
                    basic_COMMENT.initBaseGui();
                } else {
                    self.createNotification(data.message, "error");
                }
            });
        });
    }
    createNotification(content, type) {
        this.clearNotification();
        this.element.prepend(`<div class="comment-notification ${type}">
            ${content}
        </div>`);
        var notificationBox = this.element.find(".comment-notification");
        notificationBox.slideDown(300);
        setTimeout(() => {
            notificationBox.slideUp(300);
            setTimeout(() => {
                notificationBox.remove();
            }, 300);
        }, 2500);
    }
    clearNotification() {
        this.element.find(".comment-notification").remove();
    }
    clearAllContent() {
        this.listTagUser.html("");
        var contentCommentBox = $(this.contentBox[0]).data("emojioneArea");
        contentCommentBox.setText("");
    }
}
class SimpleLikeCommentBox {
    constructor(element) {
        _defineProperty(this, "element", void 0);
        _defineProperty(this, "likeBtn", void 0);
        _defineProperty(this, "timeHold", void 0);
        _defineProperty(this, "timeClear", void 0);
        _defineProperty(this, "timeOutHover", void 0);
        _defineProperty(this, "timeOutClear", void 0);
        _defineProperty(this, "cmtLikeBoxIdx", void 0);
        this.element = $(element);
        this.timeHold = 600;
        this.timeClear = 500;
        this.timeOutHover = null;
        this.timeOutClear = null;
        this.cmtLikeBoxIdx = this.element.attr("cmt-like-box-idx");
        this.likeBtn = this.element.find(".like-comment-btn");
        this.initEmojiReactionsBox();
        this.initLikeActionGui();
        this.initLikeAction();
        this.element.addClass("executed");
        return this;
    }
    initEmojiReactionsBox() {
        this.element.append(`<div class="emoji-comment-box">
        <div class="emoji-comment emoji-comment--like">
            <div class="icon-emoji icon-emoji--like" data-type="1"></div>
        </div>
        <div class="emoji-comment emoji-comment--love">
            <div class="icon-emoji icon-emoji--heart" data-type="2"></div>
        </div>
        <div class="emoji-comment emoji-comment--haha">
            <div class="icon-emoji icon-emoji--haha" data-type="3"></div>
        </div>
        <div class="emoji-comment emoji-comment--wow">
            <div class="icon-emoji icon-emoji--wow" data-type="4"></div>
        </div>
        <div class="emoji-comment emoji-comment--sad">
            <div class="icon-emoji icon-emoji--sad" data-type="5"></div>
        </div>
        <div class="emoji-comment emoji-comment--angry">
            <div class="icon-emoji icon-emoji--angry" data-type="6"></div>
        </div>
    </div>`);
    }
    initLikeActionGui() {
        var self = this;
        self.element.on("mouseenter", function () {
            if (self.timeOutClear != null) {
                clearTimeout(self.timeOutClear);
            }
            if (self.timeOutHover != null) {
                clearTimeout(self.timeOutHover);
            }
            self.timeOutHover = setTimeout(function () {
                self.likeBtn.addClass("js-hover");
            }, self.timeHold);
        });
        self.element.on("mouseleave", function () {
            if (self.timeOutClear != null) {
                clearTimeout(self.timeOutClear);
            }
            self.timeOutClear = setTimeout(function () {
                self.likeBtn.removeClass("js-hover");
            }, self.timeClear);

            if (self.timeOutHover != null) {
                clearTimeout(self.timeOutHover);
                self.timeOutHover = null;
            }
        });
        ClickAndHold.apply(self.likeBtn[0], function () {
            if (self.timeClearMobile != null) {
                clearTimeout(self.timeClearMobile);
                self.timeClearMobile = null;
            }
            self.likeBtn.addClass("js-hover");
        });
        return this;
    }
    initLikeAction() {
        var self = this;
        self.likeBtn.click(function (e) {
            e.preventDefault();
            if (self.element.hasClass("no-login")) {
                alert("Vui lòng đăng nhập để thực hiện hành động này.");
                return;
            }
            var currentType = self.likeBtn.attr("show");
            if (currentType == "undefined" || currentType == undefined) {
                var type = $(this).data("type");
                self.doLikeComment(type);
            } else {
                self.likeBtn.removeAttr("show");
            }
            self.sendLikeComment();
        });
        self.element.find(".icon-emoji").click(function () {
            if (self.element.hasClass("no-login")) {
                alert("Vui lòng đăng nhập để thực hiện hành động này.");
                return;
            }
            var type = $(this).data("type");
            var status = self.doLikeComment(type);
            self.sendLikeComment();
            if (status) {
                flyToElement($(this), self.likeBtn);
            }
        });
    }
    doLikeComment(type) {
        var currentType = this.likeBtn.attr("show");
        this.likeBtn.removeClass("js-hover");
        if (type == currentType) {
            this.likeBtn.removeAttr("show");
        } else {
            this.likeBtn.attr("show", type);
            return true;
        }
        return false;
    }
    sendLikeComment() {
        var self = this;
        $.ajax({
            url: "basiccomment/send-like-comment",
            type: "GET",
            data: {
                target: self.cmtLikeBoxIdx,
                type: self.likeBtn.attr("show"),
            },
            global: false,
        }).done(function (json) {
            if (json.code == 200) {
                if (json.type) {
                    self.likeBtn.attr("show", json.type);
                }
                $(`.comment-count-like[target=${self.cmtLikeBoxIdx}]`).html(
                    json.htmlCountLike
                );
            } else {
                alert(json.message);
            }
        });
    }
}
var basic_COMMENT = {
    userActionCommit: true,
    init() {
        basic_COMMENT.initBaseGui(false);
        basic_COMMENT.loadCommnent(0);
        basic_COMMENT.loadChildCommnent();
        basic_COMMENT.initBtnReplyComment();
        basic_COMMENT.initViewMoreComment();
        basic_COMMENT.initChangeCommentSort();
        basic_COMMENT.initReportComment();
        basic_COMMENT.initActiveComment();
    },
    initChangeCommentSort() {
        $(document).on(
            "change",
            ".simple-comment-box .comment-fillter-sort",
            function () {
                $(this)
                    .closest(".simple-comment-box")
                    .find(".list-comment")
                    .html("");
                basic_COMMENT.userActionCommit = false;
                basic_COMMENT.loadCommnent(0);
            }
        );
    },
    initBaseGui(autoForcusCommentBox = true) {
        $(".simple-form-comment:not(.executed)").each(function (idx, element) {
            new SimpleFormCommentBox(element, autoForcusCommentBox);
        });
        $(".like-action-box:not(.executed)").each(function (idx, element) {
            new SimpleLikeCommentBox(element);
        });
        setTimeout(() => {
            $(
                ".simple-comment-box .list-comment > .item-comment-box:not(.have-child)"
            ).each(function () {
                var _this = $(this);
                var nextElement = _this.next(
                    ".item-comment-box:not(.have-child)"
                );
                if (nextElement.length > 0) {
                    _this.addClass("have-next");
                }
            });
        }, 0);
    },
    loadCommnent(target) {
        var simpleCommentBox = $(".simple-comment-box");
        var commentBoxIdx = simpleCommentBox.attr("idx");
        var commentBoxIdentifier = simpleCommentBox.attr("identifier");
        var targetBox = simpleCommentBox.find(`[cmt-target=${target}]`);
        targetBox.append(`<div class="loader-dot">
            <div class="loader-item"></div>
            <div class="loader-item"></div>
            <div class="loader-item"></div>
            <div class="loader-item"></div>
        </div>`);
        var commentActive = null;
        if (basic_COMMENT.userActionCommit) {
            const params = new Proxy(
                new URLSearchParams(window.location.search),
                {
                    get: (searchParams, prop) => searchParams.get(prop),
                }
            );
            commentActive = params.cmt;
        }
        $.ajax({
            url: "basiccomment/load-comment",
            type: "GET",
            data: {
                target: target,
                sort: $(".comment-fillter-sort").val(),
                commentBoxIdx: commentBoxIdx,
                commentBoxIdentifier: commentBoxIdentifier,
                commentActive: commentActive,
            },
            global: false,
        }).done(function (html) {
            targetBox.find(".loader-dot").remove();
            targetBox.append(html);
            paginationBox = targetBox.find(".pagination-comment-box");
            basic_COMMENT.initPaginationBox(paginationBox);
            basic_COMMENT.initBaseGui();
        });
    },
    initPaginationBox(paginationBox) {
        if (paginationBox.length > 0) {
            var nextUrl = paginationBox.find(".next-page");
            if (nextUrl.length > 0) {
                var htmlViewMore = `<a href="${nextUrl.attr(
                    "href"
                )}" class="btn-view-more-comment" title="Xem thêm bình luận">Xem thêm bình luận</a>`;
                paginationBox.find(".pagination-hidden-box").remove();
                paginationBox.prepend(htmlViewMore);
            } else {
                paginationBox.remove();
            }
        }
    },
    loadChildCommnent() {
        $(document).on("click", ".show-child-comment", function (e) {
            var target = $(this).attr("target");
            $(this).closest(".item-comment-box").addClass("open");
            basic_COMMENT.loadCommnent(target);
            $(this).remove();
        });
    },
    initBtnReplyComment() {
        $(document).on("click", ".btn-reply-comment", function (e) {
            var target = $(this).attr("target");
            var itemCommentBox = $(this).closest(".item-comment-box");
            if (!itemCommentBox.hasClass("open")) {
                itemCommentBox.find(".show-child-comment").click();
            }
            if ($(this).hasClass("no-login")) {
                alert("Vui lòng đăng nhập để tham gian bình luận.");
                return;
            }
            itemCommentBox
                .find("> .item-comment-content")
                .find(".loader-dot")
                .remove();
            itemCommentBox.find(
                "> .item-comment-content"
            ).append(`<div class="loader-dot">
                <div class="loader-item"></div>
                <div class="loader-item"></div>
                <div class="loader-item"></div>
                <div class="loader-item"></div>
            </div>`);
            $.ajax({
                url: "basiccomment/load-form-comment",
                type: "GET",
                data: {
                    target: target,
                },
                dataType: "json",
                global: false,
            }).done(function (json) {
                itemCommentBox
                    .find("> .item-comment-content")
                    .find(".loader-dot")
                    .remove();
                var simpleCommentBox = $(".simple-comment-box");

                var targetElement = simpleCommentBox.find(
                    `[item-cmt=${json.target}]`
                );
                var parentCommentBox =
                    targetElement.closest(".item-comment-box");
                parentCommentBox.removeClass("off-reply");
                parentCommentBox.removeClass("have-next");
                parentCommentBox.prev().removeClass("have-next");
                parentCommentBox.addClass("on-reply");
                parentCommentBox.addClass("have-child");
                targetElement.find("> .simple-form-comment").remove();
                targetElement.append(json.html);
                basic_COMMENT.initBaseGui();
            });
        });
    },
    initViewMoreComment() {
        $(document).on("click", ".btn-view-more-comment", function (e) {
            e.preventDefault();
            var _this = $(this);
            var commentBox = _this.closest(".list-comment");
            _this.closest(".pagination-comment-box").remove();
            commentBox.append(`<div class="loader-dot">
                <div class="loader-item"></div>
                <div class="loader-item"></div>
                <div class="loader-item"></div>
                <div class="loader-item"></div>
            </div>`);
            $.ajax({
                url: _this.attr("href"),
                type: "GET",
                global: false,
            }).done(function (html) {
                commentBox.find(".loader-dot").remove();
                commentBox.append(html);
                var paginationBox = commentBox.find(".pagination-comment-box");
                basic_COMMENT.initPaginationBox(paginationBox);
                basic_COMMENT.initBaseGui();
            });
        });
    },
    initReportComment() {
        $(document).on(
            "click",
            ".item-comment-support-action .icon",
            function () {
                var parentItem = $(this).closest(
                    ".item-comment-support-action"
                );
                parentItem.toggleClass("active");
                if (!parentItem.hasClass("inited")) {
                    $(window).click(function (e) {
                        if (
                            parentItem.has(e.target).length == 0 &&
                            !parentItem.is(e.target)
                        ) {
                            parentItem.removeClass("active");
                        }
                    });
                }
                parentItem.addClass("inited");
            }
        );
        $(document).on(
            "click",
            ".item-comment-support-action .report-comment-btn",
            function () {
                var itemComment = $(this).data("cmt");
                $("#modal-report-commnet input[name=comment]").val(itemComment);
                $("#modal-report-commnet").modal("show");
            }
        );
        $(document).on("submit", "#modal-report-commnet form", function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: $(this).serialize(),
            }).done(function (json) {
                BASE_GUI.showNotify(json.code, json.message);
                $("#modal-report-commnet").modal("hide");
            });
        });
    },
    initActiveComment() {
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        let commentActive = params.cmt;
        if (commentActive) {
            var simpleCommentBox = $(".simple-comment-box");
            var commentBoxIdx = simpleCommentBox.attr("idx");
            var commentBoxIdentifier = simpleCommentBox.attr("identifier");
            $.ajax({
                url: "basiccomment/load-comment-active",
                type: "GET",
                data: {
                    commentBoxIdx: commentBoxIdx,
                    commentBoxIdentifier: commentBoxIdentifier,
                    commentActive: commentActive,
                },
                global: false,
            }).done(function (html) {
                simpleCommentBox.find(".list-comment").prepend(html);
                basic_COMMENT.initBaseGui();
                var targetElement = $(`[item-cmt=${commentActive}]`);
                setTimeout(() => {
                    if (targetElement.length > 0) {
                        setTimeout(() => {
                            targetElement.addClass("active");
                        }, 1000);
                        window.scrollTo(0, targetElement.offset().top - 100);
                    }
                }, 100);
            });
        }
    },
};
$(document).ready(function () {
    basic_COMMENT.init();
});
