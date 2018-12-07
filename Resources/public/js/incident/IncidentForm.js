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
        $("#type").on("change", $.proxy(this.changeDefaults, this));
        $("#feed").on("change", $.proxy(this.changeDefaults, this));
    },
    changeTLP: function () {
        var $valor = $("#tlp option:selected").text();
        $("#tlp_label").first().html("TLP:" + $valor.toUpperCase());
        $("#tlp_label").attr('class', "tlp-" + $valor.toLowerCase());
    },
    changeDefaults: function () {
        var $valor = $("#tlp option:selected").text();
        var $type = $("#type option:selected").text();
        var $feed = $("#feed option:selected").text();
        $("#tlp_label").first().html("TLP:" + $valor.toUpperCase());
        $("#tlp_label").attr('class', "tlp-" + $valor.toLowerCase());
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

