var customSwal = {
    showAlert: (title, text, html, confirmButtonText, confirmButtonClass, icon) => {
        return Swal.fire({
            title: title,
            text: text,
            html: html,
            icon: icon,
            confirmButtonText: confirmButtonText,
            customClass: {
                confirmButton: confirmButtonClass
            }
        });
    },
    showConfirm: (title, text, html, confirmButtonText, confirmButtonClass, cancelButtonText, cancelButtonClass, icon, callback) => {
        return Swal.fire({
            title: title,
            text: text,
            html: html,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            customClass: {
                confirmButton: confirmButtonClass,
                cancelButton: cancelButtonClass
            }
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            } else if (result.isDismissed) {
                Swal.close();
            }
        });
    }
};