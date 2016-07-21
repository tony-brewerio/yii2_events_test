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
