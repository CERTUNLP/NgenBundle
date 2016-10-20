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
        $(".action-dropdown").delegate("a.state-label", "click", $.proxy(this.changeState, this));
        this.addEventBinds();

    },
    addEventBinds: function () {
    },
    dropDownChangeLinks: function () {
        if (this.eventTarget.data('state-slug') == "open") {
            this.eventTarget.hide();
        } else {
            $("[data-state-slug='open']").show();
        }
    },
    changeState: function (event) {
        this.eventTarget = $(event.currentTarget);
        actionButton = this.eventTarget.parents('ul').siblings('button');
        this.laddaButton = Ladda.create(actionButton.get(0));
        this.laddaButton.start();
        this.doChangeState();
    },
    stateLabelChange: function () {
        label = this.eventTarget.parents('tr').children('#state_label_holder').children('div.label-holder').children('span');
        label.text(this.eventTarget.data('state-name'));
        label.removeClass().addClass("label label-" + this.getColorClass());
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
            $.publish('/cert_unlp/notify/success', ["The state has been changed successfully"]);
            this.stateLabelChange();
            this.dropDownChangeLinks();
        }
        this.laddaButton.stop();
    }
});
