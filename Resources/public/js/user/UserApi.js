/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var UserApi = ApiClient.extend({
    config: function () {
//        this.api.add("users", {stripTrailingSlash: true});
//        this.api.users.add("report", {stripTrailingSlash: true});
        $.subscribe('/cert_unlp/user/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/user/deactivate', $.proxy(this.deactivate, this));
        $.subscribe('/cert_unlp/user/new', $.proxy(this.create, this));
        $.subscribe('/cert_unlp/user/update', $.proxy(this.update, this));
    },
    addDefaultChannel: function () {
        this.api.add("users", {stripTrailingSlash: true});
        this.defaultChannel = this.api.users;
    },
    changeState: function (userId, isActive, callback) {

        var request = this.defaultChannel.update(userId + "/" + (isActive ? "activate" : "deactivate"), {}, {apikey: this.apiKey});
        this.doRequest(request, callback);

    },
    activate: function (userId, callback) {
        this.changeState(userId, true, callback);
    },
    deactivate: function (userId, callback) {
        this.changeState(userId, false, callback);

    },
});
