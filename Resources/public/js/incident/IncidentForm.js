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
    changeDefaults: function (response) {
        if (Object.keys(response).length) {
            $("#tlp").val(response.responseJSON.tlp.slug).trigger('change');
            $("#state").val(response.responseJSON.state.slug).trigger('change');
            $("#impact").val(response.responseJSON.impact.slug).trigger('change');
            $("#urgency").val(response.responseJSON.urgency.slug).trigger('change');
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
    }
});

