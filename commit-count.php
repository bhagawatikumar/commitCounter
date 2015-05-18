<?php
/**
 * Commit Count
 * @package       /
 * @since         V 1.0.0[Dated - 14/05/2015 ]
 * @author        Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 * 
 */
if(count($argv) == 7){                                              //Counting Array of arguments passed to script. Only 7 Allowed
    require_once 'app/Api.php';
    $apiObj = new Api($argv[2], $argv[4], $argv[5], $argv[6]);      //Initialising Api Object Having params Username,Password,Repo Url,Contributor Usermname
    $CountTxt = $apiObj->processRequest();                          //Processing the request
    if(is_string($CountTxt)){                                       //If Response is String
        echo $CountTxt; exit;                                       // Printing the count by Contributor 
    }else{                                                          //If response is not string then the response processing logic not written
        echo "Unprocessed Response ! Write A response processing method ! \n";exit;
    }
}else{
    echo "Invalid Call!\n";exit;
}

