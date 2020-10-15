/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var Notify = Class.extend({
    init: function () {
        this.notificationsDiv = $("div#notifications");
        $.subscribe('/cert_unlp/notify/error', $.proxy(this.notifyError, this));
        $.subscribe('/cert_unlp/notify/success', $.proxy(this.notifySuccess, this));
        $.subscribe('/cert_unlp/notify/info', $.proxy(this.notifyInfo, this));
        window.setTimeout(function () {
            $(".notifications.alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 5000);
    },
    getNotificationTemplate: function (text, type) {

        let toast = $(' <div class="toast ml-auto alert-' + type + '" role="alert" aria-live="assertive" aria-atomic="true">\n' +
            '                <div class="toast-header">\n' +
            '                   <strong class="mr-auto"> <i class="fa fa-exclamation-circle text-' + type + '"></i> Notification</strong>\n' +
            '                    <small class="text-muted">just now</small>\n' +
            '                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n' +
            '                        <span aria-hidden="true">&times;</span>\n' +
            '                    </button>\n' +
            '                </div>\n' +
            '                <div class="toast-body">\n' +
            '                   ' + text + '\n' +
            '                </div>\n' +
            '            </div>');
        $(toast).toast({autohide: true, delay: 3500})
        return toast;
    },
    getDangerAlert: function (text) {
        return this.getNotificationTemplate(text, 'danger');
    },
    getSuccessAlert: function (text) {
        return this.getNotificationTemplate(text, 'success');
    },
    getInfoAlert: function (text) {
        return this.getNotificationTemplate(text, 'info');
    },
    notify: function (toast) {
        this.notificationsDiv.append(toast);
        $(toast).toast('show');
    },
    notifyError: function (text) {
        this.notify(this.getDangerAlert(text))
    },
    notifySuccess: function (text) {
        this.notify(this.getSuccessAlert(text))
    },
    notifyInfo: function (text) {
        this.notify(this.getInfoAlert(text))
    }

});

var CertUnlp = Class.extend({
    init: function () {
        this.notify = new Notify();
    },
});

$(document).ready(function () {
    $("#menu-toggle").click(function (e) {
        e.preventDefault();

        $("#wrapper").toggleClass("toggled");
        $('#wrapper.toggled').find("#sidebar-wrapper").find(".collapse").collapse('hide');

    });
});