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
        $("#tlp").on("change", $.proxy(this.changeTLP, this));
        $("#type").on("change", $.proxy(this.getIncidentDecision, this));
        $("#feed").on("change", $.proxy(this.getIncidentDecision, this));
        $(".incidentFilter").on("change", $.proxy(this.getIncident, this));
        this.changeTLP();
    },
    changeTLP: function () {
        $("#tlp_label").first().html("TLP:" + $("#tlp option:selected").text());
        $("#tlp_label").attr('class', "tlp-" + $("#tlp option:selected").val());
    },
    getIncidentDecision: function () {
        let $ip = $("#address").val();
        var $id = $("#type option:selected").val() + '/' + $("#feed option:selected").val() + ($ip ? '/' + $ip : '');
        this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
        this.laddaButton.start();
        $.publish('/cert_unlp/incident/decision/read', [$id, $.proxy(this.changeDefaults, this)]);
        this.laddaButton.stop();
    },
    getIncident: function () {
        let $ip = $("#address").val();
        var $data = $("#type option:selected").val() + ($ip ? '/' + $ip : '');
        $.publish('/cert_unlp/incident/search', [$data, $.proxy(this.changeIncidentInfo, this)]);
    },
    changeDefaults: function (response) {
        if (Object.keys(response).length) {
            $("#tlp").val(response.responseJSON.tlp.slug).trigger('change');
            $("#state").val(response.responseJSON.state.slug).trigger('change');
            $("#impact").val(response.responseJSON.impact.slug).trigger('change');
            $("#urgency").val(response.responseJSON.urgency.slug).trigger('change');
            $("#unattendedState").val(response.responseJSON.unattended_state.slug).trigger('change');
            $("#unsolvedState").val(response.responseJSON.unsolved_state.slug).trigger('change');
            $.publish('/cert_unlp/incident/priority/read', [response.responseJSON.impact.slug + '_' + response.responseJSON.urgency.slug, $.proxy(this.changePriorityTimes, this)]);
        }
    },
    changePriorityTimes: function (response) {
        if (Object.keys(response).length) {
            var $calculo= new Date(new Date($("#solveDeadLine").val()).getTime()+ response.responseJSON.unresponse_time*60000);
            $("#solveDeadLine").val($calculo.toISOString().substring(0, 19));
            var $calculo2= new Date(new Date($("#responseDeadLine").val()).getTime()+ response.responseJSON.unresolution_time*60000);
            $("#responseDeadLine").val($calculo2.toISOString().substring(0, 19));

        }
    },
    setIncidentId: function () {
        this.incidentId = $('#id').val();
    },
    getObjectBrief: function () {
        return 'incident';
    },
    getObjectId: function () {
        return this.incidentId;
    },
    changeIncidentInfo: function (response) {
        if (response.responseJSON.length == 1) {
            $('#incidentInfo').html('<hr>Incident exist!<a href="' + response.responseJSON[0].id + '/edit">Edit</a>');
            disableIncidentFields();
        } else if (response.responseJSON.length > 1) {
            $('#incidentInfo').html('<hr><a href="">More than one incident with this information.</a>');
        } else {
            $('#incidentInfo').html('<hr>This is a new Incident');
        }

    }
});

