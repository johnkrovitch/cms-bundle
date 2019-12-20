export default {
    insert: function (tinymce, content) {
        tinymce.activeEditor.execCommand('mceInsertContent', false, content);
    },

    replaceSelected: function (tinymce, content) {
        tinymce.activeEditor.selection.setContent(content);
    },

    select: function (tinymce, elementId) {
        tinymce.activeEditor.selection.select(tinymce.activeEditor.dom.get(elementId));
    },

    /**
     * Trigger an event on an tinymce element selected by its id.
     *
     * @param tinymce   Tinymce instance
     * @param elementId Id string without the hash tag.
     */
    trigger: function (tinymce, elementId) {
        TinyMceHelper.select(tinymce, elementId);
        tinymce.activeEditor.dom.fire(tinymce.activeEditor.dom.get(elementId), 'dblclick');
    }
};
