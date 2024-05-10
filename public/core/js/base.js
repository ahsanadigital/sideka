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
 * Converts a file size from bytes to a human-readable format.
 *
 * @param {number} bytes - The file size in bytes.
 * @returns {string} The human-readable file size.
 */
function humanReadableSize(bytes) {
    const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
    if (bytes === 0) return "0 Byte";
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
};

/**
 * Initializes the file upload functionality.
 * @param {string} targetElement - The selector of the target element.
 */
function initFormInput(targetElement) {
    const fileInput = $(targetElement).find("#file");
    const fileList = $(targetElement).find(".file-list");
    const acceptAttribute = fileInput.attr("accept");
    const maxFileSize = parseInt(fileInput.data("max-filesize")) || null;

    // Function to remove a file from the list
    function removeFile(fileName) {
        const input = fileInput[0];
        const files = input.files;
        const remainingFiles = Array.from(files).filter(file => file.name !== fileName);

        const newFileList = new DataTransfer();
        remainingFiles.forEach(file => newFileList.items.add(file));

        input.files = newFileList.files;
        fileList.find(`[data-file-name="${fileName}"]`).remove();

        hideFileListIfEmpty(remainingFiles);
    };

    // Function to hide file list if empty
    function hideFileListIfEmpty(files) {
        if (files.length === 0) {
            fileList.addClass("d-none");
        }
    };

    // Function to validate file type based on accept attribute
    function validateFileType(file) {
        if (!acceptAttribute) {
            return true; // No accept attribute specified
        }
        const acceptedTypes = acceptAttribute.split(",");
        return acceptedTypes.some((type) => type.trim() === file.type);
    };

    // Function to validate file size based on max-filesize attribute
    function validateFileSize(file) {
        if (!maxFileSize) {
            return true; // No max-filesize attribute specified
        }
        return file.size <= maxFileSize;
    };

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
        fileList.removeClass("d-none").addClass('pt-3 mb-0');
        hideFileListIfEmpty(files);
        files.forEach((file) => {
            if (!validateFileType(file)) {
                toastrToast(
                    'error',
                    'Kesalahan!',
                    `Maaf, unggah sesuai dengan tipe berkasnya, yakni: ${acceptAttribute}`
                );
                fileList.removeClass("pt-3 mb-0").addClass('d-none');
                return;
            }
            if (!validateFileSize(file)) {
                toastrToast(
                    'error',
                    'Kesalahan!',
                    `Berkas yang anda unggah melebihi ketentuan, yakni ${humanReadableSize(maxFileSize)}.`
                );
                fileList.removeClass("pt-3 mb-0").addClass('d-none');
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
                <div>${humanReadableSize(file.size)}</div>
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
};

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
 * Resets the error state and disables buttons and inputs.
 */
const resetError = (element) => {
    $("button,input").attr("disabled", true);
    element.find(".error-wrapper").empty();
    element.find("input").removeClass("is-invalid");
};

/**
 * Enables all inputs.
 */
const enableInputs = () => {
    $("button,input").removeAttr("disabled");
};

/**
 * Displays form errors by adding invalid classes to inputs and showing error messages.
 * @param {Object} xhrData - The data received from the XMLHttpRequest.
 * @param {Object} xhrData.errors - The error object containing field names and error messages.
 */
const showTheFormError = (xhrData, element) => {
    const errors = xhrData.errors;

    $.each(errors, function (key, value) {
        let els = element.find(`input[name="${key}"]`);

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
 * Initializes form autosubmit AJAX.
 *
 * @param {string} target Target element in the form of ID or class
 */
function initFormAjax(
    target,
    successCallback,
    errorCallback,
    onCompleteCallback
) {
    $(document).ready(function () {
        $(target).submit(function (event) {
            event.preventDefault();
            var form = $(this);
            if (form) {
                $.ajax({
                    url: form.attr("action"),
                    type: form.attr("method"),
                    data: form.serialize(),

                    beforeSend: function (xhr) {
                        xhr.setRequestHeader(
                            "X-Requested-With",
                            "XMLHttpRequest"
                        );
                        toastrToast("info", "Sedang memproses...");
                        resetError(form);
                    },
                    success(response, status, xhr) {
                        if (successCallback) {
                            successCallback(response, status, xhr);
                        } else {
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

                            if (
                                xhr.status === 200 &&
                                form.data("reload-table")
                            ) {
                                var tableId = form.data("target");
                                $(`${tableId}`).DataTable().ajax.reload();

                                toastrToast(
                                    "success",
                                    "Berhasil!",
                                    form.data("success-message") ??
                                        "Telah berhasil dilakukan!"
                                );
                            }
                        }
                    },
                    error(xhr, status, error) {
                        enableInputs();

                        if (errorCallback) {
                            errorCallback(xhr, status, error);
                        } else {
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
                        }
                    },
                    complete() {
                        if (onCompleteCallback) {
                            onCompleteCallback();
                        }
                    },
                });
            }
        });
    });
}

/**
 * Initializes all functions.
 */
function initAll() {
    initFormAjax(".form-ajax");
    disableHashbangLink();
}

initAll();
