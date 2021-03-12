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
        this.api.add("predicates", {stripTrailingSlash: true, url: 'playbooks'});
        this.defaultChannel = this.api.predicates;
    },
    changeState: function (PlaybookId, isActive, callback) {
        var request = this.defaultChannel.update(PlaybookId + "/" + (isActive ? "activate" : "deactivate"), {}, {apikey: this.apiKey});
        this.doRequest(request, callback);
    },
    activate: function (PlaybookId, callback) {
        this.changeState(PlaybookId, true, callback);
    },
    deactivate: function (PlaybookId, callback) {
        this.changeState(PlaybookId, false, callback);
    },
});
