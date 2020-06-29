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

    getConfiguration() {
        const addImageModalUrl = this.element.dataset.addImageUrl;
        const addGalleryUrl = this.element.dataset.addGalleryUrl;
        const addImageTranslation = this.element.dataset.addImageTranslation;
        const addGalleryTranslation = this.element.dataset.galleryTranslation;
        
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
                    }
                });

                editor.addButton('add_image', {
                    text: addImageTranslation,
                    icon: 'image',
                    onclick: function () {
                        const event = new Event('jk_media.upload-modal.show');
                        event.url = addImageModalUrl;
                        document.dispatchEvent(event);
                        
                        // TODO remove ?
                        document.addEventListener('jk_media.response', (event) => {
                            console.log(event.htmlContent);
                        });
                    }
                });
            }
        }
    }
    
    insertContent(content) {
        tinymce.activeEditor.execCommand('mceInsertContent', false, content);
    }
}
