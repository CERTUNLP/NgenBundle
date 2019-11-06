/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var NetworkEntityApi = ApiClient.extend({
    config: function () {
//        this.api.add("networks", {stripTrailingSlash: true});
//        this.api.networks.add("report", {stripTrailingSlash: true});
        $.subscribe('/cert_unlp/network/entity/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/network/entity/desactivate', $.proxy(this.desactivate, this));
        $.subscribe('/cert_unlp/network/entity/new', $.proxy(this.create, this));
        $.subscribe('/cert_unlp/network/entity/update', $.proxy(this.update, this));
    },
    addDefaultChannel: function () {
        this.api.add("entities", {stripTrailingSlash: true, url: 'networks/entities'});
        this.defaultChannel = this.api.entities;
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
