(function ($) {
    var fixHelper = function (e, ui) {
        ui.children().each(function () {
            $(this).width($(this).width());
        });
        return ui;
    };

    $.fn.SortableGridView = function (action) {
        var grid = $('tbody', this);
        grid.sortable({
            items: 'tr',
            update: function () {
                var serialData = grid.sortable('serialize', {
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
