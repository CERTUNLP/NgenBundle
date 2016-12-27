/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var ApiClient = Class.extend({
    init: function (apiUrl, apiKey) {
        this.apiKey = apiKey;
        this.apiUrl = apiUrl;
        this.api = new $.RestClient(apiUrl, {verbs: {
                'create': 'POST',
                'read': 'GET',
                'update': 'PATCH',
                'destroy': 'DELETE'
            }});
        this.addDefaultChannel();
        this.config();
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
    getResponse: function (jqXHR) {
        if (jqXHR.status >= 200 && jqXHR.status < 300) {
            return jqXHR;
        }
        return {};

    },
    create: function (data, callback) {
        var request = this.defaultChannel.create(data, {apikey: this.apiKey});
        this.doRequest(request, callback);
    },
    update: function (id, data, callback) {
        var request = this.defaultChannel.create(id, data, {apikey: this.apiKey});
        this.doRequest(request, callback);
    }

});


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