function setupNotificationTemplateFormEventVariablesHints(eventsVariables) {
    jQuery(function ($) {
        var $helpBlock = $('.field-notificationtemplate-body .help-block');
        var $select = $('#notificationtemplate-event');
        $select.change(function () {
            var selected = $select.val();
            if (selected && eventsVariables[selected]) {
                $helpBlock.html('Доступные подстановки: ' + eventsVariables[selected]);
            } else {
                $helpBlock.html('');
            }
        });
        $select.change();
    });
}
//
jQuery(function ($) {
    $('.notification-database-targeted-index').each(function () {
        var $view = $(this);
        $view.on('click', '.notification-viewed-button', function () {
            var $button = $(this);
            $.ajax({
                type: "POST",
                url: $button.data('url'),
                data: {},
                success: function (response) {
                    $button.closest('div[data-key]').html(response);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        })
    });
});