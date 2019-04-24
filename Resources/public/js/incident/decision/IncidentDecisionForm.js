/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentDecisionForm = Form.extend({
    config: function () {
        this.setIncidentDecisionId();
    },
    getObjectBrief: function () {
        return 'incident/decision';
    },
    getObjectId: function () {
        return this.getIncidentDecisionId();
    },
    setIncidentDecisionId: function () {
        this.incident_decision_id = $('#id').val();
    },
    getIncidentDecisionId: function () {
        return this.incident_decision_id;
    }
});

