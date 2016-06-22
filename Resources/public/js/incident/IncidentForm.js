/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var IncidentForm = Form.extend({
    config: function (params) {
        this.setIncidentId();
        $("#sendReport").on("change", $.proxy(this.editReportDisable, this));
        $("#type").on("change", $.proxy(this.editReportChangeText, this));
        $("#editReport").on("click", $.proxy(this.editReport, this));
    },
    setIncidentId: function () {
        this.incidentId = $('#hostAddress').val() + "/" + $('#date').val() + "/" + $('#type').val();
    },
    getFormId: function () {
        return 'incident_add_update_form';
    },
    getObjectBrief: function () {
        return 'incident';
    },
    getObjectId: function () {
        return  this.incidentId;
    },
    handleExtraErrors: function () {
    },
    editReportDisable: function (event) {
        $("#editReport").prop("disabled", !event.target.checked);
        $("#reportEdit").addClass('hidden');
        $("#reportEdit").empty();
        $("#reportEdit").parent().siblings().addClass('hidden');
    },
    loadReportEditArea: function (data, response) {
        $("#reportEdit").text(response.responseText);
        initTinyMCE();
        tinymce.activeEditor.on('change', function (ed) {
            $("#reportEdit").val(ed.target.getContent());
        });


    },
    editReportChangeText: function (data, response) {
        if (!$("#reportEdit").hasClass('hidden')) {
            $.publish('/cert_unlp/incident/report/html', [$('#type').val(), function (data, response) {
                    tinymce.activeEditor.setContent(response.responseText);
                }]);
        }
    },
    editReport: function (event) {
        if (!$('#type').val()) {
            $('#type')[0].reportValidity()
        } else {
            if ($("#reportEdit").hasClass('hidden')) {
                $("#reportEdit").removeClass('hidden');
                $("#reportEdit").addClass('tinymce');
                $.publish('/cert_unlp/incident/report/html', [$('#type').val(), $.proxy(this.loadReportEditArea, this)]);
                $("#reportEdit").parent().siblings().removeClass('hidden');
            } else {
                $("#reportEdit").addClass('hidden');
                $("#reportEdit").removeClass('tinymce');
                $("#reportEdit").empty();
                $("#reportEdit").parent().siblings().addClass('hidden');
                $("#reportEdit").siblings().remove();
            }
        }
    },
//    getFormData: function () {
//        return new FormData(this.form[0]);
//    },
//    preRequest: function () {
//        event.preventDefault();
//        tinymce.triggerSave();
//        this.laddaButton = Ladda.create(this.getSubmitButton().get(0));
//        this.laddaButton.start();
//    },
//    handleErrors: function (jqXHR) {
//        this.getSubmitButton().addClass('btn-danger');
//        if (jqXHR.responseJSON.length > 1) {
//            ul = $('<ul></ul>')
//            $.each(jqXHR.responseJSON, function (n, error) {
//                ul.append($('<li>' + error.message + '</li>'));
//            });
//            $.publish('/cert_unlp/notify/error', [ul.html()]);
//        } else {
//            $.publish('/cert_unlp/notify/error', ['The incident has errors. Please check the form.']);
//            if (jqXHR.responseJSON.errors) {
//                $.each(jqXHR.responseJSON.errors.children, function (k, v) {
//                    errorsText = "";
//                    if ((v.errors) && (v.errors.length > 0)) {
//                        ul = $('<ul class="help-block" ></ul>');
//                        $.each(v.errors, function (n, errorText) {
//                            ul.append($('<li>' + errorText + '</li>'));
//                        });
//                        $('#' + k).siblings('ul').remove();
//                        $('#' + k).after(ul);
//                        $('#' + k).closest('div[class="form-group"]').addClass('has-error');
//                    } else {
//                        $('#' + k).closest('div[class="form-group has-error"]').removeClass('has-error');
//                        $('#' + k).siblings('ul').remove();
//                    }
//                });
//            }
//        }
//    },
//    clearErrors: function () {
//        this.form.children().children().each(function (index) {
//            $(this).closest('div[class="form-group has-error"]').removeClass('has-error');
//            $(this).children().children('ul').remove();
//        });
//    },
//    postRequest: function (response, jqXHR) {
//        if (jqXHR.status > '300') {
//            this.handleErrors(jqXHR);
//        } else {
//            $.publish('/cert_unlp/notify/success', ['The incident was added properly']);
//            this.clearErrors();
//            this.getSubmitButton().removeClass('btn-danger').addClass('btn-success');
//        }
//        this.laddaButton.stop();
//    },
//    request: function () {
//        this.preRequest();
//        this.doRequest();
////        this.postRequest();
//    },
//    doRequest: function (event) {
//        if (this.form.attr('method') == 'post' && !$('input[name="_method"]').val()) {
//            $.publish('/cert_unlp/incident/new', [this.getFormData(), $.proxy(this.postRequest, this)]);
//        } else {
//            $.publish('/cert_unlp/incident/update', [this.getIncidentId(), this.getFormData(), $.proxy(this.postRequest, this)]);
//        }
//    }
});

