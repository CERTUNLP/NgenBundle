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
        $("#type").on("change", $.proxy(this.changeDefaults, this));
    },
    changeDefaults: function (event) {
        event.preventDefault();
        if ($("#type").val() === 'rdap') {
            $("#networkAdmin").parents('.form-group').hide();
            $("#networkEntity").parents('.form-group').hide();
        } else {
            $("#networkAdmin").parents('.form-group').show();
            $("#networkEntity").parents('.form-group').show();
        }
    },
    getObjectBrief: function () {
        return 'network';
    },
    getObjectId: function () {
        return this.getNetworkId();
    },
    setNetworkId: function () {
        this.networkId = $('#ip_v4').val();
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
                $('#ip_v4').after(ul);
                $('#ip_v4').closest('div[class="form-group"]').addClass('has-error');
            } else {
                $('#ip_v4').closest('div[class="form-group has-error"]').removeClass('has-error');
                $('#ip_v4').siblings('ul').remove();
            }
        });
    }
});

