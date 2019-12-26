/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var HostForm = Form.extend({
    config: function (apiUrl, apiKey) {
        this.setId();
        $("#type").on("change", $.proxy(this.changeDefaults, this));
    },
    getObjectBrief: function () {
        return 'network/host';
    },
    getObjectId: function () {
        return this.getNetworkId();
    },
    setId: function () {
        this.id = $('#address').val();
    },
    getNetworkId: function () {
        return this.id;
    },
});

