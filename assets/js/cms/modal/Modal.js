require('bootstrap');

export default class Modal {
    constructor(options) {
        if (!options) {
            options = {};
        }
        this.options = Object.assign({
            selector: '#cms-modal',
            triggerSelector: '.cms-modal-link',
            callback: null
        }, options);

        this.modal = $(this.options.selector);

        if (!this.modal.length) {
            throw new Error('Missing element with selector "' + options.selector + '"');
        }
    }

    bind(callback) {
        if (!this.modal) {
            return;
        }
        let modal = this.modal;

        $(this.options.triggerSelector).on('click', function() {
            if ($(this).data('url')) {
                $.ajax($(this).data('url'), {
                    success: function (response) {
                        modal.find('.modal-content').html(response);

                        if (callback) {
                            callback();
                        } else {
                            if (modal.options.callback) {
                                modal.options.callback();
                            }
                        }
                    }
                });
            }
        });
        
        $('.cancel-link').on('click', function () {
            modal.modal('hide');
        })
    }

    show() {
        if (this.options.url) {
            this.load(this.options.url);
        }
        this.modal.modal();
    }

    close() {
        this.modal.modal('hide');

        // Fix a bug that Bootstrap is not removing the background
        document.querySelectorAll('.modal-backdrop.fade.show').forEach((element) => {
            element.remove();
        });
    }

    getElement() {
        return this.modal;
    }

    load(url, bindingCallback) {
        let modalContent = this.modal.find('.modal-content');
        let __this = this;

        modalContent.load(url, function () {

            if (bindingCallback) {
                bindingCallback(__this);
            }
            __this.modal.modal('show');
        });
    }
}
