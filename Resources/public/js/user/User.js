/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var User = Frontend.extend({
    init: function () {
        this.eventTarget = null;
        $(document).on("click", 'a.state-label', $.proxy(this.changeState, this));
    },
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
            $.publish('/cert_unlp/user/activate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
        } else {
            if (this.eventTarget.data('action') == 'desactivate') {
                $.publish('/cert_unlp/user/desactivate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
            }
        }

    }
});
