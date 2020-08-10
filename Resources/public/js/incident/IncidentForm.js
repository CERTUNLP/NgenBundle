/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentForm = Form.extend({
    config: function (params) {
        this.setIncidentId();
        $("#incident_tlp").on("change", $.proxy(this.changeTLP, this));
        $("#incident_type").on("change", $.proxy(this.getIncidentDecision, this));
        $("#incident_address").on("change", $.proxy(this.getIncidentDecision, this));
        $("#incident_feed").on("change", $.proxy(this.getIncidentDecision, this));
        $(".incidentFilter").on("change", $.proxy(this.getIncident, this));
        this.changeTLP();
    },
    changeTLP: function () {
        $("#tlp_label").first().html("TLP:" + $("#incident_tlp option:selected").text());
        $("#tlp_label").attr('class', "tlp-" + $("#incident_tlp option:selected").val());
    },
    getIncidentDecision: function (event) {
        let $ip = $("#incident_address").val();
        var $id = $("#incident_type option:selected").val() + '/' + $("#incident_feed option:selected").val() + ($ip ? '/' + $ip : '');
        this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
        this.laddaButton.start();
        $.publish('/cert_unlp/incident/decision/read', [$id, $.proxy(this.changeDefaults, this)]);
        this.laddaButton.stop();
    },
    getIncident: function () {
        let $ip = $("#incident_address").val();
        var $data = $("#incident_type option:selected").val() + ($ip ? '/' + $ip : '');
        $.publish('/cert_unlp/incident/search', [$data, $.proxy(this.changeIncidentInfo, this)]);
    },
    changeDefaults: function (response) {
        if (response.responseJSON && response.responseJSON.length) {
            $("#incident_tlp").val(response.responseJSON[0].tlp.slug).trigger('change');
            $("#incident_state").val(response.responseJSON[0].state.slug).trigger('change');
            $("#incident_impact").val(response.responseJSON[0].priority.impact.slug).trigger('change');
            $("#incident_urgency").val(response.responseJSON[0].priority.urgency.slug).trigger('change');
            $("#incident_unattendedState").val(response.responseJSON[0].unattended_state.slug).trigger('change');
            $("#incident_unsolvedState").val(response.responseJSON[0].unsolved_state.slug).trigger('change');
           this.changePriorityTimes(response.responseJSON[0].priority);
        }
    },
    changePriorityTimes: function (priority) {
        if (priority) {
            var $calculo = new Date(new Date($("#incident_solveDeadLine").val()).getTime() + priority.unresponse_time * 60000);
            $("#incident_solveDeadLine").val($calculo.toISOString().substring(0, 19));
            var $calculo2 = new Date(new Date($("#incident_responseDeadLine").val()).getTime() + priority.unresolution_time * 60000);
            $("#incident_responseDeadLine").val($calculo2.toISOString().substring(0, 19));
        }
    },
    setIncidentId: function () {
        this.incidentId = $('#incident_id').val();
    },
    getObjectBrief: function () {
        return 'incident';
    },
    getObjectId: function () {
        return this.incidentId;
    },
    changeIncidentInfo: function (response) {
        if (response.responseJSON) {
            if (response.responseJSON.length == 1) {
                $('#incidentInfo').html('<hr>Incident exist!<a href="' + response.responseJSON[0].id + '/edit">Edit</a>');
            } else if (response.responseJSON.length > 1) {
                $('#incidentInfo').html('<hr><a href="">More than one incident with this information.</a>');
            } else {
                $('#incidentInfo').html('<hr>This is a new Incident');
            }
        }

    }
});

