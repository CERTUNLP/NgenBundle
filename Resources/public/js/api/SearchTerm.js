/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */
var SearchTerm = Class.extend({
    init: function () {
        this.search_form = $('#generalSearch');
        this.search_input = this.search_form.find('input');
        this.initTerms();
        this.updateButtonFilters();
    },
    updateButtonFilters: function () {
        self = this;
        this.search_terms.forEach(function ($term) {

            let $key = self.termKey($term);
            let $value = self.termValue($term);

            self.column($key).each(function (b, $td) {
                if ($($td).find('.colorbox-filter').data('id').toString() === $value) {
                    $($td).find('.colorbox-filter').data('action', 'remove');
                    $($td).find('i').each(function (b, $icon) {
                        $($icon).toggleClass('fas fa-filter').toggleClass('fas fa-backspace');
                    })
                }
            });
        });
    },
    termKey: function ($term) {
        let $key = $term.split(': ')[0];
        $key = this.decamelize($key, ' ').split(' ').map(function (b) {
            return b.charAt(0).toUpperCase() + b.slice(1)
        }).join(' ');
        return $key;

    },
    termValue: function ($term) {
        return $term.split(': ')[1].replace(/"/g, '').replace(/\\/g, '');
    },
    initTerms: function () {
        if (this.search_input.val() === '*' || !this.search_input.val()) {
            this.search_terms = [];
        } else {
            this.search_terms = this.search_input.val().split(' && ');
        }
    },
    filterList: function (event) {
        event.preventDefault();
        this.target = $(event.currentTarget);

        this.eventAdd(this.eventKey(), this.eventValue());

        this.submit();
    },
    submit: function () {
        this.search_input.val(this.search_terms.join(' && '));
        this.search_form.trigger('submit');
    },
    eventAdd: function ($key, $value) {
        if (this.exists($key)) {
            if (this.target.data('action') === 'add') {
                this.replace($key, $value);
            } else {
                this.delete($key);
            }
        } else {
            this.add($key, $value);
        }
    },
    eventKey: function () {
        // return $.camelCase(this.header().text().toLowerCase().trim().replace(/ /g, '-'));
        return $(this.header().find('a.sortable').attr('href').split('?')[1].split('&')).filter(function (a, b) {
            return b.includes('sort');
        }).get(0).split('=')[1]
    },
    decamelize: function (str, separator) {
        separator = typeof separator === 'undefined' ? '_' : separator;

        return str
            .replace(/([a-z\d])([A-Z])/g, '$1' + separator + '$2')
            .replace(/([A-Z]+)([A-Z][a-z\d]+)/g, '$1' + separator + '$2')
            .toLowerCase();
    },
    eventValue: function () {
        return this.target.data('id').toString();
    },
    empty: function () {
        return !this.search_terms.length
    },
    exists: function ($key) {
        return this.search_terms.find(function (elem) {
            return elem.startsWith($key);
        });
    },
    index: function ($key) {
        return this.search_terms.findIndex(function (elem) {
            return elem.startsWith($key);
        });
    },
    delete: function ($key) {
        return this.search_terms = this.search_terms.filter(function (elem) {
            return !elem.startsWith($key)
        });
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
    add: function ($key, $value) {

        return this.search_terms.push($key + ': ' + this.sanitize($value))
    },
    header: function () {
        return $('table').find('th').eq(this.target.parents('td').index());

    },
    column: function ($key) {
        let $index = $("th:contains('" + $key + "')").index() + 1;
        return $('table tr td:nth-child(' + $index + ')');

    },
    replace: function ($key, $value) {
        if (this.index($key) >= 0) {
            this.search_terms[this.index($key)] = this.search_terms[this.index($key)].replace(/:(.*)/, ': ' + this.sanitize($value))
        }
    }
});
