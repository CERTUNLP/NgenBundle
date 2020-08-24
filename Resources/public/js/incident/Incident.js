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
        // $('.form-check-input').on('change', $.proxy(this.search, this));
        $('.select-filter').on('change', $.proxy(this.search, this));
        $('.multiple-select-filter').on('blur', $.proxy(this.search, this));
        $('.data-filter').on('submit', $.proxy(this.search, this));
        $('.message-set-pending').on('click', $.proxy(this.messagePending, this));
        $('#generalSearch').on('submit', $.proxy(this.search, this));
        $(document).on("click", 'a.colorbox-filter', $.proxy(this.filterListDropdown, this));
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
        $.get(id + "/getListRow", function (data) {
            tr.html($(data).html());
            $.publish('/cert_unlp/notify/success', ["The state has been changed successfully"]);
            tr.focus();
        });
    },
    messagePending: function (event) {
        id = $(event.currentTarget).data('id');
        $.post("/messages/" + id + '/pending', function () {
            $(event.currentTarget).siblings('.d-none').removeClass('d-none')
            $(event.currentTarget).toggle()
            $(event.currentTarget).parents('.card').first().children('h6').removeClass('border-left-success')
            $(event.currentTarget).parents('.card').first().children('h6').addClass('border-left-warning')
            $.publish('/cert_unlp/notify/success', ["Message scheduled"]);
        });
    },
    filterListDropdown: function (event) {
        event.preventDefault();
        let $th = $('.filtrosMostrar').find('th').eq($(event.currentTarget).parents('td').index());
        let $input;
        let $event;
        if ($th.find('select').length) {
            $input = $th.find('select');
            $event = 'change';
        } else {
            $input = $th.find('input');
            if ($input.hasClass('multiple-select-filter')) {
                $event = 'blur';
            } else {
                $event = 'change';
            }
        }
        $input.val($(event.currentTarget).data('id'));
        $input.trigger($event);

    },
    filterListComplete: function (query) {
        $.get("getFilterList", {"term": query}, function (data) {
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

            $.publish('/cert_unlp/notify/success', ["The list was filtered"]);
        });
    },
    search: function (event) {
        event.preventDefault();
        query = '*';
        self = this;
        $(".multiple-select-filter").each(function () {
            if ($(this).val() != null && $(this).val().length > 0) {
                subquery = '(';
                parametros = JSON.parse($(this).attr('search'));
                valor = self.sanitize($(this).val());
                if ($(this).parent().parent().children('.form-check-input')[0] != null && $(this).parent().parent().children('.form-check-input')[0].checked) {
                    // valor = valor + '*';
                }
                if ($(this).attr('index') != null && $(this).attr('index').length > 0) {
                    name = $(this).attr('index');
                } else {
                    name = $(this).attr('name');
                }
                parametros.forEach(function (element, index) {
                    if (index == 0) {
                        subquery = subquery + name + '.' + element + ':' + valor;
                    } else {
                        subquery = subquery + ' || ' + name + '.' + element + ':' + valor;
                    }
                });
                query = (query) + ' && ' + subquery + ')';
            }
        });
        $(".select-filter").each(function () {
            if ($(this).attr('index') != null && $(this).attr('index').length > 0) {
                name = $(this).attr('index');
            } else {
                name = $(this).attr('name');
            }
            if ($(this).val() != null && $(this).val() != 0 && $(this).val().length > 0) {
                valor = self.sanitize($(this).val());
                if ($(this).parent().parent().children('.form-check-input')[0] != null && $(this).parent().parent().children('.form-check-input')[0].checked) {
                    // valor = valor + '*';
                }
                // if ($(this).attr('search') != null && $(this).attr('search').length > 0) {
                //     query = (query) + ' && ' + name + '.' + $(this).attr('search') + ':' + valor;
                // } else {
                query = (query) + ' && ' + name + ':' + valor;
                // }
            }
        });

        $("#generalSearch").each(function () {
            if ($(this).find('input[name="term"]').val() != null && $(this).find('input[name="term"]').val().length > 0) {
                valor = self.sanitize($(this).find('input[name="term"]').val());
                name = 'term';
                query = (query) + ' && ' + valor;

            }
        });
        this.query = query;
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