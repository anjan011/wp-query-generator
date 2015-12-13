/**
 * Created by anjan on 9/14/15.
 */

/**
 * Show/hide an ajax loader element
 *
 * @param action
 * @param $element
 * @param content
 * @param cssClass
 * @returns {boolean}
 */

function meAnjanWqg_AjaxLoader (action, $element, content, cssClass) {

    if (typeof $element == 'string') {
        $element = jQuery ($element);
    } else if (!($element instanceof jQuery)) {
        return false;
    }

    action = jQuery.trim(action);

    switch (action) {
        case 'show':
        case 'hide':
            break;
        default:
            action = 'show';
            break;
    }

    content = jQuery.trim(content);

    if ('' == content) {
        content = 'Please wait ...';
    }

    var $loader = $element.next('.me-anjan-wqg-ajax-loader');

    if ('hide' == action) {
        $loader.hide();
    } else {

        if ($loader.length > 0) {
            $loader.html(content).show();
        } else {

            jQuery ('<div class="me-anjan-wqg-ajax-loader ' + cssClass + '">' + content + '</div>').insertAfter($element);

        }

    }

}

/**
 * Updates a post list dropdown with data
 *
 * @param params
 * @returns {boolean}
 */

function meAnjanWqg_UpdatePostsDropdown (params) {

    var postData = _.objValueAsObject(params, 'data', {});

    var $select = _.objValue(params, 'select');

    if (typeof $select == 'string') {
        $select = jQuery ($select);
    } else if (!($select instanceof jQuery)) {
        return false;
    }

    var optionsCallback = _.has(params, 'optionsCallback') && _.isFunction(params.optionsCallback) ? params.optionsCallback : false;

    var html = [];

    if (_.has(params, 'blankElement') && jQuery.trim(params.blankElement) != '') {
        html.push(params.blankElement);
    }

    for (var optGroup in postData) {

        if (postData.hasOwnProperty(optGroup)) {

            html.push('<optgroup label="' + optGroup + '">');

            var entries = postData[optGroup];

            if (_.isArray(entries) && entries.length > 0) {
                var loopCount1 = entries.length;

                for (var i = 0; i < loopCount1; i += 1) {

                    var p = entries[i];

                    if (optionsCallback === false) {

                        html.push('<option value="' + p.id + '">' + p.title + '</option>');

                    } else {
                        html.push(optionsCallback.apply(null, [p]));
                    }

                }
            }

            html.push('</optgroup>');

        }

    }

    $select.html(html.join(''));

    if (_.has(params, 'afterUpdate') && _.isFunction(params.afterUpdate)) {
        params.afterUpdate.apply(null, [$select]);
    }

}

_.mixin ({

    /**
     * Is the value passed a plain JS object?
     * @param o
     *
     * @returns boolean
     */

    isPlainObject: function (o) {
        return _.isObject (o) && !_.isFunction (o) && !_.isArray (o);
    },

    /**
     * get int value
     *
     * @param v Value as string
     * @param d default value
     * @returns {*}
     */

    intValue: function (v, d) {

        if (_.isUndefined (d) || _.isNull (d)) {
            d = 0;
        }

        v = parseInt (v);

        if (isNaN (v)) {
            return d;
        }

        return v;
    },

    /**
     * Makes sure the value is an object, if not returns default value
     * @param v
     * @param d
     *
     * @return {Object}
     */

    obj: function (v, d) {

        if (!_.isPlainObject (d)) {
            d = {};
        }

        return _.isPlainObject (v) ? v : d;
    },

    /**
     * Gets object's key value
     *
     * @param o The source object
     * @param k The key
     * @param d Default value, if key doesn't exist
     *
     * @returns {*}
     */

    objValue: function (o, k, d) {

        return _.isObject (o) && _.hasKey (o, k) ? o[k] : d;

    },

    /**
     * Gets object's key value as string
     *
     * @param o The source object
     * @param k The key
     * @param d Default value, if key doesn't exist
     *
     * @returns {String}
     */

    objValueAsString: function (o, k, d) {

        var val = _.objValue (o, k, d);

        if (!val) {
            val = '';
        }

        return val.toString ();
    },

    /**
     * Gets object's key value as integer
     *
     * @param o The source object
     * @param k The key
     * @param d Default value, if key doesn't exist
     *
     * @returns {Number}
     */

    objValueAsInt: function (o, k, d) {

        var val = _.objValue (o, k, d);

        val = parseInt (val);

        if (isNaN (val)) {
            val = 0;
        }

        return val;
    },

    /**
     * Gets object's key value as float
     *
     * @param o The source object
     * @param k The key
     * @param d Default value, if key doesn't exist
     *
     * @returns {Number}
     */

    objValueAsFloat: function (o, k, d) {

        var val = _.objValue (o, k, d);

        val = parseFloat (val);

        if (isNaN (val)) {
            val = 0.0;
        }

        return val;
    },

    /**
     * Gets object's key value as boolean
     *
     * @param o The source object
     * @param k The key
     * @param d Default value, if key doesn't exist
     *
     * @returns {boolean}
     */

    objValueAsBool: function (o, k, d) {

        return !!(_.objValue (o, k, d));

    },

    /**
     * Gets object's key value as object
     *
     * @param o The source object
     * @param k The key
     * @param d Default value, if key doesn't exist
     *
     * @returns {Object}
     */

    objValueAsObject: function (o, k, d) {

        d = _.isObject (d) ? d : {};

        var val = _.objValue (o, k, d);

        val = _.isObject (val) ? val : {};

        return val;
    },

    /**
     * Gets object's key value as array
     *
     * @param o The source object
     * @param k The key
     * @param d Default value, if key doesn't exist
     *
     * @returns {Object}
     */

    objValueAsArray: function (o, k, d) {

        d = _.isArray (d) ? d : [];

        var val = _.objValue (o, k, d);

        val = _.isArray (val) ? val : [];

        return val;
    },

    /**
     * Checks if object has the given method on its own or in prototype chain
     *
     * @param o The source object
     * @param m The method name
     *
     * @returns {boolean}
     */

    hasMethod: function (o, m) {

        return _.isObject (o) && (_.functions (o).indexOf (m) >= 0);

    },

    /**
     * Checks if a property (either value of function) exists in object itself or in its prototype chain
     *
     * @param o The object
     * @param k The key
     *
     * @returns {boolean}
     */

    hasKey: function (o, k) {

        return _.isObject (o) && _.allKeys (o).indexOf (k) >= 0;

    },

    /**
     * Set object value as int
     *
     * @param o The object
     * @param k The key
     * @param v The value
     * @param d Default value
     */

    setIntValue: function (o, k, v, d) {

        if (!_.isObject (o)) {
            o = {};
        }

        d = parseInt (d);

        if (isNaN (d)) {
            d = 0;
        }

        v = parseInt (v);

        if (isNaN (v)) {
            v = d;
        }

        o[key] = v;
    }
});

(function ($) {

    var chosenParams = {
        search_contains      : true,
        allow_single_deselect: true
    };

    var meAnjanWqgData = _.objValueAsObject(window, 'meAnjanWqgData', {});

    var idPrefix = $.trim(_.objValueAsString(meAnjanWqgData, 'idPrefix'));

    if ('' == idPrefix) {
        idPrefix = 'me-anjan-wqg-';
    }

    var html_ids = _.objValueAsObject(meAnjanWqgData, 'html_ids', {});

    /**
     * Main container
     *
     * @type {*|HTMLElement}
     */

    var $mainContainer = $ ('#' + idPrefix + _.objValueAsString(html_ids, 'generator_container'));

    /**
     * Tab Panel: Params
     *
     * @type {*|HTMLElement}
     */

    var $tabPanelParams = $ ('#' + idPrefix + _.objValueAsString(html_ids, 'tabpanel_params'));

    /**
     * Params form
     *
     * @type {*|HTMLElement}
     */

    var $paramForm = $ ('#' + idPrefix + _.objValueAsString(html_ids, 'generator_form'));

    /**
     * Output Block
     *
     * @type {*|HTMLElement}
     */

    var $outputBlock = $ ('#' + idPrefix + _.objValueAsString(html_ids, 'generator_output'));

    /**
     * Reset Button
     *
     * @type {*|HTMLElement}
     */

    var $resetButton = $ ('#' + idPrefix + _.objValueAsString(html_ids, 'reset_button'));

    /**
     * params form submission
     */

    $paramForm.off ('submit').on ('submit', function (e) {

        console.log(arguments);

        var $form = $ (this);

        var formData = $form.serialize ();

        var ajax_url = _.objValueAsObject(meAnjanWqgData, 'ajax_url', {});

        var form_generate_url = $.trim(_.objValueAsString(ajax_url, 'form_generate', ''));

        if (form_generate_url != '') {

            jQuery.ajax ({
                url        : form_generate_url,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                type       : 'POST',
                dataType   : 'html',
                data       : formData,
                beforeSend : function () {

                    $form.find ('input[type=submit],button[type=submit]').prop ('disabled', true);

                },
                success    : function (html) {

                    $form.find ('input[type=submit],button[type=submit]').prop ('disabled', false);

                    html = html.replace('<', '&lt;').replace('>', '&gt;');

                    $outputBlock.find('.me-anjan-wqg-sh-code').empty().html('<pre class="brush: php">' + html + '</pre>');

                    SyntaxHighlighter.highlight();

                    $ ('[href=#me-anjan-wqg-tab-button-code]').click();

                    // todo: determine if we scroll to element or not

                    /*jQuery("html, body").animate({ scrollTop: jQuery('#me-anjan-wqg-form').offset().top }, 1000);*/

                },
                error      : function () {
                    $form.find ('input[type=submit],button[type=submit]').prop ('disabled', false);

                    $outputBlock.val ('Error generating code!');
                }
            });

        }

        return false;

    });

    var $tabPanels = $mainContainer.find('.me-anjan-wqg-tabpanel');

    /**
     * Logic for making up tab panel
     */

    $tabPanels.each(function () {

        var $tb = $ (this);

        $tb
            .off ('click', '> .me-anjan-wqg-tab-buttons > .me-anjan-wqg-tab-button-wrapper > .me-anjan-wqg-tab-button')
            .on ('click', '> .me-anjan-wqg-tab-buttons > .me-anjan-wqg-tab-button-wrapper > .me-anjan-wqg-tab-button', function () {

                var $link = $ (this);

                $tb.find ('> .me-anjan-wqg-tab-buttons > .me-anjan-wqg-tab-button-wrapper').removeClass ('active');

                $link.parent ().addClass ('active');

                $tb.find ('> .me-anjan-wqg-tab-contents > .me-anjan-wqg-tab-pane.active').removeClass ('active');

                $ ('#' + $link.attr ('href').substr (1)).addClass ('active');



                $('.wqgCurrentTab').val($link.attr('id'));

                return false;

            });

    });

    /**
     * make sure that params tab panels are sof same height
     */

    var $tabButtonsList = $tabPanelParams.find ('.me-anjan-wqg-tab-buttons');

    var tabButtonListHeight = $tabButtonsList.outerHeight ();

    $tabPanelParams.find ('div.me-anjan-wqg-tab-pane').css ({
        'min-height': tabButtonListHeight + 'px'
    });

    /**
     * Force form submit on rest button click
     */

    $resetButton.on('click', function () {

        if (!confirm ('Reset form data?')) {
            return false;
        }

        $ ('#' + idPrefix + 'action').val('reset-data');

        $paramForm[0].submit();
    });

    /**
     * On post_type change perform ajax for fetching post entries
     */

    $mainContainer.on('change', '#' + idPrefix + 'post-type', function () {

        var $this = $ (this);

        var value = $this.val();

        var $postsList = $ ('#' + idPrefix + 'post-id');
        var $postsSlugList = $ ('#' + idPrefix + 'post-slug');
        var $parentPostsList = $ ('#' + idPrefix + 'post-parent');

        var ajax_url = _.objValueAsObject(meAnjanWqgData, 'ajax_url', {});

        var post_list_url = $.trim(_.objValueAsString(ajax_url, 'post_list', ''));

        if (post_list_url != '') {

            jQuery.ajax ({
                url       : post_list_url,
                type      : 'GET',
                dataType  : 'json',
                data      : {
                    post_type: value
                },
                beforeSend: function () {

                    meAnjanWqg_AjaxLoader ('show', $this.next('.chosen-container'), 'Please wait ...', 'img-loader');

                },
                success   : function (postsData) {

                    meAnjanWqg_AjaxLoader ('hide', $this.next('.chosen-container'));

                    meAnjanWqg_UpdatePostsDropdown ({
                        data           : postsData,
                        select         : $postsList,
                        optionsCallback: function (o) {

                            return '<option value="' + o.id + '">' + o.title + ' (' + o.id + ')' + '</option>';

                        },
                        afterUpdate    : function ($select) {

                            $select.val($select.data('lastValue'));

                            $select.trigger('chosen:updated');
                        }
                    });

                    meAnjanWqg_UpdatePostsDropdown ({
                        data           : postsData,
                        select         : $postsSlugList,
                        optionsCallback: function (o) {

                            return '<option value="' + o.slug + '">' + o.slug + '</option>';

                        },
                        afterUpdate    : function ($select) {

                            $select.val($select.data('lastValue'));

                            $select.trigger('chosen:updated');
                        },
                        blankElement   : '<option value=""><option>'
                    });

                    meAnjanWqg_UpdatePostsDropdown ({
                        data           : postsData,
                        select         : $parentPostsList,
                        optionsCallback: function (o) {

                            return '<option value="' + o.id + '">' + o.title + ' (' + o.id + ')' + '</option>';

                        },
                        afterUpdate    : function ($select) {

                            $select.val($select.data('lastValue'));

                            $select.trigger('chosen:updated');
                        }
                    });

                },
                error     : function () {
                    meAnjanWqg_AjaxLoader ('hide', $this.next('.chosen-container'));
                }
            });

        }

    });

    $ (document).ready(function ($) {

        $mainContainer.find ('.wqg-dropdown-multiple').each (function () {
            $ (this).attr ({
                multiple: 'multiple',
                size    : 10
            });
        });

        $mainContainer.find('select').chosen(chosenParams);

        /**
         * Special action to perform on params tab button clicks. We need to re-init chosen dropdowns
         * else they would show up with 0px width
         */

        $tabPanelParams.on('click', '.me-anjan-wqg-tab-button', function () {

            var id = $ (this).data('id');

            jQuery ('#' + id + ' select').chosen('destroy').chosen(chosenParams);

            $ ('.wqgCurrentTab').val(id);
        });

        SyntaxHighlighter.all();

        /**
         * Data preview
         */

        $mainContainer.on('click', '.me-anjan-wqg-btn-preview', function () {

            var $this = $ (this);

            var ajax_url = _.objValueAsObject(meAnjanWqgData, 'ajax_url', {});

            var data_preview_url = $.trim(_.objValueAsString(ajax_url, 'data_preview', ''));

            if (data_preview_url != '') {

                var formData = $paramForm.serialize();

                jQuery.ajax ({
                    url       : data_preview_url,
                    type      : 'POST',
                    dataType  : 'html',
                    data      : formData,
                    beforeSend: function () {

                        $paramForm.find ('input[type=submit],button').prop ('disabled', true);

                    },
                    success   : function (html) {

                        $paramForm.find ('input[type=submit],button').prop ('disabled', false);

                        $ ('#me-anjan-wqg-preview-box').html(html);

                        $ ('[href=#me-anjan-wqg-tab-button-preview]').click();

                    },
                    error     : function () {
                        $paramForm.find ('input[type=submit],button').prop ('disabled', false);

                        $ ('#me-anjan-wqg-preview-box').html ('<span class="me-anjan-wqg-error">Error generating code!</span>');
                    }
                });

            }

            return false;

        });

        /**
         * make the dropdowns remember their last selected value
         */

        $mainContainer.on('change', 'select', function () {

            var $this = $ (this);

            $this.data('lastValue', $this.val());

        });

        $('#me-anjan-wqg-post-id').trigger('change');
        $('#me-anjan-wqg-post-slug').trigger('change');

        $('#me-anjan-wqg-cb-nopaging').on('click',function() {

            var $tbody = $('#me-anjan-wqg-tbody-pagination-params');

            var checked = $(this).prop('checked');

            if(checked) {

                $tbody.hide();

                $tbody.find('input,select,textarea').prop('disabled',true);

            } else {
                $tbody.show();

                $tbody.find('input,select,textarea').prop('disabled',false);
            }

        });

        $('#me-anjan-wqg-sorting-orderby').on('change',function() {

            var val = $(this).val();

            var $metaKeyList = $('#me-anjan-wqg-sorting-meta-key');

            var allowedValues = ['meta_value','meta_value_num'];



            if(allowedValues.indexOf(val) >= 0) {

                $('#me-anjan-wqg-tr-sorting-meta-key').show();

                $metaKeyList.chosen('destroy');

                $metaKeyList.prop('disabled',false);

                $metaKeyList.chosen(chosenParams);

            } else {

                $('#me-anjan-wqg-tr-sorting-meta-key').hide();

                $metaKeyList.chosen('destroy');

                $metaKeyList.prop('disabled',true);

            }

        });

    });

    /**
     * Generates a block number for a date criteria box
     *
     * @returns {*}
     */

    function getDateQueryCriteriaBlockId() {
        return $('#me-anjan-wqg-date-criteria-container').find('.me-anjan-wqg-date-criteria-box').length + 1;
    }

    /**
     * Generates html code for a criteria block
     *
     * @param blockId
     * @param values
     * @returns {{htmlId: string, html: string}}
     */

    function generateHtmlForDateQueryCriteriaBlock(blockId,values) {

        blockId = $.trim(blockId);

        if(blockId == '') {
            blockId = getDateQueryCriteriaBlockId();
        }

        values = _.isPlainObject(values) ? values : {};

        var html = [];

        var blockHtmlId = 'me-anjan-wqg-date-criteria-box-' + blockId;

        html.push('<div class="me-anjan-wqg-date-criteria-box" id="' + blockHtmlId + '">');

        /* close button */

        html.push('<span class="dashicons dashicons-dismiss"></span>');

        /* Column */

        var cols = ['post_date','post_date_gmt','post_modified','post_modified_gmt'];

        html.push('<label>');
        html.push('<span>Column</span>');
        html.push('<select name="date_query[criteria][' + blockId + '][column]" size="1">');

        var loopCount1 = cols.length;

        for (var i = 0; i < loopCount1; i += 1) {
            html.push('<option value="' + cols[i] + '" ' + (_.objValueAsString(values,'column','post_date') == cols[i] ? 'selected':'') + '>' + cols[i] + '</option>');
        }

        html.push('</select>');
        html.push('</label>');

        /* Compare */

        var compares = ['=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN'];

        html.push('<label>');
        html.push('<span>Compare Type</span>');
        html.push('<select name="date_query[criteria][' + blockId + '][compare]" size="1">');

        var comparesLen = compares.length;

        for (var i = 0; i < comparesLen; i += 1) {

            var v = compares[i].toUpperCase();

            html.push('<option value="' + v + '" ' + (_.objValueAsString(values,'compare','=') == v ? 'selected':'') + '>' + v + '</option>');
        }

        html.push('</select>');
        html.push('</label>');

        /* year */

        html.push('<label>');
        html.push('<span>Year</span>');
        html.push('<input type="text" name="date_query[criteria][' + blockId + '][year]" value="' + _.objValueAsString(values,'year') + '" />');
        html.push('</label>');
        html.push('<label>');

        /* month */

        html.push('<span>Month</span>');
        html.push('<input type="text" name="date_query[criteria][' + blockId + '][month]" value="' + _.objValueAsString(values,'month') + '" />');
        html.push('</label>');
        html.push('<label>');

        /* week */

        html.push('<span>Week</span>');
        html.push('<input type="text" name="date_query[criteria][' + blockId + '][week]" value="' + _.objValueAsString(values,'week') + '" />');
        html.push('</label>');
        html.push('<label>');

        /* day */

        html.push('<span>Day</span>');
        html.push('<input type="text" name="date_query[criteria][' + blockId + '][day]" value="' + _.objValueAsString(values,'day') + '" />');
        html.push('</label>');

        /* hour */

        html.push('<label>');
        html.push('<span>Hour</span>');
        html.push('<input type="text" name="date_query[criteria][' + blockId + '][hour]" value="' + _.objValueAsString(values,'hour') + '" />');
        html.push('</label>');

        /* minute */

        html.push('<label>');
        html.push('<span>Minute</span>');
        html.push('<input type="text" name="date_query[criteria][' + blockId + '][minute]" value="' + _.objValueAsString(values,'minute') + '" />');
        html.push('</label>');

        /* second */

        html.push('<label>');
        html.push('<span>Second</span>');
        html.push('<input type="text" name="date_query[criteria][' + blockId + '][second]" value="' + _.objValueAsString(values,'second') + '" />');
        html.push('</label>');

        html.push('</div>');

        return {
            htmlId : blockHtmlId,
            html : html.join('')
        }

    }

    /**
     * Generates and appends date criteria box in dom
     *
     * @param blockId
     * @param values
     */

    function appendDateCriteriaBox(blockId,values) {

        var data = generateHtmlForDateQueryCriteriaBlock(blockId,values);

        var html = _.objValueAsString(data,'html','');

        var blockhtmlId = $.trim(_.objValueAsString(data,'htmlId',''));

        if(blockhtmlId != '') {

            $dateQueryCriteriaContainer.append(html);

            var $block = $('#' + blockhtmlId);

            $block.find('select').chosen(chosenParams);

            $block.on('click','.dashicons-dismiss',function() {

                if(!confirm('Remove this block?')) {
                    return false;
                }

                $(this).parent().remove();

            });

        }

    }

    var $dateQueryCriteriaContainer = $('#me-anjan-wqg-date-criteria-container');

    $mainContainer.on('click','#me-anjan-wqg-add-date-criteria-box',function() {

        appendDateCriteriaBox('',{});

    });

    if(_.has(window,'meAnjanWqgDateQueryCriterias') && _.isArray(meAnjanWqgDateQueryCriterias)) {

        var loopCount1 = meAnjanWqgDateQueryCriterias.length;

        for (var i = 0; i < loopCount1; i += 1) {

            appendDateCriteriaBox(i,meAnjanWqgDateQueryCriterias[i]);

        }

    }

    /*********************************************************************
     * By: Anjan @ Nov 26, 2015 2:30 PM
     *********************************************************************
     * Meta criteria box
     *********************************************************************/


    function getMetaQueryCriteriaBlockId() {
        return $('#me-anjan-wqg-meta-query-block').find('.me-anjan-wqg-meta-criteria-box').length + 1;
    }

    function generateHtmlForMetaQueryCriteriaBlock(blockId,values) {

        values = _.isPlainObject(values) ? values : {};

        blockId = $.trim(blockId);

        if(blockId == '') {
            blockId = getMetaQueryCriteriaBlockId();
        }

        var htmlId = 'me-anjan-wqg-meta-criteria-box-' + blockId;

        var html = [];

        html.push('<div class="me-anjan-wqg-meta-criteria-box" id="' + htmlId + '">');

        html.push('<span class="dashicons dashicons-dismiss"></span>');

        html.push('<label>');
        html.push('<span>Meta Key</span>');

        html.push('<select name="meta_query[queries][' + blockId + '][key]" data-placeholder=" ">');

        html.push('<option></option>');

        if(_.has(window,'meAnjanWqgPostMetaList') && _.isArray(window.meAnjanWqgPostMetaList)) {

            var loopCount1 = meAnjanWqgPostMetaList.length;


            var key = _.objValueAsString(values,'key','');

            for (var i = 0; i < loopCount1; i += 1) {

                var m = meAnjanWqgPostMetaList[i];

                html.push('<option value="' + m + '" ' + (key == m ? 'selected':'') + '>' + m + '<option>');

            }

        }

        html.push('</select>');



        html.push('</label>');

        // compare types

        var metaCompareTypes = [ '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS' ];



        html.push('<label>');
        html.push('<span>Compare Type</span>');

        html.push('<select name="meta_query[queries][' + blockId + '][compare]" size="1">');

        var compare = _.objValueAsString(values,'compare','=');

        var metaCompareLen = metaCompareTypes.length;

        for (var j = 0; j < metaCompareLen; j += 1) {

            var mc = metaCompareTypes[j];

            html.push('<option value="' + mc + '" ' + (mc == compare ? 'selected' : '') + '>' + mc + '</option>');

        }

        html.push('</select>');

        html.push('</label>');

        html.push('<label>');
        html.push('<span>Meta Value</span>');
        html.push('<textarea name="meta_query[queries][' + blockId + '][value]" rows="5">' + _.objValueAsString(values,'value','') + '</textarea>');
        html.push('</label>');

        // meta value types

        var metaValueTypes = ['NUMERIC', 'BINARY', 'CHAR', 'DATE', 'DATETIME', 'DECIMAL', 'SIGNED', 'TIME', 'UNSIGNED'];

        html.push('<label>');
        html.push('<span>Meta Value Type</span>');

        html.push('<select name="meta_query[queries][' + blockId + '][type]" size="1">');

        var type = _.objValueAsString(values,'type','CHAR');

        var valueTypesLen = metaValueTypes.length;

        for (var k = 0; k < valueTypesLen; k += 1) {

            var vt = metaValueTypes[k];

            html.push('<option value="' + vt + '" ' + (vt == type ? 'selected' : '') + '>' + vt + '</option>');

        }

        html.push('</select>');
        html.push('</label>');
        html.push('</div>');

        return {
            html : html.join(''),
            htmlId : htmlId
        };

    }

    function appendMetaQueryCriteriaBox(blockId,values) {

        var data = generateHtmlForMetaQueryCriteriaBlock(blockId,values);

        var html = _.objValueAsString(data,'html','');

        var blockhtmlId = $.trim(_.objValueAsString(data,'htmlId',''));

        if(blockhtmlId != '') {

            $metaQueryCriteriaContainer.append(html);

            var $block = $('#' + blockhtmlId);

            $block.find('select').chosen(chosenParams);

            $block.on('click','.dashicons-dismiss',function() {

                if(!confirm('Remove this block?')) {
                    return false;
                }

                $(this).parent().remove();

            });

        }

    }

    var $metaQueryCriteriaContainer = $('#me-anjan-wqg-meta-query-block');

    $mainContainer.on('click','#me-anjan-wqg-add-meta-query',function() {

        appendMetaQueryCriteriaBox('',{});

    });

    if(_.has(window,'meAnjanWqgMetaQueryCriterias') && _.isArray(meAnjanWqgMetaQueryCriterias)) {

        var loopCount1 = meAnjanWqgMetaQueryCriterias.length;

        for (var i = 0; i < loopCount1; i += 1) {

            appendMetaQueryCriteriaBox(i,meAnjanWqgMetaQueryCriterias[i]);

        }

    }

}) (jQuery);