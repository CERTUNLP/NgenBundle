/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var NetworkEntityForm = Form.extend({
    config: function () {
        this.setNetworkEntityId();
    },
    getObjectBrief: function () {
        return 'network_entity';
    },
    getObjectId: function () {
        return this.getNetworkEntityId();
    },
    setNetworkEntityId: function () {
        this.network_entity_id = this.slugify($('#name').val());
    },
    getNetworkEntityId: function () {
        return this.network_entity_id;
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

});

