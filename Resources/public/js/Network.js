var Network = Class.extend({
    init: function (apiUrl, apiKey) {
        this.eventTarget = null;
        this.api = new NetworkApi(apiUrl, apiKey);
        this.form = new NetworkForm();
//        $("#network_action_dropdown").delegate("a.state-label", "click", this.dropDownChangeLinks);
        $(".network-action-dropdown").delegate("a.state-label", "click", $.proxy(this.changeState, this));
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
        if (this.eventTarget.data('action') == 'reactivate') {
            $.publish('/cert_unlp/network/activate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
        }
        else {
            if (this.eventTarget.data('action') == 'desactivate') {
                $.publish('/cert_unlp/network/desactivate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
            }
        }

    },
    getColorClass: function () {
        if (this.eventTarget.data('state-name') == "active") {
            return 'success';
        } else {
            return 'danger';
        }

    },
    stateChanged: function (response, jqXHR) {

        if (jqXHR.status > '300') {
            $.publish('/cert_unlp/notify/error', ["The state was not changed. An error occurred."]);
        } else {
            $.publish('/cert_unlp/notify/success', ["Network status has been changed successfully"]);
            this.stateLabelChange();
            this.dropDownChangeLinks();
        }
        this.laddaButton.stop();
    }
});
