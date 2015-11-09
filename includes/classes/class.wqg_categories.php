<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 9/24/15
     * Time: 6:15 PM
     */
    class wqg_categories {

        /**
         * get direct child categories
         *
         * @param int    $parent_category_id
         *
         * @return array
         */

        public static function get_categories($parent_category_id = 0) {

            $parent_category_id = (int)$parent_category_id;

            $taxonomy = 'category';

            $args = array(
                'parent'                   => $parent_category_id,
                'orderby'                  => 'name',
                'order'                    => 'ASC',
                'hide_empty'               => 0,
                'hierarchical'             => 1,
                'taxonomy'                 => $taxonomy,
            );

            $categories = get_categories($args);

            return $categories;

        }

        /**
         * Generates a categories dropdown
         *
         * @param array $params
         *
         * @return string
         */

        public static function categories_dropdown($params = array()) {

            $attributes = wqg_utils::__ARRAY_VALUE($params,'attributes',array());

            $selected = wqg_utils::__ARRAY_VALUE($params,'selected','');



            $html = "<select";

            if(is_array($attributes) && count($attributes) > 0) {

                foreach($attributes as $key => $value) {

                    $html .= " {$key}='".(string)$value."'";

                }

            }

            $html .= '>';

            $empty_value = wqg_utils::__ARRAY_VALUE($params,'empty_value',false);

            if(is_array($empty_value) && isset($empty_value['label']) && isset($empty_value['value'])) {

                $html .= "<option value='{$empty_value['value']}'>{$empty_value['label']}</option>";

            }

            $categories = self::get_categories(0);

            if(is_array($categories) && count($categories) > 0) {

                foreach($categories as $c) {

                    $html .= self::generate_category_option(array(
                        'category' => $c,
                        'selected' => $selected,
                        'label_field' => wqg_utils::__ARRAY_VALUE($params,'label_field','name'),
                        'value_field' => wqg_utils::__ARRAY_VALUE($params,'value_field','term_id'),
                        'indent' => 0
                    ));

                }

            }

            $html .= '</select>';

            return $html;

        }

        /**
         * Generates <option> tag for a category
         *
         * @param array $params
         *
         * @return bool|string
         */

        public static function generate_category_option( $params = array()) {

            $category = wqg_utils::__ARRAY_VALUE($params,'category',false);

            if(!is_object($category)) {
                return false;
            }



            $label_field = wqg_utils::__ARRAY_VALUE($params,'label_field','name');
            $value_field = wqg_utils::__ARRAY_VALUE($params,'value_field','term_id');

            $indent = (int)wqg_utils::__ARRAY_VALUE($params,'indent',0);

            $label = isset($category->$label_field) ? $category->$label_field : '';
            $value = isset($category->$value_field) ? $category->$value_field : '';

            $label = str_repeat('-',$indent).$label;

            /* Selected attr */

            $selected_attr = '';

            $selected = wqg_utils::__ARRAY_VALUE($params,'selected','');

            if(is_array($selected) && in_array($value,$selected)) {
                $selected_attr = ' selected';
            } else if($selected == $value) {
                $selected_attr = ' selected';
            }

            $html = "<option value='{$value}'{$selected_attr}>{$label}</option>";

            $categories = self::get_categories($category->term_id);

            /* Child categories */

            if(is_array($categories) && count($categories) > 0) {

                foreach($categories as $c) {

                    $newParam = $params;

                    $newParam['indent'] = $indent + 1;

                    $newParam['category'] = $c;

                    $html .= self::generate_category_option($newParam);

                }

            }

            return $html;

        }

    }