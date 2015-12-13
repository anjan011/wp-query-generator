<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 9/24/15
     * Time: 6:15 PM
     */

    class meAnjanWqg_Categories {

        /**
         * Gets direct child categories
         *
         * @param int $parentCategoryId
         *
         * @return array
         */

        public static function getCategories( $parentCategoryId = 0) {

            $parentCategoryId = (int)$parentCategoryId;

            $taxonomy = 'category';

            $args = array(
                'parent'                   => $parentCategoryId,
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

        public static function categoriesDropdown( $params = array()) {

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

            $categories = self::getCategories(0);

            if(is_array($categories) && count($categories) > 0) {

                foreach($categories as $c) {

                    $html .= self::generateCategoryOption(array(
                        'category' => $c,
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
         * Generates <option> tag for a category
         *
         * @param array $params
         *
         * @return bool|string
         */

        public static function generateCategoryOption( $params = array()) {

            $category = meAnjanWqg_Utils::arrayValue($params,'category',false);

            if(!is_object($category)) {
                return false;
            }



            $label_field = meAnjanWqg_Utils::arrayValue($params,'label_field','name');
            $label_field_extra = meAnjanWqg_Utils::arrayValue($params,'label_field_extra','');
            $value_field = meAnjanWqg_Utils::arrayValue($params,'value_field','term_id');

            $indent = (int)meAnjanWqg_Utils::arrayValue($params,'indent',0);

            $label = isset($category->$label_field) ? $category->$label_field : '';

            if($label_field_extra != '') {

                $extraLabelValue = isset($category->$label_field_extra) ? trim($category->$label_field_extra) : '';

                if($extraLabelValue != '') {
                    $label .= " [{$extraLabelValue}]";
                }

            }

            $value = isset($category->$value_field) ? $category->$value_field : '';

            $label = str_repeat('-',$indent).$label;

            /* Selected attr */

            $selected_attr = '';

            $selected = meAnjanWqg_Utils::arrayValue($params,'selected','');

            if(is_array($selected) && in_array($value,$selected)) {
                $selected_attr = ' selected';
            } else if($selected == $value) {
                $selected_attr = ' selected';
            }

            $html = "<option value='{$value}'{$selected_attr}>{$label}</option>";

            $categories = self::getCategories($category->term_id);

            /* Child categories */

            if(is_array($categories) && count($categories) > 0) {

                foreach($categories as $c) {

                    $newParam = $params;

                    $newParam['indent'] = $indent + 1;

                    $newParam['category'] = $c;

                    $html .= self::generateCategoryOption($newParam);

                }

            }

            return $html;

        }

    }