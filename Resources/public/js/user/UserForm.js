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
    handleExtraErrors: function (jqXHR) {
        function ya(jqXHR.responseJSON.errors.children) {
            console.log(obj.name);
            if (obj.child) {
                console.log("length=" + obj.child.length);
                for (i = 0; i < obj.child.length; i++) {
                    ya(obj.child[i]);
                }
            }
        }
        $.each(jqXHR.responseJSON.errors.children, function (k, v) {
            errorsText = "";
            if (! jQuery.isEmptyObject(v)    ) {
                ul = $('<ul class="help-block" ></ul>');
                ul.append($('<li>' + JSON.stringify(v,) + '</li>'));
                $('#error').after(ul);
                $('#error').closest('div[class="form-group"]').addClass('has-error');
            } else {
                $('#error').closest('div[class="form-group has-error"]').removeClass('has-error');
                $('#error').siblings('ul').remove();
            }
        });

    }
});

