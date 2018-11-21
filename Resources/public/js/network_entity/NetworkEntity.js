/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var NetworkEntity = Frontend.extend({
    dropDownChangeLinks: function () {
        if (this.eventTarget.data('action') == "reactivate") {
            this.eventTarget.hide();
            $("[data-action='desactivate']").show();
        } else {
            this.eventTarget.hide();
            $("[data-action='reactivate']").show();
        }
    },
    doChangeState: function (event) {
        if (this.eventTarget.data('action') == 'reactivate') {
            $.publish('/cert_unlp/network_entity/activate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
        } else {
            if (this.eventTarget.data('action') == 'desactivate') {
                $.publish('/cert_unlp/network_entity/desactivate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
            }
        }

    }
});