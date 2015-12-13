<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 9/24/15
     * Time: 6:15 PM
     */
    class meAnjanWqg_Tags {

        /**
         * get all tags

         *
         * @return array
         */

        public static function getTags() {



            $taxonomy = 'post_tag';

            $args = array(
                'orderby'                  => 'name',
                'order'                    => 'ASC',
                'hide_empty'               => 0,
                'hierarchical'             => 0,
                'taxonomy'                 => $taxonomy,
            );

            $tags = get_categories($args);

            return $tags;

        }

        /**
         * Generates a categories dropdown
         *
         * @param array $params
         *
         * @return string
         */

        public static function tagsDropdown( $params = array()) {

            $attributes = meAnjanWqg_Utils::arrayValue($params,'attributes',array());

            $selected = meAnjanWqg_Utils::arrayValue($params,'selected','');



            $html = "<select";

            if(is_array($attributes) && count($attributes) > 0) {

                foreach($attributes as $key => $value) {

                    $html .= " {$key}='".(string)$value."'";

                }

            }

            $html .= '>';

            $empty_value = meAnjanWqg_Utils::arrayValue($params,'empty_value',false);

            if(is_array($empty_value) && isset($empty_value['label']) && isset($empty_value['value'])) {

                $html .= "<option value='{$empty_value['value']}'>{$empty_value['label']}</option>";

            }

            $tags = self::getTags(0);

            if(is_array($tags) && count($tags) > 0) {

                foreach($tags as $t) {

                    $html .= self::generateTagOption(array(
                        'tag' => $t,
                        'selected' => $selected,
                        'label_field' => meAnjanWqg_Utils::arrayValue($params,'label_field','name'),
                        'label_field_extra' => meAnjanWqg_Utils::arrayValue($params,'label_field_extra',''),
                        'value_field' => meAnjanWqg_Utils::arrayValue($params,'value_field','term_id'),
                        'indent' => 0
                    ));

                }

            }

            $html .= '</select>';

            return $html;

        }

        /**
         * Generates <option> html tag for a tag
         *
         * @param array $params
         *
         * @return bool|string
         */

        public static function generateTagOption( $params = array()) {

            $tag = meAnjanWqg_Utils::arrayValue($params,'tag',false);

            if(!is_object($tag)) {
                return false;
            }



            $label_field = meAnjanWqg_Utils::arrayValue($params,'label_field','name');
            $label_field_extra = meAnjanWqg_Utils::arrayValue($params,'label_field_extra','');
            $value_field = meAnjanWqg_Utils::arrayValue($params,'value_field','term_id');

            $indent = (int)meAnjanWqg_Utils::arrayValue($params,'indent',0);

            $label = isset($tag->$label_field) ? $tag->$label_field : '';
            $value = isset($tag->$value_field) ? $tag->$value_field : '';

            $label = str_repeat('-',$indent).$label;

            if($label_field_extra != '') {

                $extraLabelValue = isset($tag->$label_field_extra) ? trim($tag->$label_field_extra) : '';

                if($extraLabelValue != '') {
                    $label .= " [{$extraLabelValue}]";
                }

            }

            /* Selected attr */

            $selected_attr = '';

            $selected = meAnjanWqg_Utils::arrayValue($params,'selected','');

            if(is_array($selected) && in_array($value,$selected)) {
                $selected_attr = ' selected';
            } else if($selected == $value) {
                $selected_attr = ' selected';
            }

            $html = "<option value='{$value}'{$selected_attr}>{$label}</option>";

            return $html;

        }

    }