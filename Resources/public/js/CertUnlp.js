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
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible"><button type="button" class="close" data-dismiss="alert">×</button>' + text + '</div>');
        alert.alert();
        window.setTimeout(function () {
            alert.fadeTo(500, 0).slideUp(500, function () {
                $(this).alert('close');
            });
        }, 5000);
        return alert;
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
    notifyError: function (text) {
        this.notificationsDiv.append(this.getDangerAlert(text));
    },
    notifySuccess: function (text) {
        this.notificationsDiv.append(this.getSuccessAlert(text));
    },
    notifyInfo: function (text) {
        this.notificationsDiv.append(this.getInfoAlert(text));
    }

});

var CertUnlp = Class.extend({
    init: function () {
        this.notify = new Notify();
    },
});

$(document).ready(function() {
    $("#menu-toggle").click(function(e) {
        e.preventDefault();

        $("#wrapper").toggleClass("toggled");

        $('#wrapper.toggled').find("#sidebar-wrapper").find(".collapse").collapse('hide');

    });
});