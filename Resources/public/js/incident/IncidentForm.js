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
        $("#tlp_state").on("change", $.proxy(this.changeTLP, this));
        $("#type").on("change", $.proxy(this.changeDefaults, this));
        $("#feed").on("change", $.proxy(this.changeDefaults, this));
    },
    changeTLP: function (){
        var $type=$("#state option:selected").text()
        var $feed=$("#type option:selected").text()
        $.get
        $("#tlp").first().html("TLP:"+$valor.toUpperCase());
        $("#tlp").attr('class',"tlp-"+$valor);
    },
    changeDefaults: function (){
        var $type=$("#tlp_state option:selected").text()
        $("#tlp").first().html("TLP:"+$valor.toUpperCase());
        $("#tlp").attr('class',"tlp-"+$valor);
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

