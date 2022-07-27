var MediaManager = {};
var counter = 0;
MediaManager.isShowLoading = false;
MediaManager.isUploading = false;
MediaManager.showLoading = function () {
    if (MediaManager.isShowLoading) return;
    MediaManager.isShowLoading = true;
    $(".loading").fadeIn(500);
};
MediaManager.hideLoading = function () {
    if (MediaManager.isUploading) return;
    MediaManager.isShowLoading = false;
    $(".loading").fadeOut(500);
};

MediaManager.deleteTrash = function () {
    var ids = $("input[name=listselected]").val();
    if (ids.length == 0) return;
       
    bootbox.confirm("Bạn muốn xóa các file đã chọn?", function (result) {
        if (result) {
            $.ajax({
                url: globalBaseUrl + "/media/deleteAll/0",
                type: "POST",
                data: { ids: ids },
            }).done(function (json) {
                if (json.code == 200) {
                    const arrayId = JSON.parse(ids);
                    arrayId.forEach(id => {
                        $(".media-content .row").isotope("remove", $("#file" + id)).isotope()
                    });
                }
            });
        }
    });
};
MediaManager.restoreAll = function () {
    var ids = $("input[name=listselected]").val();
    if (ids.length == 0) return;
    bootbox.confirm("Bạn muốn khôi phúc các file đã chọn?", function (result) {
        if (result) {
            $.ajax({
                url: globalBaseUrl + "/media/restore",
                type: "POST",
                data: { ids: ids },
            }).done(function (json) {
                if (json.code == 200) {
                    const arrayId = JSON.parse(ids);
                    arrayId.forEach(id => {
                        $(".media-content .row").isotope("remove", $("#file" + id)).isotope()
                    });
                }
            });
        }
    });
};
MediaManager.initDropzone = function () {
    $("div#media-manage").dropzone({
        params: globalobj,
        maxFiles: 20,
        url: globalBaseUrl + "/media/uploadFile",
        uploadMultiple: true,
        clickable: false,
        addedfile: function (file) {
            // console.log(file);
        },
        thumbnail: function (file, dataUrl) {
            // console.log(dataUrl);
        },
        sendingmultiple: function (x) {
            MediaManager.isUploading = true;
            MediaManager.showLoading();
        },
        queuecomplete: function (x) {
            MediaManager.isUploading = false;
            MediaManager.hideLoading();
        },
        uploadprogress: function (file, progress, bytesSent) {
            var item = $('p:contains("' + file.name + '")');
            if (item == undefined || item.length == 0) {
                $(".list-notify #mCSB_1_container").append(
                    '<div class="notify">' +
                        '<div class="notify-item" style="background:#fff">' +
                        '<div class="pull-left thumb">' +
                        "</div>" +
                        '<div class="pull-left info">' +
                        '<p class="name">' +
                        file.name +
                        "</p>" +
                        '<p class="progress"><span>' +
                        Math.round(progress * 100) / 100 +
                        "%</span></p>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                );
            }
            $('p:contains("' + file.name + '")')
                .next()
                .find("span")
                .css({ width: progress + "%" })
                .text(Math.round(progress * 100) / 100 + "%");
            if (progress >= 100) {
                $('p:contains("' + file.name + '")')
                    .parents(".notify")
                    .fadeOut(2000, function () {
                        $(this).remove();
                    });
            }
        },
        dragenter: function (event) {
            $(".dz-drag-hover .hover-upload").show();
            counter++;
        },
        dragleave: function (event) {
            counter--;
            if (counter == 0) {
                $(".dz-drag-hover .hover-upload").fadeOut(500);
            }
        },
        drop: function (event) {
            $(".dz-drag-hover .hover-upload").fadeOut(500);
            counter == 0;
        },
        successmultiple: function (files) {
            try {
                if (files.length > 0) {
                    var json = JSON.parse(files[0].xhr.response);
                    if (json != undefined) {
                        MediaManager.getLastedFileCreated(json);
                    }
                }
            } catch (e) {}
        },
    });
    $("#upload-modal .modal-body").dropzone({
        params: globalobj,
        url: globalBaseUrl + "/media/uploadFile",
        uploadMultiple: true,
        addedfile: function (file) {
            // console.log(file);
        },
        thumbnail: function (file, dataUrl) {
            // console.log(dataUrl);
        },
        sendingmultiple: function (x) {
            MediaManager.isUploading = true;
            MediaManager.showLoading();
        },
        queuecomplete: function (x) {
            MediaManager.isUploading = false;
            MediaManager.hideLoading();
        },
        uploadprogress: function (file, progress, bytesSent) {
            var item = $('p:contains("' + file.name + '")');
            if (item == undefined || item.length == 0) {
                $(".list-notify #mCSB_1_container").append(
                    '<div class="notify">' +
                        '<div class="notify-item" style="background:#fff">' +
                        '<div class="pull-left thumb">' +
                        "</div>" +
                        '<div class="pull-left info">' +
                        '<p class="name">' +
                        file.name +
                        "</p>" +
                        '<p class="progress"><span>' +
                        Math.round(progress * 100) / 100 +
                        "%</span></p>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                );
            }
            $('p:contains("' + file.name + '")')
                .next()
                .find("span")
                .css({ width: progress + "%" })
                .text(Math.round(progress * 100) / 100 + "%");
            if (progress >= 100) {
                $('p:contains("' + file.name + '")')
                    .parents(".notify")
                    .fadeOut(2000, function () {
                        $(this).remove();
                    });
            }
        },
        dragenter: function (event) {
            $(".dz-drag-hover .hover-upload").show();
            counter++;
        },
        dragleave: function (event) {
            counter--;
            if (counter == 0) {
                $(".dz-drag-hover .hover-upload").fadeOut(500);
            }
        },
        drop: function (event) {
            $(".dz-drag-hover .hover-upload").fadeOut(500);
            counter == 0;
        },
        successmultiple: function (files) {
            try {
                if (files.length > 0) {
                    var json = JSON.parse(files[0].xhr.response);
                    if (json != undefined) {
                        MediaManager.getLastedFileCreated(json);
                    }
                }
            } catch (e) {}
        },
    });
    $("#upload-modal-wm .modal-body").dropzone({
        params: globalobj,
        url: globalBaseUrl + "/media/uploadFileWm",
        uploadMultiple: true,
        addedfile: function (file) {
            // console.log(file);
        },
        thumbnail: function (file, dataUrl) {
            // console.log(dataUrl);
        },
        uploadprogress: function (file, progress, bytesSent) {
            var item = $('p:contains("' + file.name + '")');
            if (item == undefined || item.length == 0) {
                $(".list-notify #mCSB_1_container").append(
                    '<div class="notify">' +
                        '<div class="notify-item" style="background:#fff">' +
                        '<div class="pull-left thumb">' +
                        "</div>" +
                        '<div class="pull-left info">' +
                        '<p class="name">' +
                        file.name +
                        "</p>" +
                        '<p class="progress"><span>' +
                        Math.round(progress * 100) / 100 +
                        "%</span></p>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                );
            }
            $('p:contains("' + file.name + '")')
                .next()
                .find("span")
                .css({ width: progress + "%" })
                .text(Math.round(progress * 100) / 100 + "%");
            if (progress >= 100) {
                $('p:contains("' + file.name + '")')
                    .parents(".notify")
                    .fadeOut(2000, function () {
                        $(this).remove();
                    });
            }
        },
        dragenter: function (event) {
            $(".dz-drag-hover .hover-upload").show();
            counter++;
        },
        dragleave: function (event) {
            counter--;
            if (counter == 0) {
                $(".dz-drag-hover .hover-upload").fadeOut(500);
            }
        },
        drop: function (event) {
            $(".dz-drag-hover .hover-upload").fadeOut(500);
            counter == 0;
        },
        successmultiple: function (files) {
            try {
                if (files.length > 0) {
                    var json = JSON.parse(files[0].xhr.response);
                    if (json != undefined) {
                        MediaManager.getLastedFileCreated(json);
                    }
                }
            } catch (e) {}
        },
    });
};
MediaManager.init = function () {
    MediaManager.initDropzone();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
};
MediaManager.getLastedFolderCreated = function ($id) {
    window.location.reload();
    return;
    $.ajax({
        url: globalBaseUrl + "/media/getInfoLasted",
        type: "POST",
        data: { id: $id },
    }).done(function (data) {
        var $newItems = $(data);
        $(".media-content .row")
            .prepend($newItems)
            .isotope("reloadItems")
            .isotope();
    });
};
MediaManager.getLastedFileCreated = function ($id) {
    $.ajax({
        url: globalBaseUrl + "/media/getInfoFileLasted",
        type: "POST",
        data: { id: $id },
    }).done(function (data) {
        var $newItems = $(data);
        $(".media-content .row")
            .prepend($newItems)
            .isotope("reloadItems")
            .isotope();
    });
};
MediaManager.submitNewFolder = function (_this) {
    $("#folder-modal").modal("hide");
    $.ajax({
        url: $(_this).attr("action"),
        type: "POST",
        data: $(_this).serialize(),
    })
        .done(function (json) {
            if (json.code == SUCCESS) {
                if (parseInt(json.message) > 0) {
                    MediaManager.getLastedFolderCreated(json.message);
                }
            }
        })
        .fail(function () {});
    return false;
};
MediaManager.deleteFolder = function (_this) {
    bootbox.confirm("Bạn muốn xóa folder đã chọn?", function (result) {
        if (result) {
            var id = $(_this).attr("dt-id");
            if (id != undefined) {
                $.ajax({
                    url: globalBaseUrl + "/media/deleteFolder",
                    type: "POST",
                    data: { id: id },
                }).done(function (json) {
                    if (json.code == SUCCESS) {
                        $(".media-content .row")
                            .isotope("remove", $("#folder" + json.message))
                            .isotope();
                    }
                });
            }
        }
    });
};
MediaManager.deleteFolderFull = function (_this) {
    bootbox.confirm("Bạn muốn xóa folder đã chọn?", function (result) {
        if (result) {
            var id = $(_this).attr("dt-id");
            if (id != undefined) {
                $.ajax({
                    url: globalBaseUrl + "/media/deleteFolder/0",
                    type: "POST",
                    data: { id: id },
                }).done(function (json) {
                    window.location.reload();
                });
            }
        }
    });
};
MediaManager.deleteFile = function (_this) {
    bootbox.confirm("Bạn muốn xóa file đã chọn?", function (result) {
        if (result) {
            var id = $(_this).attr("dt-id");
            if (id != undefined) {
                $.ajax({
                    url: globalBaseUrl + "/media/deleteFile",
                    type: "POST",
                    data: { id: id },
                }).done(function (json) {
                    if (json.code == SUCCESS) {
                        $(".media-content .row")
                            .isotope("remove", $("#file" + json.message))
                            .isotope();
                    }
                });
            }
        }
    });
};
MediaManager.deleteFileFull = function (_this) {
    bootbox.confirm("Bạn muốn xóa file đã chọn?", function (result) {
        if (result) {
            var id = $(_this).attr("dt-id");
            if (id != undefined) {
                $.ajax({
                    url: globalBaseUrl + "/media/deleteFile/0",
                    type: "POST",
                    data: { id: id },
                }).done(function (json) {
                    if (json.code == SUCCESS) {
                        $(".media-content .row")
                            .isotope("remove", $("#file" + json.message))
                            .isotope();
                    }
                });
            }
        }
    });
};
MediaManager.deleteMultiFile = function () {
    bootbox.confirm("Bạn muốn xóa tất cả các file đã chọn?", function (result) {
        if (result) {
            var ids = $("input[name=listselected]").val();
            $.ajax({
                url: globalBaseUrl + "/media/deleteAll",
                type: "POST",
                data: { ids: ids },
            }).done(function (json) {
                if (json.code == 200) {
                    const arrayId = JSON.parse(ids);
                    arrayId.forEach(id => {
                        $(".media-content .row").isotope("remove", $("#file" + id)).isotope()
                    });
                }
            });
        }
    });
};
MediaManager.getListFolder = function () {
    var s = $("#list-folder-modal");
    if (s.length > 0) {
        s.remove();
    }
    $.ajax({
        url: globalBaseUrl + "/media/listFolder",
        type: "POST",
        data: { param1: "value1" },
    }).done(function ($data) {
        $("body").append($data);
        $("#list-folder-modal").modal();
    });
};
MediaManager.getListFolderMove = function () {
    var s = $("#list-folder-modal");
    if (s.length > 0) {
        s.remove();
    }
    $.ajax({
        url: globalBaseUrl + "/media/listFolderMove",
        type: "POST",
        data: { param1: "value1" },
    }).done(function ($data) {
        $("body").append($data);
        $("#list-folder-modal").modal();
    });
};
MediaManager.copyFile = function (active) {
    if (globalObjectFile != undefined && active != undefined) {
        $.ajax({
            url: globalBaseUrl + "/media/copyFile",
            type: "POST",
            data: {
                id: globalObjectFile.id,
                idfolder: $(active).attr("dt-id"),
            },
        }).done(function (json) {
            bootbox.alert(json.message);
        });
    }
    return false;
};
MediaManager.moveFile = function (active) {
    if (globalObjectFile != undefined && active != undefined) {
        $.ajax({
            url: globalBaseUrl + "/media/moveFile",
            type: "POST",
            data: {
                id: globalObjectFile.id,
                idfolder: $(active).attr("dt-id"),
            },
        }).done(function (json) {
            if (json.code == SUCCESS) {
                $(".media-content .row")
                    .isotope("remove", $("#file" + json.message))
                    .isotope();
            }
        });
    }
    return false;
};
MediaManager.getDetailFile = function (id) {
    $.ajax({
        url: globalBaseUrl + "/media/getDetailFile",
        type: "POST",
        data: { id: id },
    }).done(function (data) {
        try {
            $("#info-modal .modal-body").html(data);
            $("#info-modal").modal("show");
        } catch (e) {}
    });
};
MediaManager.restore = function (id) {
    $.ajax({
        url: globalBaseUrl + "/media/restore",
        type: "POST",
        data: { id: id },
    }).done(function (data) {
        window.location.reload();
    });
};
MediaManager.saveDetailFile = function (_this) {
    $.ajax({
        url: globalBaseUrl + "/media/saveDetailFile",
        type: "POST",
        data: $(_this).serialize(),
    }).done(function (data) {
        $("#info-modal").modal("hide");
        window.location.reload();
    });
};
MediaManager.writeMetadata = function (_this) {
    $.ajax({
        url: globalBaseUrl + "/Media/writeMetadata",
        type: "POST",
        data: $(_this).serialize(),
    }).done(function (data) {
        $("#advance-modal").modal("hide");
        window.location.reload();
    });
};
MediaManager.getMetadataFile = function (id) {
    $.ajax({
        url: globalBaseUrl + "/Media/getMedatata",
        type: "POST",
        data: { id: id },
    }).done(function (data) {
        try {
            $("#advance-modal .modal-body").html(data);
            $("#advance-modal").modal("show");
        } catch (e) {}
    });
};
MediaManager.getParameterByName = function (name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null
        ? ""
        : decodeURIComponent(results[1].replace(/\+/g, " "));
};
MediaManager.applyChooseImage = function () {
    var istiny = MediaManager.getParameterByName("istiny");
    var arrFiles = $(".fileSelected");
    if (istiny == 1) {
        var html = "";
        for (var i = 0; i < arrFiles.length; i++) {
            var item = $(arrFiles[i]);
            var _parent = item.parent().parent().parent();
            var datafile = _parent.attr("data-file");
            var objfile = JSON.parse(datafile);
            debugger;
            html +=
                "<p style='text-align:center'><img title='" +
                objfile.title +
                "' alt='" +
                objfile.alt +
                "' class='img-responsive' src='" +
                objfile.path +
                objfile.file_name +
                "'/></p>" +
                (objfile.caption == null || objfile.caption == "null"
                    ? ""
                    : "<p style='text-align:center'><span class='caption'>" +
                      objfile.caption +
                      "</span></p>");
        }
        top.tinymce.activeEditor.windowManager.getParams().oninsert(html);
    } else if (istiny == 2) {
        if (arrFiles.length > 0) {
            var item = $(arrFiles[0]);
            var _parent = item.parent().parent().parent();
            var datafile = _parent.attr("data-file");
            var objfile = JSON.parse(datafile);
            top.tinymce.activeEditor.windowManager
                .getParams()
                .setUrl(objfile.path + objfile.file_name);
        }
    } else {
        var callbackname = MediaManager.getParameterByName("callback");
        var fnc = null;
        if (callbackname == "") {
            fnc = parent["hungvtApplyCallbackFile"];
        } else {
            var tmps = callbackname.split(".");
            if (tmps.length == 2) {
                fnc = parent[tmps[0]][tmps[1]];
            } else {
                fnc = parent["hungvtApplyCallbackFile"];
            }
        }
        var arrItem = [];
        for (var i = 0; i < arrFiles.length; i++) {
            var item = $(arrFiles[i]);
            var _parent = item.parent().parent().parent();
            var datafile = _parent.attr("data-file");
            var objfile = JSON.parse(datafile);
            arrItem.push(objfile);
        }
        if (typeof fnc == "undefined") {
            var event = new CustomEvent("eventImages", { detail: arrItem });
            window.parent.document.dispatchEvent(event);
            return false;
        }
        fnc(arrItem, istiny);
        if (typeof parent.closeIFrame === "function") {
            parent.closeIFrame();
        } else {
            parent.close_window();
        }

        /* var arrItem = [];
	    for (var i = 0; i < arrFiles.length; i++) {
	        var item = $(arrFiles[i]);
	        var _parent = item.parent().parent().parent();
	        var datafile =  _parent.attr('data-file');
	        var objfile = JSON.parse(datafile);
	        arrItem.push(objfile);
	    }
	    parent.hungvtApplyCallbackFile(arrItem,istiny);
	    parent.close_window();*/
    }
};
$(function () {
    MediaManager.init();
});