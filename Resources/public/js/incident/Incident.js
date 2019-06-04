/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var Incident = Frontend.extend({
    dropDownChangeLinks: function () {
        if (this.eventTarget.data('state-slug') == "open") {
            this.eventTarget.hide();
        } else {
            $("[data-state-slug='open']").show();
        }
    },
    doChangeState: function (event) {

        $.publish('/cert_unlp/incident/state/change', [this.eventTarget.parents('tr').data('id'), this.eventTarget.data('state-slug'), $.proxy(this.stateChanged, this)]);

    }
});
