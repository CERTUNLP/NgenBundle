/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var NetworkEntityForm = Form.extend({
    config: function () {
        this.setNetworkEntityId();
    },
    getObjectBrief: function () {
        return 'network/entity';
    },
    getObjectId: function () {
        return this.getNetworkEntityId();
    },
    setNetworkEntityId: function () {
        this.network_entity_id = this.slugify($('#name').val());
    },
    getNetworkEntityId: function () {
        return this.network_entity_id;
    }

});

