/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var IncidentFeedApi = ApiClient.extend({
    config: function () {
//        this.api.add("networks", {stripTrailingSlash: true});
//        this.api.networks.add("report", {stripTrailingSlash: true});
        $.subscribe('/cert_unlp/incident/feed/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/incident/feed/deactivate', $.proxy(this.deactivate, this));
        $.subscribe('/cert_unlp/incident/feed/new', $.proxy(this.create, this));
        $.subscribe('/cert_unlp/incident/feed/update', $.proxy(this.update, this));
    },
    addDefaultChannel: function () {
        this.api.add("feeds", {stripTrailingSlash: true, url: 'incidents/feeds'});
        this.defaultChannel = this.api.feeds;
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
