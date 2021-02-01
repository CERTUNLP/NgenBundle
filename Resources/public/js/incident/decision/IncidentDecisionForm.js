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
        $("#state").on("change", $.proxy(this.getNextStates, this));
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
    },
    getNextStates: function (event, args) {
        var $id = $("#state option:selected").val();
        this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
        this.laddaButton.start();
        $.publish('/cert_unlp/incident/state/read', [$id, $.proxy(this.changeDeadlineStates, this)]);
        this.laddaButton.stop();

    },
    changeDeadlineStates: function (response) {
        if (response.responseJSON && response.responseJSON.length) {
            if (response.responseJSON[0].hasOwnProperty('new_states_slug')) {
                $("#unrespondedState").empty()
                $("#unsolvedState").empty()
                response.responseJSON[0].new_states_slug.forEach(function ($state) {
                    $("#unrespondedState").append('<option value=' + $state['slug'] + '>' + $state['name'] + '</option>');
                    $("#unsolvedState").append('<option value=' + $state['slug'] + '>' + $state['name'] + '</option>');
                })

            }

            $("#unrespondedState").trigger('change.select2')
            $("#unsolvedState").trigger('change.select2')
        }
    },
});

