<?php

    /**
     * Created by PhpStorm.
     * User: anjan
     * Date: 9/23/15
     * Time: 1:51 PM
     */

    class meAnjanWqg_Users {

        /**
         * Get users
         *
         * @param array $params
         *
         * @return array|null|object
         */

        public static function getUsers( $params = array()) {

            /**
             * @var wpdb $wpdb
             */

            global $wpdb;

            /* params */

            $users_table_name = trim(meAnjanWqg_Utils::arrayValue($params,'users_table_name',$wpdb->users));

            if($users_table_name == '') {
                $users_table_name = $wpdb->users;
            }

            $users_table_alias = trim(meAnjanWqg_Utils::arrayValue($params,'users_table_alias','u'));

            if($users_table_alias == '') {
                $users_table_alias = 'u';
            }

            $fields = (meAnjanWqg_Utils::arrayValue($params,'fields',$users_table_alias.'.*'));

            if(empty($fields)) {
                $fields = $users_table_alias.'.*';
            }


            /* Fields */

            if(is_array($fields) && count($fields) > 0) {
                $fields = join(',',$fields);
            } else if(is_string($fields)) {
                $fields = trim(trim($fields),',');
            } else {
                $fields = $users_table_alias.'.*';
            }


            $where_clause = " 1 ";

            $sql = "select {$fields} from {$users_table_name} {$users_table_alias} where {$where_clause} order by {$users_table_alias}.user_nicename asc";

            $users = $wpdb->get_results($sql,'ARRAY_A');

            return $users;

        }

    }