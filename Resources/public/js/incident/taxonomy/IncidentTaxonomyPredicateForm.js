/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentTaxonomyPredicateForm = Form.extend({
    config: function () {
        this.setIncidentTaxonomyPredicateId();
    },
    getObjectBrief: function () {
        return 'incident/taxonomy/predicate';
    },
    getObjectId: function () {
        return this.getIncidentTaxonomyPredicateId();
    },
    setIncidentTaxonomyPredicateId: function () {
        this.incident_predicate_id = this.slugify($('#value').val());
    },
    getIncidentTaxonomyPredicateId: function () {
        return this.incident_predicate_id;
    }
});

