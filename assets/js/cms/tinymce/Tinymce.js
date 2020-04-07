import $ from "jquery";
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/modern/theme';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/autoresize';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/print';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/hr';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/pagebreak';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/visualchars';
import 'tinymce/plugins/code';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/insertdatetime';
import 'tinymce/plugins/media';
import 'tinymce/plugins/nonbreaking';
import 'tinymce/plugins/save';
import 'tinymce/plugins/table';
import 'tinymce/plugins/directionality';
import 'tinymce/plugins/emoticons';
import 'tinymce/plugins/template';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/textcolor';
import 'tinymce/plugins/colorpicker';
import 'tinymce/plugins/textpattern';
import 'tinymce/plugins/imagetools';
import Modal from '../../cms/modal/Modal';
import TinyMceImageEditModal from './edit-image-modal';

export default class Tinymce {
    constructor(options) {
        if (!options) {
            options = {};
        }
        this.options = Object.assign({
            selector: '.tinymce-textarea',
            addExtraGallery: true
        }, options);
    
        this.element = document.querySelector(this.options.selector);
    
        if (!this.element) {
            throw new Error('No textarea found with the selector "' + this.options.selector + '"');
        }
        let tinymceConfiguration = JSON.parse(this.element.dataset.tinymce);
        tinymceConfiguration = Object.assign(tinymceConfiguration, this.getConfiguration());
        
        tinymce.init(tinymceConfiguration);
    }
    
    bind() {
        console.log('trace');
        document.addEventListener('jk_media.response', (event) => {
            if (!event.hasOwnProperty('htmlContent')) {
                return;
            }
            this.insertContent(event.htmlContent);
        });
        
        document.addEventListener('jk_media.gallery.media-selected', (event) => {
            if (!event.hasOwnProperty('htmlContent')) {
                return;
            }
            this.insertContent(event.htmlContent);
        });
    }
    
    // init: function (selector, options) {
    //     if (!options) {
    //         options = {};
    //     }
    //     $.extend(options, {
    //
    //     });
    //     let __this = this;
    //
    //     $(selector).each(function () {
    //         let configuration = $(this).data('tinymce');
    //         let addImageUrl = $(this).data('add-image-url');
    //         let editImageUrl = $(this).data('edit-image-url');
    //         let addGalleryUrl = $(this).data('add-gallery-url');
    //         let addImageTranslation = $(this).data('add-image-translation');
    //         let addGalleryTranslation = $(this).data('add-gallery-translation');
    //
    //         if (options.addExtraGallery) {
    //             $.extend(configuration, __this.getConfiguration(
    //                 addImageUrl,
    //                 editImageUrl,
    //                 addGalleryUrl,
    //                 addImageTranslation,
    //                 addGalleryTranslation
    //             ));
    //         }
    //
    //         tinymce.init(configuration);
    //     });
    // },

    getConfiguration() {
        const addImageModalUrl = this.element.dataset.addImageUrl;
        //const editImageModalUrl = this.element.dataset.editImageModalUrl;
        const addGalleryUrl = this.element.dataset.addGalleryUrl;
        const addImageTranslation = this.element.dataset.addImageTranslation;
        const addGalleryTranslation = this.element.dataset.galleryTranslation;
    
        // init_instance_callback: function (editor) {
        //     editor.on('dblclick', function (e) {
        //         let element = e.target;
        //
        //         if (!element || element.tagName !== 'IMG') {
        //             return;
        //         }
        //         let url = editImageModalUrl;
        //         let queryString = '?';
        //
        //         $.each(element.attributes, function (index, attribute) {
        //             queryString += 'attributes[' + attribute.name + ']=' + attribute.value;
        //
        //             if (index <= element.attributes.length - 1) {
        //                 queryString += '&';
        //             }
        //         });
        //         url += queryString;
        //         url = encodeURI(url);
        //
        //         Modal.init();
        //         Modal.open(url, function (modal) {
        //             TinyMceImageEditModal.init(modal, tinymce);
        //         });
        //     })
        // },
        
        return {
            selector: this.options.selector,
            setup: function (editor) {
                editor.addButton('add_gallery', {
                    text: addGalleryTranslation,
                    icon: 'image',
                    onclick: function () {
                        const event = new Event('jk_media.gallery-modal.show');
                        event.url = addGalleryUrl;
                        document.dispatchEvent(event);
                        // Modal.init();
                        // Modal.open(addGalleryUrl, function (modal) {
                        //     TinyMceGalleryModal.init(modal, tinymce);
                        // });
                    }
                });

                editor.addButton('add_image', {
                    text: addImageTranslation,
                    icon: 'image',
                    onclick: function () {
                        const event = new Event('jk_media.upload-modal.show');
                        event.url = addImageModalUrl;
                        document.dispatchEvent(event);
                        
                        document.addEventListener('jk_media.response', (event) => {
                            console.log(event.htmlContent);
                        });

                        // let modal = new Modal({
                        //     callback: function (modal) {
                        //         UploadModal.init(modal.modal, tinymce);
                        //     },
                        //     url: addImageModalUrl
                        // });
                        // modal.bind();
                        // modal.show();
                    }
                });
            }
        }
    }
    
    insertContent(content) {
        tinymce.activeEditor.execCommand('mceInsertContent', false, content);
    }
}
