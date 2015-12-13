/**
 * Created by anjan on 10/12/15.
 */

(function ($) {

    var $taxQueryBlock = $ ('.me-anjan-wqg-tax-query-block');

    var pluginData = meAnjanWqgData ? meAnjanWqgData : {};

    /**
     * Get block key. Its simply count of taxonomy blocks existing in the DOM. used for simple indexing
     * @returns {Number}
     */

    function getBlockKey () {
        return $ ('.me-anjan-wqg-tax-block').length;
    }

    /**
     * Generate a single taxonomy block html
     * @param block_id
     * @param values
     * @returns {string}
     */

    function generateTaxonomyBlock (block_id, values) {

        block_id = $.trim(block_id);

        if (block_id == '') {
            block_id = 'me-anjan-wqg-tax-block-' + getBlockKey ();
        }

        values = _.isObject(values) ? values : {};

        var html = [];

        var key = getBlockKey ();

        html.push('<div id="' + block_id + '" class="me-anjan-wqg-tax-block">');

        /* close button */

        html.push('<span class="dashicons dashicons-dismiss"></span>');

        html.push('<label>');

        html.push('<span>Taxonomy:</span>');

        html.push('<select data-placeholder=" " name="tax[rules][' + key + '][name]" size="1" class="me-anjan-wqg-taxonomies">');

        html.push('<option value=""></option>');

        if (_.has(pluginData, 'taxonomies') && _.isObject(pluginData.taxonomies)) {

            var selectedValue = _.has(values, 'name') ? values.name : '';

            for (var k in pluginData.taxonomies) {

                if (pluginData.taxonomies.hasOwnProperty(k)) {

                    html.push('<option value="' + k + '" ' + (selectedValue == k ? 'selected' : '') + '>' + k + '</option>');

                }

            }

        }

        html.push('</select>');

        html.push('</label>');

        html.push('<label>');
        html.push('<span>Field:</span>');

        html.push('<select name="tax[rules][' + key + '][field]" size="1" class="me-anjan-wqg-tax-field">');

        var fields = _.has(pluginData, 'taxonomy_fields') && _.isArray(pluginData.taxonomy_fields) ? pluginData.taxonomy_fields : [];

        var fields_len = fields.length;

        if (fields_len > 0) {

            var selectedValue = _.has(values, 'field') ? $.trim(values.field) : '';

            for (var i = 0; i < fields_len; i += 1) {

                var f = fields[i];

                if (selectedValue === '' && f.default > 0) {
                    selectedValue = f.value;
                }

                html.push('<option value="' + f.value + '" ' + (selectedValue == f.value ? 'selected' : '') + '>' + f.label + '</option>');

            }

        }

        html.push('</select>');

        html.push('</label>');

        html.push('<label>');
        html.push('<span>Operator:</span>');

        html.push('<select name="tax[rules][' + key + '][operator]" size="1" class="me-anjan-wqg-tax-operator">');

        var operators = _.has(pluginData, 'taxonomy_operators') && _.isArray(pluginData.taxonomy_operators) ? pluginData.taxonomy_operators : [];

        var operators_len = operators.length;

        if (operators_len > 0) {

            var selectedOperatorValue = _.has(values, 'operator') ? $.trim(values.operator) : '';

            for (var i = 0; i < operators_len; i += 1) {

                var f = operators[i];

                if (selectedOperatorValue === '' && f.default > 0) {
                    selectedOperatorValue = f.value;
                }

                html.push('<option value="' + f.value + '" ' + (selectedOperatorValue == f.value ? 'selected' : '') + '>' + f.label + '</option>');

            }

        }

        html.push('</select>');

        html.push('</label>');

        html.push('<label><span>Select Terms</span>');
        html.push('<select data-placeholder="select one or more terms" name="tax[rules][' + key + '][term][]" multiple class="me-anjan-wqg-tax-terms">');

        html.push('</select>');
        html.push('</label>');

        html.push('<label>');

        html.push('<input type="checkbox" name="tax[rules][' + key + '][include_children]" ' + (_.objValueAsInt(values, 'include_children') > 0 ? 'checked' : '') + ' value="1"> Include Children');

        html.push('</label>');

        html.push('<label>');

        html.push('</label>');

        html.push('<div style="clear: both;"></div>');

        html.push('</div>');

        return html.join('');

    }

    /**
     * Appends the generated taxonomy block html in DOM, and binds event handlers
     *
     * @param values
     */

    function appendTaxonomyBlock (values) {

        var block_id = 'me-anjan-wqg-tax-block' + getBlockKey ();

        $ ('.me-anjan-wqg-tax-query-block').append(generateTaxonomyBlock (block_id, values));

        var $block = $ ('#' + block_id);

        $block.find('select').chosen({
            disable_search_threshold: 10,
            allow_single_deselect   : true,
            search_contains         : true
        });

        $block.data('tax', _.objValueAsString(values, 'name'));
        $block.data('terms', _.objValueAsArray(values, 'term'));

        $block.find('.me-anjan-wqg-taxonomies').trigger('change');

    }

    $ ('#me-anjan-wqg-add-taxonomy').off('click').on('click', function () {

        appendTaxonomyBlock ();

    });

    $taxQueryBlock
        .off('change', '.me-anjan-wqg-taxonomies')
        .on('change', '.me-anjan-wqg-taxonomies', function (e) {

            var $this = $ (this);

            var $block = $this.parents('.me-anjan-wqg-tax-block');

            var blockTax = $block.data('tax');
            var blockTerms = $block.data('terms');

            var taxonomy = $.trim($this.val());

            if (taxonomy == '') {
                return false;
            }

            var $parent = $this.parents('.me-anjan-wqg-tax-block');

            var $fieldSelect = $parent.find('.me-anjan-wqg-tax-field');

            var $termsSelect = $parent.find('.me-anjan-wqg-tax-terms');

            var data = {
                taxonomy: taxonomy,
                field   : $fieldSelect.val()
            };

            jQuery.ajax ({
                url       : pluginData.ajax_url.taxonomy_terms,
                type: 'GET',
                dataType: 'JSON',
                data    : data,
                beforeSend: function () {
                    $this.prop('disabled', true);
                },
                success   : function (res) {

                    $this.prop('disabled', false);

                    res = _.isArray(res) ? res : [];

                    var loopCount1 = res.length;

                    var html = [];

                    for (var i = 0; i < loopCount1; i += 1) {

                        var t = res[i];

                        html.push('<option value="' + t.value + '" ' + (blockTax == taxonomy && blockTerms.indexOf(t.value) >= 0 ? 'selected' : '') + '>' + t.label + ' (' + t.value + ')' + '</option>');

                    }

                    $termsSelect.html(html.join(''));

                    $termsSelect.trigger("chosen:updated");

                },
                error     : function () {
                    $this.prop('disabled', false);
                }
            });

        });

    /**
     * taxonomy terms change events
     **/

    $taxQueryBlock.off('change', '.me-anjan-wqg-tax-terms').on('change', '.me-anjan-wqg-tax-terms', function (e) {
        var $this = $ (this);

        var $block = $this.parents('.me-anjan-wqg-tax-block');

        $block.data('terms', $this.val());
        $block.data('tax', $block.find('.me-anjan-wqg-taxonomies').val());
    });

    $taxQueryBlock
        .off('change', '.me-anjan-wqg-tax-field')
        .on('change', '.me-anjan-wqg-tax-field', function (e) {

            $ (this).parents('.me-anjan-wqg-tax-block').find('.me-anjan-wqg-taxonomies').trigger('change');

        });

    if (_.isArray(meAnjanPluginsWqgTaxRules) && meAnjanPluginsWqgTaxRules.length > 0) {

        var loopCount1 = meAnjanPluginsWqgTaxRules.length;

        for (var i = 0; i < loopCount1; i += 1) {
            appendTaxonomyBlock (meAnjanPluginsWqgTaxRules[i])
        }

    }

    $taxQueryBlock
        .off('click', '.dashicons-dismiss')
        .on('click', '.dashicons-dismiss', function () {

            if (confirm ('Remove this block?')) {
                $ (this).parents('.me-anjan-wqg-tax-block').remove();
            }

        });

}) (jQuery);