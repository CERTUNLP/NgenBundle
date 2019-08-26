/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var Frontend = Class.extend({
    init: function () {
        this.eventTarget = null;
        $(document).on("click", 'a.state-label', $.proxy(this.changeState, this));
    },
    dropDownChangeLinks: function () {
        if (this.eventTarget.data('action') == "reactivate") {
            this.eventTarget.hide();
            this.eventTarget.siblings("a[data-action='desactivate']").show();
        } else {
            this.eventTarget.hide();
            this.eventTarget.siblings("a[data-action ='reactivate']").show();
        }
    },
    getObjectBrief: function () {
        return 'frontend';
    },
    doChangeState: function (event) {
        if (this.eventTarget.data('action') == 'reactivate') {
            $.publish('/cert_unlp/' + this.getObjectBrief() + '/activate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
        } else {
            if (this.eventTarget.data('action') == 'desactivate') {
                $.publish('/cert_unlp/' + this.getObjectBrief() + '/desactivate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
            }
        }

    },
    changeState: function (event) {
        event.preventDefault();
        this.eventTarget = $(event.currentTarget);
        actionButton = this.eventTarget.parents('div').siblings('button');
        this.laddaButton = Ladda.create(actionButton.get(0));
        if (!this.laddaButton) {
            actionButton = this.eventTarget.parents('ul').siblings('button');
            this.laddaButton = Ladda.create(actionButton.get(0));
        }
        this.laddaButton.start();
        this.doChangeState();
    },

    stateLabelChange: function () {
        label = this.eventTarget.parents('tr').find('span.label');
        label.text(this.eventTarget.data('state-name'));
        label.removeClass().addClass("label badge-" + this.getColorClass());
        $.publish('/cert_unlp/notify/success', ["The state has been changed successfully"]);
    },
    getColorClass: function () {
        if (this.eventTarget.data('state-slug') == "open") {
            return 'info';
        } else {
            if (this.eventTarget.data('state-slug') == "closed" || this.eventTarget.data('state-slug') == "active") {
                return 'success';
            } else {
                return 'danger';
            }
        }
    },
    stateChanged: function (response, jqXHR) {

        if (jqXHR.status > '300') {
            $.publish('/cert_unlp/notify/error', ["The state was not changed. An error occurred."]);
        } else {
            this.stateLabelChange();
            this.dropDownChangeLinks();
        }
        this.laddaButton.stop();
    },
});
