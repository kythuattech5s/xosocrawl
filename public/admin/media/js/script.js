jQuery(function ($) {
    $(document).on("click", '.mdi-img[rel="mdi"]', function (event) {
        event.preventDefault();
        $(this)
            .closest(".media-item")
            .find('input[type="checkbox"]')
            .trigger("click");
        if (
            !$(this).hasClass("fileSelected") ||
            $(this).closest(".media-item").find('input[type="checkbox"]')[0]
                .checked
        ) {
            $(this).addClass("fileSelected");
        } else {
            $(this).removeClass("fileSelected");
        }
    });
    $(document).on("change", ".media-item .mdi-check input", function (event) {
        event.preventDefault();
        const image = this.closest(".media-item").querySelector(".mdi-img");
        if (this.checked) {
            image.classList.add("fileSelected");
        } else if (image.classList.contains("fileSelected")) {
            image.classList.remove("fileSelected");
        }
    });
    $(document).on("dblclick", '.mdi-img[rel="mdi"]', function (event) {
        event.preventDefault();
        if (!$(this).hasClass("fileSelected")) {
            $(this).addClass("fileSelected");
        } else {
            $(this).removeClass("fileSelected");
        }
        $(this)
            .parents(".media-item")
            .children(".mdi-check")
            .find('input[type="checkbox"]')
            .trigger("click");
        MediaManager.applyChooseImage();
    });
    $("a.preview").fancybox({
        speedIn: 600,
        speedOut: 200,
        overlayShow: false,
        autoScale: true,
    });
    $(".media-item").on("click", ".selectfile", function (event) {
        var inputs = $("input.selectfile:checked");
        var objs = [];
        for (var i = 0; i < inputs.length; i++) {
            var item = $(inputs[i]);
            objs.push(item.val());
        }
        $("input[name=listselected]").val(JSON.stringify(objs));
    });
    $(".media-item").on("click", ".mdi-btn .name-edit", function (event) {
        event.preventDefault();
        var item = $(this).parents(".media-item");
        var title = item.find(".mdi-title");
        var id = $(this).attr("dt-id");
        title.append(
            '<input type="text" dt-id="' +
                id +
                '" class="edit-ct" rows="3" value="' +
                title.text() +
                '" onfocus="this.select()">'
        );
        title.children(".edit-ct").focus();
    });
    $(".media-item").on("blur", ".edit-ct", function () {
        if ($(this).val() != "" && $(this).val().trim() != "") {
            $(this).parent(".mdi-title").text($(this).val());
        }
        $(this).remove();
    });
    $(".media-item").on("keyup", ".edit-ct", function (e) {
        if (e.keyCode == 13) {
            if ($(this).val().trim() == "") return;
            $.ajax({
                url: globalBaseUrl + "/media/rename",
                type: "POST",
                data: { id: $(this).attr("dt-id"), newname: $(this).val() },
            }).done(function (data) {
                try {
                    var json = JSON.parse(data);
                    if (json.code == SUCCESS) {
                    }
                } catch (e) {}
            });
            $(this).remove();
        }
    });
    $(document).bind("contextmenu", function (event) {
        event.preventDefault();
        var ele = document.elementFromPoint(event.clientX, event.clientY);
        ele = $(ele).closest(".fileitem");
        var datafile = $(ele).attr("data-file");
        if (datafile == undefined) return;
        try {
            var objfile = JSON.parse(datafile);
            var extra = JSON.parse(objfile.extra);
            globalObjectFile = objfile;
            if (!objfile.hasOwnProperty("is_file") || objfile.is_file == 0) {
                return;
            }
            var str = "";
            if (extimgs.indexOf(extra.extension) != -1) {
                str +=
                    "<li data-action='advance'><i class='fa fa-file-archive-o'></i>Metadata ảnh</li>";
                str +=
                    "<li data-action='editimage'><i class='fa fa-edit'></i>Chỉnh sửa ảnh</li>";
            }

            str +=
                "<li data-action='showpath'><i class='fa fa-link'></i>Hiện đường dẫn file</li>";
            str +=
                "<li data-action='duplicate'><i class='fa fa-paperclip'></i>Nhân đôi file</li>";
            str += "<li data-action='copy'><i class='fa fa-copy'></i>Copy</li>";
            str += "<li data-action='cut'><i class='fa fa-cut'></i>Cut</li>";
            str +=
                "<li style='text-align:center;background:#ddd'><p style='text-align:center;display:inline'>THÔNG TIN FILE</p></li>";
            str += "<li><i class='fa fa-tag'></i>" + extra.extension + "</li>";
            if (
                extra.hasOwnProperty("width") &&
                extra.hasOwnProperty("height")
            ) {
                str +=
                    "<li><i class='fa fa-desktop'></i>" +
                    extra.width +
                    "x" +
                    extra.height +
                    "</li>";
            }
            str += "<li><i class='fa fa-fire'></i>" + extra.size + "</li>";
            var t = new Date(1970, 0, 1);
            t.setSeconds(extra.date);
            str +=
                "<li><i class='fa fa-calendar'></i>" +
                (t.getDate() < 10 ? "0" + t.getDate() : t.getDate()) +
                "/" +
                (t.getMonth() < 9
                    ? "0" + (t.getMonth() + 1)
                    : t.getMonth() + 1) +
                "/" +
                t.getFullYear() +
                " " +
                (t.getHours() < 10 ? "0" + t.getHours() : t.getHours()) +
                ":" +
                (t.getMinutes() < 10 ? "0" + t.getMinutes() : t.getMinutes()) +
                ":" +
                (t.getSeconds() < 10 ? "0" + t.getSeconds() : t.getSeconds()) +
                "</li>";

            $("ul.custom-menu").html(str);
        } catch (ex) {}
        $(".custom-menu")
            .show()
            .css({
                top: event.pageY + "px",
                left: event.pageX + "px",
            });
    });
    $(".custom-menu").on("click", ">li", function (event) {
        $(this).parent().hide();
        var extra = JSON.parse(globalObjectFile.extra);
        var action = $(this).attr("data-action");
        switch (action) {
            case "editimage":
                $("#aviary-image").attr("src", _baseurl + extra.path);
                launchEditor("aviary-image", $("#aviary-image").attr("src"));
                break;
            case "showpath":
                bootbox.dialog({
                    title: "Đường dẫn tệp tin",
                    message:
                        "<input style='width:100%' value='" +
                        globalObjectFile.path +
                        globalObjectFile.file_name +
                        "'/>",
                });
                break;
            case "duplicate":
                duplicateFile(globalObjectFile.id);
                break;
            case "copy":
                MediaManager.getListFolder();
                break;
            case "cut":
                MediaManager.getListFolderMove();
                break;
            case "advance":
                MediaManager.getMetadataFile(globalObjectFile.id);
                break;
        }
    });
    function duplicateFile(id) {
        $.ajax({
            url: globalBaseUrl + "/media/duplicateFile",
            type: "POST",
            data: { id: id },
        })
            .done(function (json) {
                if (json.code == SUCCESS) {
                    MediaManager.getLastedFileCreated(json.message);
                }
            })
            .fail(function () {
                console.log("error");
            })
            .always(function () {
                console.log("complete");
            });
    }
    $(document).click(function (event) {
        if (!$(event.target).closest(".custom-menu").length) {
            if ($(".custom-menu").is(":visible")) {
                $(".custom-menu").hide();
            }
        }
    });
    var $grid = $(".media-content .row").isotope({
        itemSelector: ".media-it",
        layoutMode: "fitRows",
        getSortData: {
            titleAsc: ".mdi-title",
            titleDesc: ".mdi-title",
            sizeAsc: ".mdi-size",
            sizeDesc: ".mdi-size",
            dateAsc: function (e) {
                date = 0;
                if ($(e).find(".mdi-date").length > 0) {
                    date = Date.parse($(e).find(".mdi-date").text());
                }
                return date;
            },
            dateDesc: function (e) {
                date = 0;
                if ($(e).find(".mdi-date").length > 0) {
                    date = Date.parse($(e).find(".mdi-date").text());
                }
                return date;
            },
        },
        sortAscending: {
            titleAsc: true,
            titleDesc: false,
            sizeAsc: true,
            sizeDesc: false,
            dateAsc: true,
            dateDesc: false,
        },
    });

    var qsRegex;
    var $input = $(".media-bar-s > input").keyup(
        debounce(function () {
            qsRegex = new RegExp($input.val(), "gi");
            $grid.isotope({
                filter: function () {
                    return qsRegex
                        ? $(this).find(".mdi-title").text().match(qsRegex)
                        : true;
                },
            });
        }, 100)
    );
    function debounce(fn, threshold) {
        var timeout;
        return function debounced() {
            if (timeout) {
                clearTimeout(timeout);
            }
            function delayed() {
                fn();
                timeout = null;
            }
            timeout = setTimeout(delayed, threshold || 100);
        };
    }
    var filterFns = "";
    $(".menu-filter").on("click", "button", function () {
        var filterValue = $(this).attr("data-filter");
        filterValue = filterFns[filterValue] || filterValue;
        $grid.isotope({
            filter: filterValue,
        });
        $(this).parents(".menu-filter").find("button").removeClass("active");
        $(this).addClass("active");
    });
    $(".media-sort li").on("click", "a", function (event) {
        event.preventDefault();
        // var sortValue = $(this).attr('data-sort');
        // $grid.isotope({
        // 	sortBy: sortValue ,
        // });
        $(this).parents(".media-sort").find("li>a").removeClass("active");
        $(this).addClass("active");
        $(".media-content>.row").html("");
        ENLESS_PAGE.loadpage(0);
    });
    $(".media-bar-b").on("click", "#refresh", function (event) {
        event.preventDefault();
        // $grid.isotope({
        // 	filter: '*',
        // 			sortBy : 'original-order',
        // 		});
        $(".menu-filter button").removeClass("active");
        $(".media-sort li>a").removeClass("active");
        $(".media-content>.row").html("");
        ENLESS_PAGE.loadpage(0);
    });
    $(document).ajaxStart(function () {
        $(".loading").fadeIn(500);
    });
    $(document).ajaxComplete(function (event, xhr, settings) {
        $(".loading").fadeOut(500);
    });

    $(".list-notify").mCustomScrollbar({
        theme: "dark-3",
    });
    $("#view").click(function () {
        if ($(this).attr("data-view") == "list") {
            $(".media-item").parent().addClass("media-item-l");
            $(this).attr("data-view", "box");
            $grid.isotope();
        } else {
            $(".media-item").parent().removeClass("media-item-l");
            $(this).attr("data-view", "list");
            $grid.isotope();
        }
    });
    function addNotifyUpload(file) {}
    ENLESS_PAGE.init();
    $("img.lazy").lazyload({
        event: "sporty",
    });
});
var ENLESS_PAGE = {};
ENLESS_PAGE.loading = false;
ENLESS_PAGE.track_page = 1;
ENLESS_PAGE.finish = false;
ENLESS_PAGE.loadpage = function (index) {
    if (ENLESS_PAGE.loading == false && !ENLESS_PAGE.finish) {
        ENLESS_PAGE.loading = true; //set loading flag on
        $(".loading-info").show(); //show loading animation
        var baseurl =
            window.location.origin + window.location.pathname + location.search;

        var sort = $(".media-sort a.active");
        if (sort.length > 0) {
            if (baseurl.indexOf("?") > -1) {
                baseurl = baseurl + "&ord=" + sort.data("sort");
            } else {
                baseurl = baseurl + "?ord=" + sort.data("sort");
            }
        }
        $.get(
            ENLESS_PAGE.updateQueryStringParameter(baseurl, "page", index),
            function (data) {
                ENLESS_PAGE.loading = false;
                if (data.trim().length == 0) {
                    ENLESS_PAGE.finish = true;
                    $(".loading-info").html("Đã tải hết!");
                    return;
                }
                $(".loading-info").hide(); //hide loading animation once data is received
                $(".media-content>.row")
                    .append(data)
                    .isotope("reloadItems")
                    .isotope();
            }
        );
    }
};
ENLESS_PAGE.updateQueryStringParameter = function (uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf("?") !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, "$1" + key + "=" + value + "$2");
    } else {
        return uri + separator + key + "=" + value;
    }
};
ENLESS_PAGE.init = function () {
    $(window).scroll(function () {
        if (
            $(window).scrollTop() + $(window).height() >=
            $(document).height() - 20
        ) {
            ENLESS_PAGE.track_page++;
            ENLESS_PAGE.loadpage(ENLESS_PAGE.track_page);
        }
    });
};
/*var featherEditor = new Aviary.Feather({
    apiKey: '2444282ef4344e3dacdedc7a78f8877d',
    theme:'light',
    maxSize:'2000',
    aviary_language:'vi',
    tools:'all',
    onSave: function(imageID, newURL) {
        var img = document.getElementById(imageID);
        img.src = newURL;
         featherEditor.close();
        $.ajax({
          url: globalBaseUrl+"/media/downloadImage",
          type: 'POST',
          data: {file: newURL,name:globalObjectFile.name,id:globalObjectFile.id},
        })
        .done(function(e) {
          window.location.reload();
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        
    }
});*/
function launchEditor(id, src, imageEditName) {
    featherEditor.launch({
        image: id,
        url: src,
    });
    return false;
}
