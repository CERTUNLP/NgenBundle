/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var PlaybookApi = ApiClient.extend({
    config: function () {
        $.subscribe('/cert_unlp/playbook/new', $.proxy(this.create, this));
    },
    addDefaultChannel: function () {
        this.api.add("predicates", { stripTrailingSlash: true, url: 'playbooks' });
        this.defaultChannel = this.api.predicates;
    },
    changeState: function (networkId, isActive, callback) {
        var request = this.defaultChannel.update(networkId + "/" + (isActive ? "activate" : "deactivate"), {}, { apikey: this.apiKey });
        this.doRequest(request, callback);
    },
    activate: function (networkId, callback) {
        this.changeState(networkId, true, callback);
    },
    deactivate: function (networkId, callback) {
        this.changeState(networkId, false, callback);
    },
});
