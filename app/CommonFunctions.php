<?php
error_reporting(0);                     //Error Reorting Off for all
/**
 * Common Functions
 * @package       app/
 * @since         V 1.0.0[Dated - 14/05/2015 ]
 * @author        Bhagawati Kumar[b(dot)kumar(At)mapmyindia(dot)co(dot)in]
 * 
 */

if (!function_exists('pr')) {
/**
 * @param $data => Array | String To print<br />
 *        $exit => Boolean (Default : true)
 *                 If exit is true then the function exists there.
 * @return string Prints the formated $data
 * @author Bhagawati Kumar[b(dot)kumar(At)mapmyindia(dot)co(dot)in]
 */
    function pr($data, $exit = true) {
        $de = debug_backtrace();
        echo 'File : ' . $de[0]['file'];
        echo '<br />Line : ' . $de[0]['line'];
        echo '<br /><pre>';
        print_r($data);
        echo '</pre>';
        if ($exit) {
            exit;
        }
    }

}

if (!function_exists('defineConstants')) {
/**
 * @param $constants => Array (MAX 2 Dimensions).<br />
 * Examples 1. array('constant_name' => 'value')  | Will create constant_name as constant <br />
 * Examples 2. array('__group__' => array('constant_name' => 'value')) | Will create __group__constant_name as constant 
 * @return mixed Decleares the Constant as per Array structure
 * @author Bhagawati Kumar[b(dot)kumar(At)mapmyindia(dot)co(dot)in]
 * 
 */ 
    function defineConstants($constants = array()) {
        if (is_array($constants)) {
            if (!empty($constants)) {
                foreach ($constants as $name => $value) {
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            define($name . $k, $v);
                        }
                    } else {
                        define($name, $value);
                    }
                }
            } else {
                die("Unable To Decleare Constants!");
            }
        } else {
            die("Unable To Decleare Constants!");
        }
    }

}
