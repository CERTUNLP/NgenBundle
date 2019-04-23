/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var NetworkAdminForm = Form.extend({
    config: function () {
        this.setNetworkAdminId();
    },
    getObjectBrief: function () {
        return 'network/admin';
    },
    getObjectId: function () {
        return this.getNetworkAdminId();
    },
    setNetworkAdminId: function () {
        this.network_admin_id = $('#id').val();
    },
    getNetworkAdminId: function () {
        return this.network_admin_id;
    },
});

