var NetworkForm = Class.extend({
    init: function (apiUrl, apiKey) {
        this.form = $('#network_add_update_form');
        this.form.submit($.proxy(this.request, this));
        this.setNetworkId();
    },
    getSubmitButton: function () {
        return $('#network_add_update_form :submit');
    },
    setNetworkId: function () {
        this.networkId = $('#ip').val()+"/"+$('#ipMask').val();
    },
    getNetworkId: function () {
        return  this.networkId;
    },
    getFormData: function () {
        return new FormData(this.form[0]);
    },
    preRequest: function () {
        event.preventDefault();
        this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
        this.laddaButton.start();
    },
    handleErrors: function (jqXHR) {
        this.getSubmitButton().addClass('btn-danger');
        if (jqXHR.responseJSON.length > 1) {
            ul = $('<ul></ul>')
            $.each(jqXHR.responseJSON, function (n, error) {
                ul.append($('<li>' + error.message + '</li>'));
            });
            $.publish('/cert_unlp/notify/error', [ul.html()]);
        } else {
            $.publish('/cert_unlp/notify/error', ['The network has errors. Please check the form.']);
            if (jqXHR.responseJSON.errors) {
                $.each(jqXHR.responseJSON.errors.children, function (k, v) {
                    errorsText = "";
                    if ((v.errors) && (v.errors.length > 0)) {
                        ul = $('<ul class="help-block" ></ul>');
                        $.each(v.errors, function (n, errorText) {
                            ul.append($('<li>' + errorText + '</li>'));
                        });
                        $('#' + k).siblings('ul').remove();
                        $('#' + k).after(ul);
                        $('#' + k).closest('div[class="form-group"]').addClass('has-error');
                    } else {
                        $('#' + k).closest('div[class="form-group has-error"]').removeClass('has-error');
                        $('#' + k).siblings('ul').remove();
                    }
                });
            }
        }
    },
    clearErrors: function () {
        this.form.children().children().each(function (index) {
            $(this).closest('div[class="form-group has-error"]').removeClass('has-error');
            $(this).children().children('ul').remove();
        });
    },
    postRequest: function (response, jqXHR) {
        if (jqXHR.status > '300') {
            this.handleErrors(jqXHR);
        } else {
            $.publish('/cert_unlp/notify/success', ['The network was added properly']);
            this.clearErrors();
            this.getSubmitButton().removeClass('btn-danger').addClass('btn-success');
        }
        this.laddaButton.stop();
    },
    request: function () {
        this.preRequest();
        this.doRequest();
//        this.postRequest();
    },
    doRequest: function (event) {
        if (this.form.attr('method') == 'post' && !$('input[name="_method"]').val()) {
            $.publish('/cert_unlp/network/new', [this.getFormData(), $.proxy(this.postRequest, this)]);
        } else {
            $.publish('/cert_unlp/network/update', [this.getNetworkId(), this.getFormData(), $.proxy(this.postRequest, this)]);
        }
    }
});

