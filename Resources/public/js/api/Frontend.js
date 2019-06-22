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
        $('.select-filter').on('change', $.proxy(this.search, this));           ;
        $('.term-filter').on('submit', $.proxy(this.search, this));           ;
        $('.data-filter').on('change', $.proxy(this.search, this));           ;
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
        event.preventDefault();
        this.eventTarget = $(event.currentTarget);
        actionButton = this.eventTarget.parents('ul').siblings('button');
        this.laddaButton = Ladda.create(actionButton.get(0));
        this.laddaButton.start();
        this.doChangeState();
    },
    search: function(event){
        alert("hola");
        query='*';
        $(".select-filter").each(function() {
            if ($(this).val() != null && $(this).val().length > 0){
                query=(query) +' && '+$(this).attr('name')+'.'+$(this).attr('search')+':'+$(this).val();
            }
        });
        $(".multiple-select-filter").each(function() {
            if ($(this).val() != null && $(this).val().length > 0){
                query=(query) +' && '+$(this).attr('name')+'.'+$(this).attr('search')+':'+$(this).val();
            }
        });
        $(".term-filter").each(function() {
            if ($(this).val() != null && $(this).val().length > 0){
                query=(query) +' && '+$(this).attr('name')+'.'+$(this).attr('search')+':'+$(this).val();
            }
        });
        this.query=query;
        this.filterListComplete(this.query);
        return false;


    },

    updateListRow: function(jqXHR){

        id = this.eventTarget.parents('tr').data('id');
        tr=this.eventTarget.parents('tr');
        $.get( id+"/getListRow", function( data ) {
            tr.html($( data ).html());
            $.publish('/cert_unlp/notify/success', ["The state has been changed successfully"]);
            tr.focus();
        });


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
            this.updateListRow(jqXHR);
            this.dropDownChangeLinks();
        }
        this.laddaButton.stop();
    },
    filterListComplete: function(query){
        juan=$('table tbody');
        $.get( "getFilterList",{ "term":query}, function( data ) {
            $('#tabla_incidentes > tbody:last').html(data.tabla);
            $('#incidentcount').html(data.indice.lastItemNumber+"/"+data.indice.totalCount);
            $('#paginatorbar').html(data.paginador);
            $("#paginatorbar").on("click",".pagination", function(){
                $.get(event.target.href, function(data) {
                    $('#tabla_incidentes > tbody:last').html(data.tabla);
                    $('#incidentcount').html(data.indice.lastItemNumber+"/"+data.indice.totalCount);
                    $('#paginatorbar').html(data.paginador);
                });
                return false;
            });
            $.publish('/cert_unlp/notify/success', ["The list was filtered"]);
        });


    },

});
