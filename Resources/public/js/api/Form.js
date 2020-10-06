/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var Form = Class.extend({
        init: function (params) {
            this.setForm();
            this.form.submit($.proxy(this.request, this));
            this.config(params);
            $('select').select2();
        },
        setForm: function () {
            this.form = $('#' + this.getFormId());
        },
        getFormId: function () {
            return 'add_update_form';
        },
        getSubmitButton: function () {
            return $('#' + this.getFormId() + ' :submit');
        },
        getFormData: function () {
            return new FormData(this.form[0]);
        },
        preRequest: function () {
//        event.preventDefault();
            this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
            this.laddaButton.start();
        },
        handleErrors: function (jqXHR) {
            $.publish('/cert_unlp/notify/error', ['The ' + this.getObjectBrief() + ' has errors. Please check the form.']);
            $('#global-errors').remove();
            $('.help-block').parents('div.form-group').removeClass('has-error');
            $('.help-block').remove();
            this.getSubmitButton().addClass('btn-danger');
            // if (jqXHR.responseJSON.hasOwnProperty('message')) {
            //     ul.append($('<li>' + jqXHR.responseJSON.message + '</li>'));
            // }
            if (jqXHR.responseJSON.hasOwnProperty('errors') && jqXHR.responseJSON.errors.hasOwnProperty('global') && jqXHR.responseJSON.errors.global.length) {
                ul = $('<ul></ul>');
                $.each(jqXHR.responseJSON.errors.global, function (n, error) {
                    ul.append($('<li>' + error + '</li>'));
                });
                div = $('<div id="global-errors" class="alert alert-danger col-md-3 offset-10"></div>');
                this.form.before(div.append(ul));
            }
            if (jqXHR.responseJSON.hasOwnProperty('errors')) {
                if (jqXHR.responseJSON.errors.hasOwnProperty('fields')) {

                    $.each(jqXHR.responseJSON.errors.fields, function (k, v) {

                        if (k.length && v.length) {
                            ul = $('<ul class="help-block" ></ul>');
                            ul.append($('<li>' + v + '</li>'));
                            $('#' + k).after(ul);
                            $('#' + k).closest('div[class="form-group"]').addClass('has-error');
                        }
                    });
                }
                this.handleExtraErrors(jqXHR);
            }
        },
        handleExtraErrors: function (jqXHR) {
        },
        clearErrors: function () {
            this.form.children().children().each(function (index) {
                $(this).closest('div[class="form-group has-error"]').removeClass('has-error');
                $(this).children().children('ul').remove();
            });
        }
        ,
        postRequest: function (response, jqXHR) {
            if (jqXHR.status > '300') {
                this.handleErrors(jqXHR);
            } else {
                $.publish('/cert_unlp/notify/success', ['The ' + this.getObjectBrief() + ' was added properly']);
                this.clearErrors();
                this.getSubmitButton().removeClass('btn-danger').addClass('btn-success');
            }
            this.laddaButton.stop();
        }
        ,
        request: function (event) {
            event.preventDefault();
            this.preRequest();
            this.doRequest();
        }
        ,
        doRequest: function (event) {
            if (this.form.attr('method') == 'post' && !$('input[name="_method"]').val()) {
                $.publish('/cert_unlp/' + this.getObjectBrief() + '/new', [this.getFormData(), $.proxy(this.postRequest, this)]);
            } else {
                $.publish('/cert_unlp/' + this.getObjectBrief() + '/update', [this.getObjectId(), this.getFormData(), $.proxy(this.postRequest, this)]);
            }
        },
        slugify: function (string) {
            const a = 'àáäâãåăæçèéëêǵḧìíïîḿńǹñòóöôœṕŕßśșțùúüûǘẃẍÿź·/_,:;';
            const b = 'aaaaaaaaceeeeghiiiimnnnoooooprssstuuuuuwxyz------';
            const p = new RegExp(a.split('').join('|'), 'g');
            return string.toString().toLowerCase()
                .replace(/\s+/g, '_') // Replace spaces with -
                .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
                .replace(/&/g, '-and-') // Replace & with ‘and’
                .replace(/[^\w\-]+/g, '') // Remove all non-word characters
                .replace(/\-\-+/g, '_') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, '')
                .replace(/\-/g, '_')
                ; // Trim - from end of text
        }
    }
);

