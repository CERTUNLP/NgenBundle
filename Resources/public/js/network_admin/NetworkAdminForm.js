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
    getFormId: function () {
        return 'network_admin_add_update_form';
    },
    getObjectBrief: function () {
        return 'network';
    },
    getObjectId: function () {
        return  this.getNetworkId();
    },
    setNetworkId: function () {
        this.networkId = $('#ip').val();
    },
    getNetworkId: function () {
        return  this.networkId;
    },
});

