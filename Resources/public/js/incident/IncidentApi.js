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
        $.subscribe('/cert_unlp/incident/state/change', $.proxy(this.changeState, this));
        $.subscribe('/cert_unlp/incident/new', $.proxy(this.create, this));
        $.subscribe('/cert_unlp/incident/update', $.proxy(this.update, this));
        $.subscribe('/cert_unlp/incident/report/html', $.proxy(this.getReportHtml, this));
    },
    getReportHtml: function (state, callback) {
        var request = this.defaultChannel.report.read(state, 'html.html', {}, {apikey: this.apiKey});
        this.doRequest(request, callback);
    },
    changeState: function (incidentId, state, callback) {
        var request = this.defaultChannel.states.update(incidentId, state, {}, {apikey: this.apiKey});
        this.doRequest(request, callback);
    },
});
