<?php

/**
 * Common Constants For App
 * @package       app
 * @since         V 1.0.0[Dated - 13/05/2015 ]
 * @author        Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 * 
 */
require_once 'CommonFunctions.php';                                             
$constants = array(
    "__APIURL__" => array(
        'github.com' => "https://api.github.com/repos%s/stats/contributors", //GITHUB Api Url Call as __APIURL__github.com %s will be /:repository/:username
        'bitbucket.org' => "https://bitbucket.org/api/2.0/repositories%s/commits",//BITBUCKET Api Url Call as __APIURL__bitbucket.com %s will be /:repository/:username
        /*Add Other Service Api url Below as "example.com" => "api.example.con/repo%s/stats",*/
        
    ),           
); 
defineConstants($constants);                                                    //DEFINE Constants from $constants Array
?>
