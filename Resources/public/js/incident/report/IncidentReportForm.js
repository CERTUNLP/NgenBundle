/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentReportForm = Form.extend({
    config: function (params) {
        this.setIncidentReportId();
        this.setParentObjectId();
        if (params["term"]) {
            $('#type').val(params["term"]);
            $('#type').attr('readOnly', true);
        }
    },
    getObjectBrief: function () {
        return 'incident/type/report';
    },
    getObjectId: function () {
        return this.getIncidentReportId();
    },
    getParentObjectId: function () {
        return this.incident_type_id;
    },
    setParentObjectId: function () {
        this.incident_type_id = (($('#type').val().replace(/ /g, '_'))).toLowerCase();
    },
    setIncidentReportId: function () {
        this.incident_report_id = (($('#lang').val().replace(/ /g, '_'))).toLowerCase();
    },
    getIncidentReportId: function () {
        return this.incident_report_id;
    },
    doRequest: function (event) {
        if (this.form.attr('method') == 'post' && !$('input[name="_method"]').val()) {
            $.publish('/cert_unlp/' + this.getObjectBrief() + '/new', [this.getParentObjectId(), this.getFormData(), $.proxy(this.postRequest, this)]);
        } else {
            $.publish('/cert_unlp/' + this.getObjectBrief() + '/update', [this.getParentObjectId(), this.getObjectId(), this.getFormData(), $.proxy(this.postRequest, this)]);
        }
    }
});

