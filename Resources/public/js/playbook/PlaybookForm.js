/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var PlaybookForm = Form.extend({
    config: function (params) {
        this.setIncidentId();
    },
    setIncidentId: function () {
        this.incidentId = $('#id').val();
    },
    getObjectBrief: function () {
        return 'playbook';
    },
    getObjectId: function () {
        return this.incidentId;
    },
});

