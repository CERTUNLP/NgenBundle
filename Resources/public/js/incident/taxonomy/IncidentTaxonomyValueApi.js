/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var IncidentTaxonomyValueApi = ApiClient.extend({
    config: function () {
        $.subscribe('/cert_unlp/incident/taxonomy/value/update', $.proxy(this.update, this));
        $.subscribe('/cert_unlp/incident/taxonomy/value/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/incident/taxonomy/value/deactivate', $.proxy(this.deactivate, this));
    },
    addDefaultChannel: function () {
        this.api.add("values", {stripTrailingSlash: true, url: 'incidents/taxonomies/values'});
        this.defaultChannel = this.api.values;
    },
    changeState: function (networkId, isActive, callback) {

        var request = this.defaultChannel.update(networkId + "/" + (isActive ? "activate" : "deactivate"), {}, {apikey: this.apiKey});
        this.doRequest(request, callback);

    },
    activate: function (networkId, callback) {
        this.changeState(networkId, true, callback);
    },
    deactivate: function (networkId, callback) {
        this.changeState(networkId, false, callback);

    },
});
