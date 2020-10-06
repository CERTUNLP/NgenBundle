/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentTaxonomyValueForm = Form.extend({
    config: function () {
        this.setIncidentTaxonomyValueId();
    },
    getObjectBrief: function () {
        return 'incident/taxonomy/value';
    },
    getObjectId: function () {
        return this.getIncidentTaxonomyValueId();
    },
    setIncidentTaxonomyValueId: function () {
        this.incident_value_id = this.slugify($('#value').val());
    },
    getIncidentTaxonomyValueId: function () {
        return this.incident_value_id;
    }
});

