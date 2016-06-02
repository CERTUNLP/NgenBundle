/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var InternalIncident = Class.extend({
    init: function (apiUrl, apiKey) {
        this.eventTarget = null;
        this.api = new IncidentApi(apiUrl, apiKey);
        this.form = new IncidentForm();
        $("#incident_action_dropdown").delegate("a.state-label", "click", this.dropDownChangeLinks);
        $(".incident-action-dropdown").delegate("a.state-label", "click", $.proxy(this.changeState, this));
    },
    dropDownChangeLinks: function () {
        if (this.eventTarget.data('state-slug') == "open") {
            this.eventTarget.hide();
        } else {
            $("[data-state-slug='open']").show();
        }
    },
    stateLabelChange: function () {
        label = this.eventTarget.parents('tr').children('#state_label_holder').children('div.label-holder').children('span');
        label.text(this.eventTarget.data('state-name'));
        label.removeClass().addClass("label label-" + this.getColorClass());
    },
    changeState: function (event) {
        this.eventTarget = $(event.currentTarget);
        actionButton = this.eventTarget.parents('ul').siblings('button');
        this.laddaButton = Ladda.create(actionButton.get(0));
        this.laddaButton.start();
        $.publish('/cert_unlp/incident/state/change', [this.eventTarget.parents('tr').data('id'), this.eventTarget.data('state-slug'), $.proxy(this.stateChanged, this)]);
    },
    getColorClass: function () {
        if (this.eventTarget.data('state-slug') == "open") {
            return 'info';
        } else {
            if (this.eventTarget.data('state-slug') == "closed") {
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
            $.publish('/cert_unlp/notify/success', ["InternalIncident status has been changed successfully"]);
            this.stateLabelChange();
            this.dropDownChangeLinks();
        }
        this.laddaButton.stop();
    }
});
