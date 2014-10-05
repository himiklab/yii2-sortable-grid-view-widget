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
            items: 'tr',
            update: function () {
                var serialData = $('tbody', grid).sortable('serialize', {
                    key: 'items[]',
                    attribute: 'class',
                    expression: 'items\\[\\]_(\\w+)'
                });

                var yiiCsrfParam = yii.getCsrfParam();
                if (yiiCsrfParam !== undefined) {
                    serialData += '&' + yiiCsrfParam + '=' + yii.getCsrfToken();
                }

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
