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
var NetworkApi = Class.extend({
    init: function (apiUrl, apiKey) {
        this.apiKey = apiKey;
        this.apiUrl = apiUrl;
        this.api = new $.RestClient(apiUrl, {verbs: {
                'create': 'POST',
                'read': 'GET',
                'update': 'PATCH',
                'destroy': 'DELETE'
            }});
        this.api.add("networks", {stripTrailingSlash: true});
//        this.api.networks.add("report", {stripTrailingSlash: true});
        $.subscribe('/cert_unlp/network/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/network/desactivate', $.proxy(this.desactivate, this));
        $.subscribe('/cert_unlp/network/new', $.proxy(this.create, this));
        $.subscribe('/cert_unlp/network/update', $.proxy(this.update, this));


    },
    changeState: function (networkId, isActive, callback) {

        var request = this.api.networks.update(networkId + "/" + (isActive ? "activate" : "desactivate"), {}, {apikey: this.apiKey});
        this.doRequest(request, callback);

    },
    activate: function (networkId, callback) {
        this.changeState(networkId, true, callback);
    },
    desactivate: function (networkId, callback) {
        this.changeState(networkId, false, callback);

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
    create: function (data, callback) {
        var request = this.api.networks.create(data, {apikey: this.apiKey});
        this.doRequest(request, callback);
    },
    update: function (networkId, data, callback) {
        var request = this.api.networks.create(networkId, data, {apikey: this.apiKey});
        this.doRequest(request, callback);
    }
});
