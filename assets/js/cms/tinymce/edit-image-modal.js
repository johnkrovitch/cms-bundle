import TinyMceHelper from './helper';

export default {
    modal: null,
    tinymce: null,

    init: function (modal, tinymce) {
        this.modal = modal;
        this.tinymce = tinymce;
        this.bindForm();
    },

    bindForm: function () {
        let form = this.modal.modal.find('form');
        let __this = this;

        // on form submit, replace the image tag by the returned content
        form.on('submit', function () {
            $.ajax({
                url: form.attr('action'),
                method: 'post',
                data: form.serialize(),
                statusCode: {
                    206: function (response) {
                        // a valid content is found, we replace the selected content in tinymce by the new one
                        TinyMceHelper.replaceSelected(__this.tinymce, response);
                        __this.modal.close();
                    },
                    200: function (response) {
                        // the form is not valid or not submitted, we display the form content to display errors
                        __this.modal.replace(response);
                    }
                }
            });

            return false;
        });

        // Keep the media size proportion if the check box is checked
        let keepRatioCheckbox = form.find('.keep-proportion-checkbox');
        let heightElement = $(keepRatioCheckbox.data('target-height'));
        let widthElement = $(keepRatioCheckbox.data('target-width'));
        let ratio = heightElement.val() / widthElement.val();

        heightElement.on('change', function () {
            if (keepRatioCheckbox.is(':checked')) {
                let newWidth = $(this).val() / ratio;
                widthElement.val(Math.round(newWidth));
            }
        });

        widthElement.on('change', function () {
            if (keepRatioCheckbox.is(':checked')) {
                let newHeight = $(this).val() * ratio;
                heightElement.val(Math.round(newHeight));
            }
        });
    }
};
