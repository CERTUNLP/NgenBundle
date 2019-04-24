/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentTypeForm = Form.extend({
    config: function () {
        this.setIncidentTypeId();
    },
    getObjectBrief: function () {
        return 'incident/type';
    },
    getObjectId: function () {
        return this.getIncidentTypeId();
    },
    setIncidentTypeId: function () {
        this.incident_type_id = (($('#name').val().replace(' ', '_'))).toLowerCase();
    },
    getIncidentTypeId: function () {
        return this.incident_type_id;
    }
});

