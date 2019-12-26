/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var IncidentTaxonomyPredicateApi = ApiClient.extend({
    config: function () {
        $.subscribe('/cert_unlp/incident/taxonomy/predicate/update', $.proxy(this.update, this));
        $.subscribe('/cert_unlp/incident/taxonomy/predicate/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/incident/taxonomy/predicate/desactivate', $.proxy(this.desactivate, this));
    },
    addDefaultChannel: function () {
        this.api.add("predicates", {stripTrailingSlash: true, url: 'incidents/taxonomies/predicates'});
        this.defaultChannel = this.api.predicates;
    },
    changeState: function (networkId, isActive, callback) {

        var request = this.defaultChannel.update(networkId + "/" + (isActive ? "activate" : "desactivate"), {}, {apikey: this.apiKey});
        this.doRequest(request, callback);

    },
    activate: function (networkId, callback) {
        this.changeState(networkId, true, callback);
    },
    desactivate: function (networkId, callback) {
        this.changeState(networkId, false, callback);

    },
});
