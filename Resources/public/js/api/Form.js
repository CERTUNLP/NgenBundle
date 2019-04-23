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
            this.getSubmitButton().addClass('btn-danger');
            ul = $('<ul></ul>')
            if (jqXHR.responseJSON.hasOwnProperty('message')) {
                ul.append($('<li>' + jqXHR.responseJSON.message + '</li>'));
            }
            if (jqXHR.responseJSON.errors.hasOwnProperty('global')) {
                ul = $('<ul></ul>')
                $.each(jqXHR.responseJSON.errors.global, function (n, error) {
                    ul.append($('<li>' + error + '</li>'));
                });
            }
            $.publish('/cert_unlp/notify/error', [ul.html()]);
            $.publish('/cert_unlp/notify/error', ['The ' + this.getObjectBrief() + ' has errors. Please check the form.']);
            if (jqXHR.responseJSON.hasOwnProperty('errors')) {
                if (jqXHR.responseJSON.errors.hasOwnProperty('fields')) {

                    $.each(jqXHR.responseJSON.errors.fields, function (k, v) {
                        $('#' + k).closest('div[class="form-group has-error"]').removeClass('has-error');
                        $('#' + k).siblings('ul').remove();
                        if (k.length && v.length) {
                            ul = $('<ul class="help-block" ></ul>');
                            ul.append($('<li>' + v + '</li>'));
                            $('#' + k).siblings('ul').remove();
                            $('#' + k).after(ul);
                            $('#' + k).closest('div[class="form-group"]').addClass('has-error');
                        }
                    });
                    this.handleExtraErrors(jqXHR);
                }
            }
        }
        ,
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
        }
    }
);

