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
    },
    changeTLP: function () {
        var $valor = $("#tlp option:selected").text();
        $("#tlp_label").first().html("TLP:" + $valor.toUpperCase());
        $("#tlp_label").attr('class', "tlp-" + $valor.toLowerCase());
    },
    getIncidentDecision: function () {
        ip = $("#ip_v4").val();
        var $id = $("#type option:selected").val() + '/' + $("#feed option:selected").val() + (ip ? '/' + ip : '');
        this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
        this.laddaButton.start();
        $.publish('/cert_unlp/incident/decision/read', [$id, $.proxy(this.changeDefaults, this)]);
        this.laddaButton.stop();

    },
    changeDefaults: function (response) {
        if (Object.keys(response).length) {
            $("#tlp").val(response.responseJSON.tlp.slug);
            $("#state").val(response.responseJSON.state.slug);
            $("#impact").val(response.responseJSON.impact.slug);
            $("#urgency").val(response.responseJSON.urgency.slug);
        }
    },
    setIncidentId: function () {
        this.incidentId = $('#slug').val();
    },
    getObjectBrief: function () {
        return 'incident';
    },
    getObjectId: function () {
        return this.incidentId;
    },
    handleExtraErrors: function () {
    },
});

