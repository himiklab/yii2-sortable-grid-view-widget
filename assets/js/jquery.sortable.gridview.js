(function ($) {
    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };

    $.fn.SortableGridView = function (id, action) {
        var grid = $('#' + id);
        $('tbody', grid).sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update: function () {
                var serialData = $('tbody', grid).sortable('serialize', {
                    key: 'items[]',
                    attribute: 'class',
                    expression: 'items\\[\\]_(\\w+)'
                });
                $.ajax({
                    'url': action,
                    'type': 'post',
                    'data': serialData,
                    'error': function (request, status, error) {
                        alert(status + ' ' + error);
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    };
})(jQuery);
