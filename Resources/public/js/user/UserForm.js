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
    handleExtraErrors: function (jqXHR){
        if(jqXHR.responseJSON.errors.fields.hasOwnProperty("plainPassword")){
            k="plainPassword_first";
            ul = $('<ul class="help-block" ></ul>');
            ul.append($('<li>' + jqXHR.responseJSON.errors.fields.plainPassword + '</li>'));
            $('#' + k).after(ul);
            $('#' + k).closest('div[class="form-group"]').addClass('has-error');
        }
        },
});

