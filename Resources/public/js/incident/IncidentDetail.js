/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentDetail = Frontend.extend({
    init: function (base_url) {
        this.base_url = base_url;
        $('.message-set-pending').on('click', $.proxy(this.messagePending, this));
    },
    getObjectBrief: function () {
        return 'incident';
    },
    messagePending: function (event) {
        id = $(event.currentTarget).data('id');
        $.post(this.base_url + "messages/" + id + '/pending', function () {
            $(event.currentTarget).siblings('.d-none').removeClass('d-none')
            $(event.currentTarget).toggle()
            $(event.currentTarget).parents('.card').first().children('h6').removeClass('border-left-success')
            $(event.currentTarget).parents('.card').first().children('h6').addClass('border-left-warning')
            $.publish('/cert_unlp/notify/success', ["Message scheduled"]);
        });
    },
});