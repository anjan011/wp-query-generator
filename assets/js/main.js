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
                        },
                        blankElement   : '<option value=""><option>'
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

        $mainContainer.find('select').chosen({
            search_contains      : true,
            allow_single_deselect: true
        });

        /**
         * Special action to perform on params tab button clicks. We need to re-init chosen dropdowns
         * else they would show up with 0px width
         */

        $tabPanelParams.on('click', '.me-anjan-wqg-tab-button', function () {

            var id = $ (this).data('id');

            jQuery ('#' + id + ' select').chosen('destroy').chosen({
                search_contains      : true,
                allow_single_deselect: true
            });

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

    });

}) (jQuery);