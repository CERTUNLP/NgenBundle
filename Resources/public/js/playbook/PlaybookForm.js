/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var PlaybookForm = Form.extend({
    config: function () {
        this.setPlaybookId();
    },
    getObjectBrief: function () {
        return 'playbook';
    },
    getObjectId: function () {
        return this.getPlaybookId();
    },
    setPlaybookId: function () {
        this.playbook_id = $('#id').val();
    },
    getPlaybookId: function () {
        return this.playbook_id;
    },
});

