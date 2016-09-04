var COGEditor = (function() {
    var $editor;

    var init = function($el) {
        $editor = $el;

        $el.summernote({
            disableDragAndDrop: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr', 'template']],
                ['view', ['codeview']],
            ],
            template: {
                path: '/summernote/templates',
                list: [ // list of your template (without the .html extension)
                    'numbered-list',
                ]
            },
        });
    };

    var content = function (text) {
        if ( ! $editor ) return '';

        if ( ! text ) return $editor.summernote('code');

        $editor.summernote('code', text);
    };

    return {
        init: init,
        content: content
    }
})();

$(function() {
    COGEditor.init( $('.summernote') );
});