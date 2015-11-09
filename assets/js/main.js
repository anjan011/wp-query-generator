/**
 * Created by anjan on 9/14/15.
 */


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

    var meAnjanWqgData = _.objValueAsObject(window,'meAnjanWqgData',{});

    var idPrefix = $.trim(_.objValueAsString(meAnjanWqgData,'idPrefix'));

    if('' == idPrefix) {
        idPrefix = 'me-anjan-wqg-';
    }

    var html_ids = _.objValueAsObject(meAnjanWqgData,'html_ids',{});

    /**
     * Main container
     *
     * @type {*|HTMLElement}
     */

    var $mainContainer = $ ('#' + idPrefix + _.objValueAsString(html_ids,'generator_container'));

    /**
     * Tab Panel: Params
     *
     * @type {*|HTMLElement}
     */

    var $tabPanelParams = $ ('#' + idPrefix + _.objValueAsString(html_ids,'tabpanel_params'));

    /**
     * Params form
     *
     * @type {*|HTMLElement}
     */

    var $paramForm = $ ('#' + idPrefix + _.objValueAsString(html_ids,'generator_form'));

    /**
     * Output Block
     *
     * @type {*|HTMLElement}
     */

    var $outputBlock = $ ('#' + idPrefix + _.objValueAsString(html_ids,'generator_output'));

    /**
     * Reset Button
     *
     * @type {*|HTMLElement}
     */

    var $resetButton = $ ('#' + idPrefix + _.objValueAsString(html_ids,'reset_button'));

    /**
     * Init code mirror editor
     */

    var codeMirror = CodeMirror.fromTextArea ($outputBlock.find('textarea')[0], {
        mode       : "application/x-httpd-php",
        readOnly   : true,
        theme      : _.objValueAsString(meAnjanWqgData,'codeMirrorTheme'),
        lineNumbers: true
    });

    /**
     * params form submission
     */

    $paramForm.off ('submit').on ('submit', function (e) {

        console.log(arguments);

        var $form = $ (this);

        var formData = $form.serialize ();

        var ajax_url = _.objValueAsObject(meAnjanWqgData,'ajax_url',{});

        var form_generate_url = $.trim(_.objValueAsString(ajax_url,'form_generate',''));

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

                    codeMirror.setValue (html);

                },
                error      : function () {

                    $form.find ('input[type=submit],button[type=submit]').prop ('disabled', false);

                    $outputBlock.val ('Error generating code!');
                }
            });

        }

        return false;

    });

    /**
     * Logic for making up tab panel
     */

    $mainContainer.off ('click', '.me-anjan-wqg-tab-button').on ('click', '.me-anjan-wqg-tab-button', function (e) {

        var $link = $ (this);

        var $parent = $link.parents('.me-anjan-wqg-tabpanel');

        $parent.find ('li.me-anjan-wqg-tab-button-wrapper').removeClass ('active');

        $link.parent ('li.me-anjan-wqg-tab-button-wrapper').addClass ('active');

        $parent.find ('.me-anjan-wqg-tab-pane.active').removeClass ('active');

        $ ('#' + $link.attr ('href').substr (1)).addClass ('active');

        return false;

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

    $resetButton.on('click',function() {

        if(!confirm('Reset form data?')) {
            return false;
        }

        $('#' + idPrefix + 'action').val('reset-data');

        $paramForm[0].submit();
    });

    /**
     * On post_type change perform ajax for fetching post entries
     */

    $mainContainer.on('change','#' + idPrefix + 'post-type',function() {

        var $this = $(this);

        var value = $this.val();

        var $postsList = $('#' + idPrefix + 'post-id');

        console.log(value);

        console.log($postsList);

    });

    $ (document).ready(function ($) {

        $mainContainer.find ('.wqg-dropdown-multiple').each (function () {
            $ (this).attr ({
                multiple: 'multiple',
                size    : 10
            });
        });

        $mainContainer.find('select').chosen({

        });

        /**
         * Special action to perform on params tab button clicks. We need to re-init chosen dropdowns
         * else they would show up with 0px width
         */

        $tabPanelParams.on('click','.me-anjan-wqg-tab-button',function() {

            var id = $(this).data('id');

            jQuery ('#' + id + ' select').chosen('destroy').chosen();

            $('.wqgCurrentTab').val(id);


        });

    });

}) (jQuery);