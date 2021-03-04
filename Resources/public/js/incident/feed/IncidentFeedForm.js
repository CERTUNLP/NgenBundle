/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentFeedForm = Form.extend({
    config: function () {
        this.setIncidentFeedId();
    },
    getObjectBrief: function () {
        return 'incident/feed';
    },
    getObjectId: function () {
        return this.getIncidentFeedId();
    },
    setIncidentFeedId: function () {
        this.incident_feed_id = this.slugify($('#name').val());
    },
    getIncidentFeedId: function () {
        return this.incident_feed_id;
    }
});

