/**
 * File: base.js
 * Description: This file contains any code for core JavaScript notification and AJAX.
 * Author: Amir Zuhdi Wibowo
 * Created: 2024-05-09
 * Last Modified: 2024-05-09
 */

/**
 * Displays a SweetAlert2 notification with the provided options.
 *
 * @param {string} title - The title of the notification.
 * @param {string} text - The text content of the notification.
 * @param {string} icon - The icon type to be displayed (e.g., 'success', 'error', 'warning', 'info').
 * @param {number} timer - The duration in milliseconds after which the notification should automatically close. Pass 0 to disable the timer.
 */
function swalNotify(title, text, icon, timer) {
    Swal.fire({
        title,
        text,
        icon,
        timer,
    });
}

/**
 * Converts an array to an encoded URL string.
 * @param {Object} array - The input array.
 * @returns {string} The encoded URL string.
 */
function encodeArrayToURL(array) {
    return Object.entries(array)
        .map(
            ([key, value]) =>
                `${encodeURIComponent(key)}=${encodeURIComponent(value)}`
        )
        .join("&");
}

/**
 * Generate URL with query parameters
 * @param {string} baseUrl - The base URL without query parameters.
 * @param {Object} params - The query parameters as key-value pairs.
 * @returns {string} - The complete URL with encoded query parameters.
 */
function generateAjaxUrl(baseUrl, params) {
    const queryString = Object.keys(params)
        .map(
            (key) =>
                `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`
        )
        .join("&");
    return `${baseUrl}?${queryString}`;
}

/**
 * Initialize DataTable with AJAX.
 *
 * @param {string} tableId - The ID of the table to initialize DataTable.
 * @param {string} url - The URL endpoint to fetch data from.
 * @param {Array} columns - The configuration of table columns.
 */
function initializeDataTableWithAjax(tableId, url, columns, method = "GET") {
    $(document).ready(function () {
        $(`#${tableId}`).DataTable({
            columnDefs: [{ targets: "no-sort", orderable: false }],
            dom:
                "<'dt--top-section px-3 pt-3 pb-2'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive w-100'tr>" +
                "<'dt--bottom-section px-3 pt-3 pb-2 d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {
                url,
                method,
            },
            fixedHeader: {
                header: true,
                footer: true,
            },

            language: {
                lengthMenu: "Menampilkan _MENU_ data per halaman",
                zeroRecords: "Maaf, data tidak tersedia!",
                info: "Menampilkan _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data yang tersedia.",
                infoFiltered: "(Disaring dari _MAX_ jumlah data)",
            },
            columns: columns,
        });
    });
}

/**
 * Checks if the input is booleanish.
 *
 * @param {any} input The input value to be checked.
 * @returns {boolean} True if the input is booleanish, false otherwise.
 */
const isBooleanish = (input) =>
    typeof input === "boolean" || /^(true|false)$/i.test(input);

/**
 * Converts a string to a boolean value.
 *
 * @param {string} input The input string to be converted.
 * @returns {boolean} The boolean value derived from the input string.
 */
const booleanish = (input) =>
    /^(true|false)$/i.test(input) ? input.toLowerCase() === "true" : false;

/**
 * Converts a file size from bytes to a human-readable format.
 *
 * @param {number} bytes - The file size in bytes.
 * @returns {string} The human-readable file size.
 */
function humanReadableFileSize(bytes) {
    const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
    if (bytes === 0) return "0 Byte";
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
}

/**
 * Initializes the file upload functionality.
 * @param {string} targetElement - The selector of the target element.
 */
function initFormUpload(targetElement) {
    const fileInput = $(targetElement).find("input[type=file]");
    const fileList = $(targetElement).find(".file-list");
    const acceptAttribute = fileInput.attr("accept");
    const maxFileSize = parseInt(fileInput.data("max-filesize")) || null;

    // Function to remove a file from the list
    function removeFile(fileName) {
        const input = fileInput[0];
        const files = input.files;
        const remainingFiles = Array.from(files).filter(
            (file) => file.name !== fileName
        );

        const newFileList = new DataTransfer();
        remainingFiles.forEach((file) => newFileList.items.add(file));

        input.files = newFileList.files;
        fileList.find(`[data-file-name="${fileName}"]`).remove();

        hideFileListIfEmpty(remainingFiles);
    }

    // Function to hide file list if empty
    function hideFileListIfEmpty(files) {
        if (files.length === 0) {
            fileList.addClass("d-none");
        }
    }

    // Function to validate file type based on accept attribute
    function validateFileType(file) {
        if (!acceptAttribute) {
            return true; // No accept attribute specified
        }
        const acceptedTypes = acceptAttribute.split(",");
        return acceptedTypes.some((type) => type.trim() === file.type);
    }

    // Function to validate file size based on max-filesize attribute
    function validateFileSize(file) {
        if (!maxFileSize) {
            return true; // No max-filesize attribute specified
        }
        return file.size <= maxFileSize;
    }

    // Event listener for file removal
    fileList.on("click", ".file-remove", function () {
        const fileName = $(this).closest("li").attr("data-file-name");
        removeFile(fileName);
    });

    // Event listener for file reset
    $(targetElement)
        .find(".file-upload-label")
        .on("click", ".file-reset", function () {
            fileInput.val("");
            fileList.empty().addClass("d-none");
        });

    // Event listener for file input change
    fileInput.on("change", function () {
        fileList.empty();
        const files = Array.from(fileInput.get(0).files);
        fileList.removeClass("d-none").addClass("pt-3 mb-0");
        hideFileListIfEmpty(files);
        files.forEach((file) => {
            if (!validateFileType(file)) {
                toastrToast(
                    "error",
                    "Kesalahan!",
                    `Maaf, unggah sesuai dengan tipe berkasnya, yakni: ${acceptAttribute}`
                );
                fileList.removeClass("pt-3 mb-0").addClass("d-none");
                return;
            }
            if (!validateFileSize(file)) {
                toastrToast(
                    "error",
                    "Kesalahan!",
                    `Berkas yang anda unggah melebihi ketentuan, yakni ${humanReadableFileSize(
                        maxFileSize
                    )}.`
                );
                fileList.removeClass("pt-3 mb-0").addClass("d-none");
                return;
            }
            const listItem = $(
                `<li class="list-group-item d-flex px-0 gap-2 justify-content-between"></li>`
            );
            listItem
                .html(
                    `
            <div class="d-flex gap-1 flex-column w-75">
                <div class="fw-bolder text-truncate">${file.name}</div>
                <div>${humanReadableFileSize(file.size)}</div>
            </div>
                <button class="file-remove btn btn-danger" type="button" aria-label="Hapus berkas">
                    <i class="ti ti-trash"></i>
                </button>
            `
                )
                .attr("data-file-name", file.name);
            fileList.append(listItem);
        });
    });

    // Event listener for drag and drop
    $(targetElement).on("dragover", function (e) {
        e.preventDefault();
        $(this).find("label").addClass("active");
    });

    $(targetElement).on("dragleave", function () {
        $(this).find("label").removeClass("active");
    });

    $(targetElement).on("drop", function (e) {
        e.preventDefault();
        $(this).find("label").removeClass("active");
        const files = e.originalEvent.dataTransfer.files;
        fileInput.prop("files", files);
        fileInput.trigger("change");
    });
}

/**
 * Displays a SweetAlert2 toast notification with the provided options.
 *
 * @param {string} icon - The icon type to be displayed (e.g., 'success', 'error', 'warning', 'info').
 * @param {string} title - The title of the toast notification.
 * @param {string} text - The text content of the toast notification.
 * @param {string} position - The position of the toast notification (e.g., 'top-start', 'top-end', 'bottom-start', 'bottom-end').
 */
function swalToast(icon, title, text, position = "top-end") {
    const swalToast = Swal.mixin({
        toast: true,
        position,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });
    swalToast.fire({
        icon,
        title,
        text,
    });
}

/**
 * Displays a toastr.js toast notification with the provided options.
 *
 * @param {string} type - The type of the toast notification (e.g., 'success', 'error', 'warning', 'info').
 * @param {string} title - The title of the toast notification.
 * @param {string} message - The message content of the toast notification.
 * @param {string} position - The position of the toast notification (e.g., 'toast-top-left', 'toast-top-right', 'toast-bottom-left', 'toast-bottom-right').
 */
function toastrToast(type, title, message, position = "toast-top-right") {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: position,
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "3000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    toastr[type](message, title);
}

/**
 * Sweetalert with mixin bootstrap 5.
 */
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn-lg btn btn-success",
        cancelButton: "btn-lg btn btn-danger",
        actions:
            "gap-3 flex-column-reverse flex-lg-row align-items-stretch align-items-lg-center w-100 px-3 px-md-0 justify-content-stretch justify-content-lg-center d-flex",
    },
    buttonsStyling: false,
});

/**
 * Displays a confirmation modal dialog with a text message and executes form submission when confirmed.
 *
 * @param {string} text - The text message to display in the confirmation dialog.
 * @param {string} formTarget - The target form selector for submission.
 * @param {Object} options - Optional configuration options for the confirmation dialog.
 */
function runModalConfirmWithSubmit(text, formTarget, options) {
    swalWithBootstrapButtons
        .fire({
            title: "Konfirmasi",
            text: text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            reverseButtons: true,
            ...options,
        })
        .then(({ isConfirmed }) => {
            if (isConfirmed) $(formTarget).submit();
        });
}

/**
 * Submit targetted form
 *
 * @param {string} formTarget
 * @returns void
 */
function submitForm(formTarget) {
    $(formTarget).submit();
}

/**
 * Resets the error state and disables buttons and inputs.
 */
const resetError = (element) => {
    $("button,input,textarea").attr("disabled", true);
    element.find(".error-wrapper").empty();
    element.find("input,textarea").removeClass("is-invalid");
};

/**
 * Enables all inputs.
 */
const enableInputs = () =>
    $("button,input,textarea,select").removeAttr("disabled");

/**
 * Displays form errors by adding invalid classes to inputs and showing error messages.
 * @param {Object} xhrData - The data received from the XMLHttpRequest.
 * @param {Object} xhrData.errors - The error object containing field names and error messages.
 */
const showTheFormError = (xhrData, element) => {
    const errors = xhrData.errors;

    $.each(errors, function (key, value) {
        let els = element.find(
            `input[name="${key}"],select[name="${key}"],textarea[name="${key}"]`
        );

        els.addClass("is-invalid");
        els.parents(".form-group")
            .find(".error-wrapper")
            .html(`<div class="text-danger">${value[0]}</div>`);
    });
};

/**
 * Disables hashbang links.
 */
function disableHashbangLink() {
    $("a").each((index, element) => {
        const href = $(element).attr("href");
        if (href && href.indexOf("#") !== -1) {
            element.addEventListener("click", (event) => {
                event.preventDefault();
            });
        }
    });
}

/**
 * Initialize ajax with callbacks for different stages of AJAX request
 *
 * @param {*} data Payload for the AJAX request
 * @param {string} url Target URL for the AJAX request
 * @param {string} method HTTP method for the AJAX request
 * @param {function} beforeSend Callback function to be executed before sending the AJAX request
 * @param {function} success Callback function to be executed upon successful completion of the AJAX request
 * @param {function} error Callback function to be executed if an error occurs during the AJAX request
 * @param {function} complete Callback function to be executed after the AJAX request is completed, regardless of success or failure
 * @returns {void}
 */
function initAjax(data, url, method, beforeSend, success, error, complete) {
    $.ajax({
        url,
        method,
        processData: false,
        contentType: false,
        data,
        beforeSend,
        success,
        error,
        complete,
    });
}

/**
 * Initializes a PDF viewer in the specified container.
 * @param {string} pdfUrl - The URL of the PDF file.
 * @param {string} containerId - The ID of the container element where the PDF will be displayed.
 * @param {number} [pageInit=1] - The current initialize page
 */
function initPDFViewer(pdfUrl, containerId, pageInit = 1) {
    if (typeof pdfjsLib === "undefined") return;

    let pdfDoc = null,
        totalPageNum = 1,
        pageRendering = false,
        pageNumPending = null;

    const canvas = $("<canvas />").get(0),
        target = $(`#${containerId}`),
        scale = 1.0,
        ctx = canvas.getContext("2d");

    /**
     * Render the pagination element
     */
    function renderPagination() {
        const wrapper = $(
                `<div class="d-flex p-3 align-items-center justify-content-between" />`
            ),
            prevButton = $(
                `<button class="btn btn-primary" id="prev-paginate"><i class="ti ti-arrow-left"></i></button>`
            ).click(goToPreviousPage),
            counterPage = $(`<span>${pageInit} / ${totalPageNum}</span>`),
            nextButton = $(
                `<button class="btn btn-primary"><i class="ti ti-arrow-right"></i></button>`
            ).click(goToNextPage);

        prevButton
            .prop("disabled", pageInit === 1)
            .addClass(pageInit === 1 ? "btn-light" : "btn-primary")
            .removeClass(pageInit !== 1 ? "btn-light" : "btn-primary");
        nextButton
            .prop("disabled", pageInit === totalPageNum)
            .addClass(pageInit === totalPageNum ? "btn-light" : "btn-primary")
            .removeClass(
                pageInit !== totalPageNum ? "btn-light" : "btn-primary"
            );

        return wrapper.append(prevButton, counterPage, nextButton);
    }

    const renderPage = (num) => {
        pageRendering = true;

        pdfDoc
            .getPage(num)
            .then((page) => {
                const pageViewport = page.getViewport({
                    scale,
                });
                canvas.height = pageViewport.height;
                canvas.width = pageViewport.width;

                canvas.style.width = "100%";
                canvas.style.height = "100%";

                const renderContext = {
                    canvasContext: ctx,
                    viewport: pageViewport,
                };
                const renderTask = page.render(renderContext);

                let wrapperBag = $(
                        '<div class="pdf-loader bg-light rounded-3 border-light border" />'
                    ),
                    headerSection = $(
                        `<div class="p-3 d-flex align-items-center justify-content-between" />`
                    ).append(
                        $("<strong>Pratinjau PDF</strong>"),
                        $(
                            '<small>Didukung oleh <a href="https://mozilla.github.io/pdf.js/">PDF.js</a></small>'
                        )
                    ),
                    renderElPagination = renderPagination();

                wrapperBag.append(headerSection, canvas, renderElPagination);

                target.html(wrapperBag);

                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            })
            .catch(function (error) {
                console.error("Error loading PDF: " + error);
            });
    };

    /**
     * If another page rendering in progress, waits until the rendering is
     * finished. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function goToPreviousPage() {
        if (pageInit > 1) {
            pageInit--;
            queueRenderPage(pageInit);
        }
    }

    function goToNextPage() {
        if (pageInit < pdfDoc.numPages) {
            pageInit++;
            queueRenderPage(pageInit);
        }
    }

    /**
     * Asynchronously downloads PDF.
     */
    (function () {
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js";

        pdfjsLib.getDocument(pdfUrl).promise.then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            totalPageNum = pdfDoc.numPages;

            // Initial/first page rendering
            renderPage(pageInit);
        });
    })();
}

/**
 * Memuat ulang data dalam tabel DataTables menggunakan AJAX.
 * @param {string} tableId - ID tabel DataTables yang ingin dimuat ulang.
 */
const reloadDataTable = (tableId) =>
    new $.fn.dataTable.Api(tableId).ajax.reload();

/**
 * Initializes form autosubmit AJAX.
 *
 * @param {string} target Target element in the form of ID or class
 * @param {*} onError Handling the error callback
 * @param {*} onFinish Handling on finish callback
 * @param {*} onSuccess Handling for success callback
 * @returns void
 */
function initFormAjax(target, onSuccess, onError, onFinish) {
    $(document).ready(function () {
        $("body").on("submit", target, function (event) {
            event.preventDefault();
            var form = $(this);

            if (form) {
                initAjax(
                    new FormData(form[0]),
                    form.attr("action"),
                    form.attr("method"),
                    function (xhr) {
                        xhr.setRequestHeader(
                            "X-Requested-With",
                            "XMLHttpRequest"
                        );
                        toastrToast("info", "Sedang memproses...");
                        resetError(form);
                    },
                    function (response, status, xhr) {
                        if (onSuccess) {
                            onSuccess(response, status, xhr);
                        }

                        if (
                            xhr.status === 200 &&
                            form.data("redirect-on-success")
                        ) {
                            toastrToast(
                                "success",
                                "Berhasil!",
                                form.data("success-message") ??
                                    "Telah berhasil dilakukan!"
                            );

                            setTimeout(function () {
                                window.location.href =
                                    form.data("redirect-on-success") ?? "";
                            }, 5000);
                        }

                        if (xhr.status === 200 && form.data("reload-table")) {
                            enableInputs();

                            var tableId = form.data("target");
                            reloadDataTable(`${tableId}`);

                            toastrToast(
                                "success",
                                "Berhasil!",
                                form.data("success-message") ??
                                    "Telah berhasil dilakukan!"
                            );
                        }

                        if (
                            xhr.status === 200 &&
                            form.data("reset-form") === true
                        ) {
                            form[0].reset();
                            enableInputs();

                            form.parents(".modal").modal("hide");
                            form.find(".file-upload-container .file-list")
                                .addClass("d-none")
                                .html();

                            form.find(".datepicker")?.datepicker("update", "");
                            form.find("select.select2")
                                ?.empty()
                                .trigger("change");

                            toastrToast(
                                "success",
                                "Berhasil!",
                                form.data("success-message") ??
                                    "Telah berhasil dilakukan!"
                            );
                        }
                    },
                    function (xhr, status, error) {
                        enableInputs();

                        if (onError) {
                            onError(xhr, status, error);
                        }

                        if (xhr.status === 422) {
                            showTheFormError(xhr.responseJSON, form);
                            toastrToast(
                                "error",
                                "Ada Sedikit Kesalahan!",
                                "Mohon periksa kembali inputan yang tidak sesuai!"
                            );
                        } else {
                            toastrToast(
                                "error",
                                "Ada Sedikit Kesalahan!",
                                "Ada sedikit kesalahan di server. Coba lagi beberapa menit."
                            );
                        }
                    },
                    function (a, b, c) {
                        if (onFinish) {
                            onFinish(a, b, c);
                        }
                    }
                );
            }
        });
    });
}

/**
 * Removing double backdrop modal bootstrap
 *
 * @see [Bootstrap multiple modals modal-backdrop issue](https://stackoverflow.com/a/44588254/17911271)
 */
function removingDoubleModalBackdrop() {
    $(".modal").on("shown.bs.modal", function () {
        if ($(".modal-backdrop").length > 1) {
            $(".modal-backdrop").not(':first').remove();
        }
    });

    $(document).on('show.bs.modal', '.modal', function () {
        if ($(".modal-backdrop").length > -1) {
            $(".modal-backdrop").not(':first').remove();
        }
    });
}

/**
 * Initializes all functions.
 */
function initAll() {
    initFormUpload(".file-upload-container");
    initFormAjax(".form-ajax");
    disableHashbangLink();
    removingDoubleModalBackdrop();
}

initAll();
