/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var IncidentReportApi = ApiClient.extend({
    config: function () {
//        this.api.add("networks", {stripTrailingSlash: true});
//        this.api.networks.add("report", {stripTrailingSlash: true});
        $.subscribe('/cert_unlp/incident/type/report/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/incident/type/report/desactivate', $.proxy(this.desactivate, this));
        $.subscribe('/cert_unlp/incident/type/report/new', $.proxy(this.create, this));
        $.subscribe('/cert_unlp/incident/type/report/update', $.proxy(this.update, this));
    },
    addDefaultChannel: function () {
        this.api.add("types", {stripTrailingSlash: true, url: 'incidents/types'});
        this.api.types.add("reports", {stripTrailingSlash: true});
        this.defaultChannel = this.api.types.reports;
    },
    changeState: function (parent_id, id, isActive, callback) {

        var request = this.defaultChannel.update(parent_id, id + "/" + (isActive ? "activate" : "desactivate"), {}, {apikey: this.apiKey});
        this.doRequest(request, callback);

    },
    activate: function (parent_id, id, callback) {
        this.changeState(parent_id, id, true, callback);
    },
    desactivate: function (parent_id, id, callback) {
        this.changeState(parent_id, id, false, callback);
    },
    create: function (parent_id, data, callback) {
        var request = this.defaultChannel.create(parent_id, data, {apikey: this.apiKey});
        this.doRequest(request, callback);
    },
    update: function (parent_id, id, data, callback) {
        var request = this.defaultChannel.create(parent_id, id, data, {apikey: this.apiKey});
        this.doRequest(request, callback);
    }
});
