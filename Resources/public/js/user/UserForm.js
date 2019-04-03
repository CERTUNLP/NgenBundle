/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var UserForm = Form.extend({
    config: function (apiUrl, apiKey) {
        this.setUserId();
    },
    getObjectBrief: function () {
        return 'user';
    },
    getObjectId: function () {
        return this.getUserId();
    },
    setUserId: function () {
        this.userId = $('#username').val();
    },
    getUserId: function () {
        return this.userId;
    },
    handleExtraErrors: function (xhr) {
        var data = $.parseJSON(xhr.responseText);

        if (data.messages) {
            var messages = data.messages;

            var i;

            if (messages.error) {
                for (i = 0; i < messages.error.length; i++) {
                    methods.addError(messages.error[i]);
                }
            }

            if (messages.success) {
                for (i = 0; i < messages.success.length; i++) {
                    methods.addSuccess(messages.success[i]);
                }
            }

            if (messages.info) {
                for (i = 0; i < messages.info.length; i++) {
                    methods.addInfo(messages.info[i]);
                }
            }
        }
    },
    addSuccess: function(message) {
        var flashMessageElt = methods.getBasicFlash(message).addClass('alert-success');

        methods.addToList(flashMessageElt);
        methods.display(flashMessageElt);
    },

    addError: function(message) {
        var flashMessageElt = methods.getBasicFlash(message).addClass('alert-error');

        methods.addToList(flashMessageElt);
        methods.display(flashMessageElt);
    },

    addInfo: function(message) {
        var flashMessageElt = methods.getBasicFlash(message).addClass('alert-info');

        methods.addToList(flashMessageElt);
        methods.display(flashMessageElt);
    },

    getBasicFlash: function(message) {
        var flashMessageElt = $('<div></div>')
            .hide()
            .addClass('alert')
            .append(methods.getCloseButton())
            .append($('<div></div>').html(message))
        ;

        return flashMessageElt;
    },

    getCloseButton: function() {
        var closeButtonElt = $('<button></button>')
            .addClass('close')
            .attr('data-dismiss', 'alert')
            .html('&times')
        ;

        return closeButtonElt;
    },

    addToList: function(flashMessageElt) {
        flashMessageElt.appendTo($('#flash-messages'));
    },

    display: function(flashMessageElt) {
        setTimeout(
            function() {
                flashMessageElt
                    .show('slow')
                    .delay(methods.settings.hideDelay)
                    .hide('fast', function() { $(this).remove(); } )
                ;
            },
            500
        );
    },
    );
});


