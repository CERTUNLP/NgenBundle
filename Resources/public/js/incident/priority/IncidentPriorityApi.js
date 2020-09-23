/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var IncidentPriorityApi = ApiClient.extend({
    config: function () {
//        this.api.add("networks", {stripTrailingSlash: true});
//        this.api.networks.add("report", {stripTrailingSlash: true});
        $.subscribe('/cert_unlp/incident/priority/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/incident/priority/deactivate', $.proxy(this.deactivate, this));
        $.subscribe('/cert_unlp/incident/priority/new', $.proxy(this.create, this));
        $.subscribe('/cert_unlp/incident/priority/update', $.proxy(this.update, this));
    },
    addDefaultChannel: function () {
        this.api.add("priorities", {stripTrailingSlash: true, url: 'incidents/priorities'});
        this.defaultChannel = this.api.priorities;
    },
    changeState: function (priorityId, isActive, callback) {

        var request = this.defaultChannel.update(priorityId + "/" + (isActive ? "activate" : "deactivate"), {}, {apikey: this.apiKey});
        this.doRequest(request, callback);

    },
    activate: function (priorityId, callback) {
        this.changeState(priorityId, true, callback);
    },
    deactivate: function (priorityId, callback) {
        this.changeState(priorityId, false, callback);

    },
});
