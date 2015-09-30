$.fn.serializeObject = function ()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
var IncidentApi = Class.extend({
    init: function (apiUrl, apiKey) {
        this.apiKey = apiKey;
        this.apiUrl = apiUrl;
        this.api = new $.RestClient(apiUrl, {verbs: {
                'create': 'POST',
                'read': 'GET',
                'update': 'PATCH',
                'destroy': 'DELETE'
            }});
        this.api.add("incidents", {stripTrailingSlash: true}).add("states", {stripTrailingSlash: true});
        this.api.incidents.add("report", {stripTrailingSlash: true});
        $.subscribe('/cert_unlp/incident/state/change', $.proxy(this.changeState, this));
        $.subscribe('/cert_unlp/incident/new', $.proxy(this.addIncident, this));
        $.subscribe('/cert_unlp/incident/update', $.proxy(this.updateIncident, this));
        $.subscribe('/cert_unlp/incident/report/html', $.proxy(this.getReportHtml, this));


    },
    getReportHtml: function (state, callback) {
        var request = this.api.incidents.report.read(state, 'html.html', {}, {apikey: this.apiKey});
        this.doRequest(request, callback);
    },
    changeState: function (incidentId, state, callback) {
        var request = this.api.incidents.states.update(incidentId, state, {}, {apikey: this.apiKey});
        this.doRequest(request, callback);

    },
    getResponse: function (jqXHR) {
        if (jqXHR.status >= 200 && jqXHR.status < 300) {
            if (jqXHR.getResponseHeader('location')) {
                var parameters = (jqXHR.getResponseHeader('location').split("/").slice((jqXHR.getResponseHeader('location').split("/").length - 3), jqXHR.getResponseHeader('location').split("/").length));
                return {hostAddress: parameters[0], date: parameters[1], state: parameters[2]};
            }
        }
        return {};

    },
    doRequest: function (request, callback) {
        request.done($.proxy(function (data, text, jqXHR)
        {
            callback(this.getResponse(jqXHR), jqXHR);
        }, this)).fail($.proxy(function (jqXHR)
        {
            callback(this.getResponse(jqXHR), jqXHR);
        }, this));
    },
    addIncident: function (data, callback) {
        var request = this.api.incidents.create(data, {apikey: this.apiKey});
        this.doRequest(request, callback);
    },
    updateIncident: function (incidentId, data, callback) {
        var request = this.api.incidents.create(incidentId, data, {apikey: this.apiKey});
        this.doRequest(request, callback);
    }
});
