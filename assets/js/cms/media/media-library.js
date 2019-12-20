// let MediaGallery = {
//     container: null,
//     endpoint: null,
//     target: null,
//     mediaLimit: 1,
//
//     init: function (container, options) {
//         this.container = container;
//         this.endpoint = container.data('target');
//         this.target = options.target;
//         this.mediaLimit = options.mediaLimit;
//     },
//
//     load: function () {
//         // avoid to load invalid url
//         if (!this.endpoint) {
//             throw 'Invalid media gallery endpoint url';
//         }
//
//         this.container.load(this.endpoint, function () {
//             MediaGallery.bind();
//         });
//     },
//
//     bind: function () {
//         this.container.find('.media-pagination a').on('click', function () {
//             MediaGallery.load($(this).attr('href'));
//
//             return false;
//         });
//
//         this.container.find('.media-list .media-item').on('click', function () {
//             let medias = MediaGallery.getSelectedMedias();
//
//             if (MediaGallery.mediaLimit === 1) {
//                 medias.removeClass('selected');
//                 $(this).toggleClass('selected');
//
//                 MediaGallery.target.val($(this).data('id'));
//             } else {
//
//                 if (medias.length < MediaGallery.mediaLimit) {
//                     $(this).toggleClass('selected');
//                 } else {
//                     $(this).removeClass('selected');
//                 }
//             }
//
//             return false;
//         });
//     },
//
//     getSelectedMedias: function () {
//         return this.container.find('.media-list .media-item.selected');
//     }
// };

// var MediaHelper = {
//     getMediaContent: function (ids) {
//
//     }
// };

// var MediaGallery = {
//     element: null,
//     options: {},
//
//     init: function (options) {
//         var defaults = {
//             selector: '.media-list'
//         };
//         this.options = defaults.concat(options);
//         this.element = $(this.options.selector);
//
//         // select the media on click
//         this.element
//             .find('.media .media-link')
//             .on('click', function () {
//                 $(this).toggleClass('selected');
//
//                 return false
//             })
//         ;
//         $('#add-gallery-btn').on('click', function () {
//             var selectedMedias = galleryModal.find('.media a.selected');
//
//             if (selectedMedias.length === 0) {
//                 return;
//             }
//             var ids = [];
//
//             selectedMedias.each(function (index, value) {
//                 ids.push($(value).data('id'));
//             });
//             var route = routes.galleryContent + '?ids=' + ids.join(',');
//
//             $.get(route, function (data) {
//                 tinymce.activeEditor.execCommand('mceInsertContent', false, data);
//                 galleryModal.modal('hide');
//             });
//         });
//     },
//
//     getSelectedMediaIds: function () {
//         var mediaGallery = $(this.selector);
//         var medias = mediaGallery.find('.media a.selected');
//         var ids = [];
//
//         medias.each(function (index, value) {
//             ids.push($(value).data('id'));
//         });
//
//         return ids;
//     }
// };
