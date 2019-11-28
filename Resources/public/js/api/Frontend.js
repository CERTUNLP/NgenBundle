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
        $(document).on("click", 'a.status-box', $.proxy(this.changeState, this));
        $(document).on("click", 'a.colorbox-filter', $.proxy(this.filterList, this));
        this.search_terms = $('#generalSearch').find('input').val().split(' && ');
        this.search_terms.forEach(function (a) {
            $('[data-id="' + a.split(': ')[1] + '"]').find('i').each(function (b, a) {
                $(a).toggleClass('fas fa-filter').toggleClass('fas fa-backspace');
            })
        })
        ;

    },
    filterList: function (event) {
        event.preventDefault();
        let $generalSearch = $('#generalSearch');
        let $input = $generalSearch.find('input');
        let $th = $('table').find('th').eq($(event.currentTarget).parents('td').index());
        let $key = $th.text().toLowerCase().trim();
        let $value = $(event.currentTarget).data('id').toString();
        let $array_filtered;
        if ($input.val().indexOf($key + ': ') < 0) {
            if ($value.indexOf(' ') > 0) {
                $value = '"' + $value + '"'
            }
            if ($input.val() !== '*') {
                $input.val($input.val() + ' && ' + $key + ': ' + $value);
            } else {
                $input.val($key + ': ' + $value);
            }
        } else {

            $array_filtered =  this.search_terms.filter(function (elem) {
                return !elem.startsWith($key)
            });
            $input.val($array_filtered.join(' && '))
        }
        $generalSearch.trigger('submit');

    },
    getObjectBrief: function () {
        return 'frontend';
    },
    startLaddaButton: function () {
        this.laddaButton = Ladda.create(this.eventTarget.parents('td').find('.ladda-button').get(0));
        this.laddaButton.start();
    },
    changeState: function (event) {
        event.preventDefault();
        this.eventTarget = $(event.currentTarget);
        this.startLaddaButton();
        this.doChangeState();
    },
    doChangeState: function (event) {
        if (this.eventTarget.data('action') === 'reactivate') {
            $.publish('/cert_unlp/' + this.getObjectBrief() + '/activate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
        } else {
            if (this.eventTarget.data('action') === 'desactivate') {
                $.publish('/cert_unlp/' + this.getObjectBrief() + '/desactivate', [this.eventTarget.parents('tr').data('id'), $.proxy(this.stateChanged, this)]);
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
    stateLabelChange: function () {
        let label = this.eventTarget.parents('tr').find('td#state_label_holder').find('button');
        label.find('span.icon').find('span').toggleClass('fa fa-toggle-on').toggleClass('fa fa-toggle-off');
        label.find('span.text').text().trim() === 'active' ? label.find('span.text').text('not active') : label.find('span.text').text('active');
        this.eventTarget.data('action').trim() === 'reactivate' ? label.data('action', 'desactivate') : label.data('action', 'reactivate');
        label.toggleClass("btn btn-icon-split btn-sm btn-success").toggleClass("btn btn-icon-split btn-sm btn-danger");
        this.eventTarget.parent().find('i').parent().toggleClass("text-success").toggleClass("text-danger");
        $.publish('/cert_unlp/notify/success', ["The state has been changed successfully"]);
    },
    dropDownChangeLinks: function () {
        let dropdown = this.eventTarget.parents('tr').find('a.state-label');
        dropdown.first().toggle();
        dropdown.last().toggle();
    },
    getColorClass: function () {
        if (this.eventTarget.data('state-slug') === "open") {
            return 'info';
        } else {
            if (this.eventTarget.data('state-slug') === "closed" || this.eventTarget.data('state-slug') === "active") {
                return 'success';
            } else {
                return 'danger';
            }
        }
    },
});
