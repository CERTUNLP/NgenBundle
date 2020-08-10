/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentApi = ApiClient.extend({
    config: function () {
//        this.api.add("incidents", {isSingle: true, stripTrailingSlash: true})
//        this.defaultChannel = this.api.incidents;
        this.defaultChannel.add("states", {stripTrailingSlash: true});
        this.defaultChannel.add("report", {stripTrailingSlash: true});
        this.api.add("incidentSearch", {stripTrailingSlash: true, url: 'incidents/search'});
        this.api.add("priorities", {stripTrailingSlash: true, url: 'incidents/priorities'});
        $.subscribe('/cert_unlp/incident/state/change', $.proxy(this.changeState, this));
        $.subscribe('/cert_unlp/incident/new', $.proxy(this.create, this))
        $.subscribe('/cert_unlp/incident/search', $.proxy(this.searchIncident, this));
        $.subscribe('/cert_unlp/incident/update', $.proxy(this.update, this));
        $.subscribe('/cert_unlp/incident/priority/read', $.proxy(this.searchPriority, this));

        //Esto es para la busqueda por api
        // this.api.add("ajaxsearch", {url: 'incidents/search',stripTrailingSlash: true});
        // $.subscribe('/cert_unlp/incident/search', $.proxy(this.search, this));

    },
    changeState: function (incidentId, state, callback) {
        var request = this.defaultChannel.states.update(incidentId, state);

        this.doRequest(request, callback);
    },
    addDefaultChannel: function () {
        this.api.add("incidents", {stripTrailingSlash: true})
        this.defaultChannel = this.api.incidents;
    },
    searchPriority: function (priorityId, callback) {

        var request = this.api.priorities.read(priorityId);
        this.doRequest(request, callback);
    },
    searchIncident: function (data, callback) {

        var request = this.api.incidentSearch.read(data);
        this.doRequest(request, callback);
    }

});
