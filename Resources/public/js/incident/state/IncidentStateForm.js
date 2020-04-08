/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentStateForm = Form.extend({
    config: function () {
        this.setIncidentStateId();
    },
    getObjectBrief: function () {
        return 'incident/state';
    },
    getObjectId: function () {
        return this.getIncidentStateId();
    },
    setIncidentStateId: function () {
        this.incident_state_id = (($('#name').val().replace(/ /g, '_'))).toLowerCase();
    },
    getIncidentStateId: function () {
        return this.incident_state_id;
    }
});

