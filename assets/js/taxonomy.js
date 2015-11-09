/**
 * Created by anjan on 10/12/15.
 */

(function ($) {

    var $taxQueryBlock = $('.taxonomy-query-block');

    var pluginData = meAnjanWqgData ? meAnjanWqgData : {};

    /**
     * Get block key. Its simply count of taxonomy blocks existing in the DOM. used for simple indexing
     * @returns {Number}
     */

    function getBlockKey() {
        return $('.taxonomy-block').length;
    }

    /**
     * Generate a single taxonomy block html
     * @param block_id
     * @param values
     * @returns {string}
     */

    function generateTaxonomyBlock(block_id,values) {

        block_id = $.trim(block_id);

        if(block_id == '') {
            block_id = 'taxonomy-block-' + getBlockKey();
        }

        values = _.isObject(values) ? values : {};

        var html = [];

        var key = getBlockKey();

        html.push('<div id="' + block_id + '" class="taxonomy-block">');

        html.push('<label>');

        html.push('<span>Taxonomy:</span>');

        html.push('<select name="tax[rules][' + key + '][name]" size="1" class="taxonomies">');

        html.push('<option value="">~ Select ~</option>');

        if(_.has(pluginData,'taxonomies') && _.isObject(pluginData.taxonomies)) {

            var selectedValue = _.has(values,'name') ? values.name : '';

            for(var k in pluginData.taxonomies) {

                if(pluginData.taxonomies.hasOwnProperty(k)) {

                    html.push('<option value="' + k + '" ' + (selectedValue == k ? 'selected':'') +'>' + k + '</option>');

                }

            }

        }

        html.push('</select>');

        html.push('</label>');

        html.push('<label>');
        html.push('<span>Field:</span>');

        html.push('<select name="tax[rules][' + key + '][field]" size="1" class="taxonomy_field">');

        var fields = _.has(pluginData,'taxonomy_fields') && _.isArray(pluginData.taxonomy_fields) ? pluginData.taxonomy_fields : [];

        var fields_len = fields.length;

        if(fields_len > 0) {

            var selectedValue = _.has(values,'field') ? $.trim(values.field) : '';

            for (var i = 0; i < fields_len; i += 1) {

                var f = fields[i];

                if(selectedValue === '' && f.default > 0) {
                    selectedValue = f.value;
                }

                html.push('<option value="' + f.value + '" ' + (selectedValue == f.value ? 'selected':'') +'>' + f.label + '</option>');

            }

        }

        html.push('</select>');

        html.push('</label>');

        html.push('<label>');
        html.push('<span>Operator:</span>');

        html.push('<select name="tax[rules][' + key + '][operator]" size="1" class="taxonomy_operator">');

        var operators = _.has(pluginData,'taxonomy_operators') && _.isArray(pluginData.taxonomy_operators) ? pluginData.taxonomy_operators : [];

        var operators_len = operators.length;

        if(operators_len > 0) {

            var selectedOperatorValue = _.has(values,'operator') ? $.trim(values.operator) : '';

            for (var i = 0; i < operators_len; i += 1) {

                var f = operators[i];

                if(selectedOperatorValue === '' && f.default > 0) {
                    selectedOperatorValue = f.value;
                }

                html.push('<option value="' + f.value + '" ' + (selectedOperatorValue == f.value ? 'selected':'') +'>' + f.label + '</option>');

            }

        }

        html.push('</select>');

        html.push('</label>');



        /*html.push('<label>');

        html.push('<span>Values (One term per line)</span>');

        html.push('<textarea rows="5" name="tax[rules][' + key + '][term]">' + _.objValueAsString(values,'term') + '</textarea>');



        html.push('</label>');*/

        html.push('<label><span>Select Terms</span>');
        html.push('<select data-placeholder="select one or more terms" name="tax[rules][' + key + '][term][]" multiple class="taxonomy_terms">');


        html.push('</select>');
        html.push('</label>');

        html.push('<label>');

        html.push('<input type="checkbox" name="tax[rules][' + key + '][include_children]" ' + (_.objValueAsInt(values,'include_children') > 0 ? 'checked':'') + ' value="1"> Include Children');

        html.push('</label>');

        html.push('<label>');

        html.push('<input type="button" class="remove-taxonomy-block" value="Remove" >');

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

    function appendTaxonomyBlock(values) {

        console.log(values);

        var block_id = 'taxonomy-block' + getBlockKey();

        $('.taxonomy-query-block').append(generateTaxonomyBlock(block_id,values));

        var $block = $('#' + block_id);

        $block.find('select').chosen({
            disable_search_threshold : 10,
            allow_single_deselect: true,
            search_contains : true
        });




        $block.data('tax', _.objValueAsString(values,'name'));
        $block.data('terms', _.objValueAsArray(values,'term'));


        $block.find('.taxonomies').trigger('change');

    }

    $('#me-anjan-wqg-add-taxonomy').off('click').on('click',function() {

        appendTaxonomyBlock();


    });

    $taxQueryBlock.off('change','.taxonomies').on('change','.taxonomies',function(e) {

        console.log (e.data);

        var $this = $(this);

        var $block = $this.parents('.taxonomy-block');

        var blockTax = $block.data('tax');
        var blockTerms = $block.data('terms');

        var taxonomy = $.trim($this.val());

        if(taxonomy == '') {
            return false;
        }

        var $parent = $this.parents('.taxonomy-block');

        var $fieldSelect = $parent.find('.taxonomy_field');

        var $termsSelect = $parent.find('.taxonomy_terms');

        var data = {
            taxonomy : taxonomy,
            field : $fieldSelect.val()
        };

        jQuery.ajax ({
            url       : pluginData.ajax_url.taxonomy_terms,
            type      : 'GET',
            dataType  : 'JSON',
            data      : data,
            beforeSend: function () {
                $this.prop('disabled',true);
            },
            success   : function (res) {

                $this.prop('disabled',false);

                res = _.isArray(res) ? res : [];



                var loopCount1 = res.length;

                var html = [];

                for (var i = 0; i < loopCount1; i += 1) {

                    var t = res[i];

                    html.push('<option value="' + t.value + '" ' + (blockTax == taxonomy && blockTerms.indexOf(t.value) >= 0 ? 'selected' : '') + '>' + t.label + ' (' + t.value + ')' +'</option>');

                }

                $termsSelect.html(html.join(''));

                $termsSelect.trigger("chosen:updated");




            },
            error     : function () {
                $this.prop('disabled',false);
            }
        });

    });

    /**
     * taxonomy terms change events
    **/

    $taxQueryBlock.off('change','.taxonomy_terms').on('change','.taxonomy_terms',function(e) {
        var $this = $(this);

        var $block = $this.parents('.taxonomy-block');

        $block.data('terms',$this.val());
        $block.data('tax',$block.find('.taxonomies').val());
    });

    $taxQueryBlock.off('change','.taxonomy_field').on('change','.taxonomy_field',function(e) {

        $(this).parents('.taxonomy-block').find('.taxonomies').trigger('change');

    });


    if(_.isArray(meAnjanPluginsWqgTaxRules) && meAnjanPluginsWqgTaxRules.length > 0) {

        var loopCount1 = meAnjanPluginsWqgTaxRules.length;

        for (var i = 0; i < loopCount1; i += 1) {
            appendTaxonomyBlock(meAnjanPluginsWqgTaxRules[i])
        }

    }

    $taxQueryBlock.off('click','.remove-taxonomy-block').on('click','.remove-taxonomy-block',function() {

        if(confirm('Remove this block?')) {
            $(this).parents('.taxonomy-block').remove();
        }

    });



}) (jQuery);