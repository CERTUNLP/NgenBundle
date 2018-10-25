/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var NetworkForm = Form.extend({
    config: function (apiUrl, apiKey) {
        this.setNetworkId();
    },
    getObjectBrief: function () {
        return 'network';
    },
    getObjectId: function () {
        return this.getNetworkId();
    },
    setNetworkId: function () {
        this.networkId = $('#ip').val();
    },
    getNetworkId: function () {
        return this.networkId;
    },
    handleExtraErrors: function (jqXHR) {
        $.each(jqXHR.responseJSON.errors.errors, function (k, v) {
            errorsText = "";
            if (v.length > 0) {
                ul = $('<ul class="help-block" ></ul>');
                ul.append($('<li>' + v + '</li>'));
                $('#ip').after(ul);
                $('#ip').closest('div[class="form-group"]').addClass('has-error');
            } else {
                $('#ip').closest('div[class="form-group has-error"]').removeClass('has-error');
                $('#ip').siblings('ul').remove();
            }
        });
    }
});

