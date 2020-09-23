/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentReport = Frontend.extend({
    getObjectBrief: function () {
        return 'incident/type/report';
    },
    doChangeState: function (event) {
        if (this.eventTarget.data('action') == 'reactivate') {
            $.publish('/cert_unlp/incident/type/report/activate', [this.eventTarget.parents('tr').data('parent_id'), this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
        } else {
            if (this.eventTarget.data('action') == 'deactivate') {
                $.publish('/cert_unlp/incident/type/report/deactivate', [this.eventTarget.parents('tr').data('parent_id'), this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
            }
        }
    }
});