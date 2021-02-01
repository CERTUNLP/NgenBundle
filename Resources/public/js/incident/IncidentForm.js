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
        $("#state").on("change", $.proxy(this.getNextStates, this));
        $("#type").on("change", $.proxy(this.getIncidentDecision, this));
        $("#address").on("change", $.proxy(this.getIncidentDecision, this));
        $("#feed").on("change", $.proxy(this.getIncidentDecision, this));
        $(".incidentFilter").on("change", $.proxy(this.getIncident, this));
        this.changeTLP();
        this.lastDecision = null;
    },
    changeTLP: function () {
        $("#tlp_label").first().html("TLP:" + $("#tlp option:selected").text());
        $("#tlp_label").attr('class', "tlp-" + $("#tlp option:selected").val());
    },
    getIncidentDecision: function (event) {
        let $ip = $("#address").val();
        var $id = $("#type option:selected").val() + '/' + $("#feed option:selected").val() + ($ip ? '/' + $ip : '');
        this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
        this.laddaButton.start();
        $.publish('/cert_unlp/incident/decision/read', [$id, $.proxy(this.changeDefaults, this)]);
        this.laddaButton.stop();
    },
    changeDefaults: function (response) {
        if (response.responseJSON && response.responseJSON.length) {
            this.lastDecision = response.responseJSON[0];
            $("#state").val(response.responseJSON[0].state.slug).trigger('change', response.responseJSON[0]);
            $("#tlp").val(response.responseJSON[0].tlp.slug).trigger('change.select2');
            $("#impact").val(response.responseJSON[0].priority.impact.slug).trigger('change.select2');
            $("#urgency").val(response.responseJSON[0].priority.urgency.slug).trigger('change.select2');
            this.changePriorityTimes(response.responseJSON[0].priority);
        }
    },
    getNextStates: function (event, args) {
        if (!this.lastDecision) {
            this.getIncidentDecision();
        } else {
            var $id = $("#state option:selected").val();
            this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
            this.laddaButton.start();
            $.publish('/cert_unlp/incident/state/read', [$id, $.proxy(this.changeDeadlineStates, this)]);
            this.laddaButton.stop();
        }
    },
    changeDeadlineStates: function (response) {
        if (response.responseJSON && response.responseJSON.length) {
            if (response.responseJSON[0].hasOwnProperty('new_states_slug')) {
                // $prev_unrespondedState = $("#unrespondedState option:selected").val()
                // $prev_unsolvedState = $("#unsolvedState option:selected").val()
                $("#unrespondedState").empty()
                $("#unsolvedState").empty()
                response.responseJSON[0].new_states_slug.forEach(function ($state) {
                    $("#unrespondedState").append('<option value=' + $state['slug'] + '>' + $state['name'] + '</option>');
                    $("#unsolvedState").append('<option value=' + $state['slug'] + '>' + $state['name'] + '</option>');
                })

            }

            if ($("#unsolvedState option[value='" + this.lastDecision.unresponded_state.slug + "']").length) {
                $("#unrespondedState").val(this.lastDecision.unresponded_state.slug);
            }
            if ($("#unsolvedState option[value='" + this.lastDecision.unsolved_state.slug + "']").length) {
                $("#unsolvedState").val(this.lastDecision.unsolved_state.slug);
            }
            $("#unrespondedState").trigger('change.select2')
            $("#unsolvedState").trigger('change.select2')
        }
    },
    getIncident: function () {
        let $ip = $("#address").val();
        var $data = $("#type option:selected").val() + ($ip ? '/' + $ip : '');
        $.publish('/cert_unlp/incident/search', [$data, $.proxy(this.changeIncidentInfo, this)]);
    },
    changePriorityTimes: function (priority) {
        if (priority) {
            var $calculo = new Date(new Date($("#solveDeadLine").val()).getTime() + priority.unsolve_time * 60000);
            $("#solveDeadLine").val($calculo.toISOString().substring(0, 19));
            var $calculo2 = new Date(new Date($("#responseDeadLine").val()).getTime() + priority.unresponse_time * 60000);
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

