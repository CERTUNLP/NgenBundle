/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var Incident = Frontend.extend({
    init: function (base_url) {
        this.base_url = base_url;
        this.eventTarget = null;
        this.search_terms = new SearchTerm();
        $(document).on("click", 'a.state-label', $.proxy(this.changeState, this));
        $('.select-filter').on('change', $.proxy(this.filterListHeaders, this));
        $('.multiple-select-filter').on('blur', $.proxy(this.filterListHeaders, this));
        $('.data-filter').on('submit', $.proxy(this.filterListHeaders, this));
        $('#generalSearch').on('submit', $.proxy(this.search, this));
        $(document).on("click", 'a.colorbox-filter', $.proxy(this.filterListDropdown, this));
        this.search();
    },
    getObjectBrief: function () {
        return 'incident';
    },
    dropDownChangeLinks: function () {

    },
    doChangeState: function (event) {
        $.publish('/cert_unlp/incident/state/change', [this.eventTarget.parents('tr').data('id'), this.eventTarget.data('state-slug'), $.proxy(this.stateChanged, this)]);

    },
    stateLabelChange: function (response, jqXHR) {
        this.updateListRow(jqXHR);
    },
    updateListRow: function (jqXHR) {

        id = this.eventTarget.parents('tr').data('id');
        tr = this.eventTarget.parents('tr');
        $.get(this.base_url + id + "/getListRow", function (data) {
            tr.html($(data).html());
            $.publish('/cert_unlp/notify/success', ["The state has been changed successfully"]);
            tr.focus();
        });
    },
    filterListDropdown: function (event) {
        event.preventDefault();
        let $th = $('.filtrosMostrar').find('th').eq($(event.currentTarget).parents('td').index());
        let $input;
        if ($th.find('select').length) {
            $input = $th.find('select');
        } else {
            $input = $th.find('input');
        }
        $input.val($(event.currentTarget).data('id'));
        $input.data('id', $(event.currentTarget).data('id'));
        this.search_terms.filterList(event);

    },
    filterListHeaders: function (event) {
        event.preventDefault();
        if ($(event.currentTarget).val()) {
            $(event.currentTarget).data('id', $(event.currentTarget).val());
        } else {
            $(event.currentTarget).data('id', '');
            $(event.currentTarget).data('action', 'delete');
        }
        this.search_terms.filterList(event);

    },
    filterListComplete: function (query) {
        $.get(this.base_url + "getFilterList", {"term": query}, function (data) {
            $('#tabla_incidentes > tbody:last').html(data.tabla);
            $('#incidentcount').html(data.indice.lastItemNumber + "/" + data.indice.totalCount);
            $('#filters').html(data.filters);
            $('#paginatorbar').html(data.paginador);
            $("#paginatorbar").on("click", ".pagination", function () {
                $.get(event.target.href, function (data) {
                    $('#tabla_incidentes > tbody:last').html(data.tabla);
                    $('#incidentcount').html(data.indice.lastItemNumber + "/" + data.indice.totalCount);
                    $('#paginatorbar').html(data.paginador);
                    $('#filters').html(data.filters);
                });
                return false;
            });
            $("#filters").on("click", ".header", function () {
                $.get(event.target.href, function (data) {
                    $('#tabla_incidentes > tbody:last').html(data.tabla);
                    $('#incidentcount').html(data.indice.lastItemNumber + "/" + data.indice.totalCount);
                    $('#paginatorbar').html(data.paginador);
                    $('#filters').html(data.filters);
                });
                return false;
            });

            $.publish('/cert_unlp/incident/updatelist');
            $.publish('/cert_unlp/notify/success', ["The list was filtered"]);
        });
    },
    search: function () {
        self = this;
        this.query = this.search_terms.getQuery() ? this.search_terms.getQuery() : '*';
        this.filterListComplete(this.query);
        return false;
    },
    sanitize: function ($value) {
        if ($value.indexOf(' ') > 0) {
            $value = '"' + $value + '"'
        }
        if ($value.indexOf('/') > 0) {
            $value = $value.replace(/\//g, '\\\/');
        }
        return $value;
    },
});