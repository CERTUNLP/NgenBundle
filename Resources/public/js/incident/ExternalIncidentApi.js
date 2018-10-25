/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var ExternalIncidentApi = IncidentApi.extend({
    addDefaultChannel: function () {
        this.api.add("externals", {stripTrailingSlash: true, url: "incidents/externals"});
        this.defaultChannel = this.api.externals;
    }
});
