$(document).ready(function () {

    $(document).on('click', '.btn-spinner', function () {

        let formId = $(this).data('form');
        let form   = document.getElementById(formId);

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        $(this)
            .html('<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...')
            .prop('disabled', true);

        form.submit();
    });

});