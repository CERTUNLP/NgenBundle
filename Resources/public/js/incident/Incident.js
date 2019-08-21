/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var Incident = Frontend.extend({
    init: function () {
        this.eventTarget = null;
        $(document).on("click", 'a.state-label', $.proxy(this.changeState, this));
        $('.form-check-input').on('change', $.proxy(this.search, this));
        $('.select-filter').on('change', $.proxy(this.search, this));
        $('.multiple-select-filter').on('blur', $.proxy(this.search, this));
        $('.data-filter').on('submit', $.proxy(this.search, this));
        $('.generalSearch').on('submit', $.proxy(this.search, this));
    },
    dropDownChangeLinks: function () {
        if (this.eventTarget.data('state-slug') == "open") {
            this.eventTarget.hide();
        } else {
            $("[data-state-slug='open']").show();
        }
    },
    doChangeState: function (event) {
        $.publish('/cert_unlp/incident/state/change', [this.eventTarget.parents('tr').data('id'), this.eventTarget.data('state-slug'), $.proxy(this.stateChanged, this)]);

    },
    stateChanged: function (response, jqXHR) {

        if (jqXHR.status > '300') {
            $.publish('/cert_unlp/notify/error', ["The state was not changed. An error occurred."]);
        } else {
            this.updateListRow(jqXHR);
            this.dropDownChangeLinks();
        }
        this.laddaButton.stop();
    },
});