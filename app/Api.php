<?php

/**
 * API Class File
 * @package       app
 * @since         V 1.0.0[Dated - 14/05/2015 ]
 * @author        Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 * 
 */
require_once 'HTTPRequest.php';
class Api extends HTTPRequest {
    public $username;
    public $password;
    public $repositoryUrl;
    public $contributer;
    public static $finalCount;
    /**
     * 
     * @param string $username  Service Username
     * @param string $password  Service Password 
     * @param string $repositoryUrl Repository complete path
     * @param string $contributor  Username of the contributor
     */
    
    public function __construct($username, $password, $repositoryUrl, $contributor) {
        $this->username = $username;
        $this->password = $password;
        $this->repositoryUrl = $repositoryUrl;
        $this->contributer = $contributor;
        self::$finalCount = 0;
    }
    
    /**
     * Get URL HOST of Repository
     * @return string 
     */
    public function getServiceType() {
        return parse_url($this->repositoryUrl, PHP_URL_HOST);
    }
    
    /**
     * Get Repositry path 
     * @return string   eg /:username/:repository
     */
    public function getRepoName() {
        return parse_url($this->repositoryUrl, PHP_URL_PATH);
    }
    
    /**
     * Makes curl request to the parent class.
     * @param string $url Complete API URL Address 
     * @param string $method    GET|POST
     * @return Array  
     */
    
    public function makeCurlRequest($url, $method) {
        $this->setUrl($url);
        $this->setMethod($method);
        $this->setAuthUsername($this->username);
        $this->setAuthPassword($this->password);
        return $this->request();
    }
    
    /**
     * Process the response from GIT API
     * @param array $response Raw Response By making curl Request 
     * @return string
     */
    public function getCountForGit($response = array()) {
        if ($response['code'] == 200 && !empty($response['body'])) {
            foreach ($response['body'] as $key => $val) {
                if ($val['author']['login'] === $this->contributer) {
                    self::$finalCount += $val['total'];
                }
            }
            return "Total Number Of Commits by $this->contributer: " . self::$finalCount . " \n";
        } else if ($response['code'] == 202) {
            return "GIT is building the result for request . Try after few seconds.\n";
        } else {
            if (isset($response['body']['message']) && $response['body']['message'] != '') {
                return $response['body']['message'] . "\n";
            }
            return "Unable to Find Count !\n";
        }
    }

    /**
     * Process the response from BITBUCKET API
     * @param array $response Raw Response By making curl Request
     * @return string
     */
    public function getCountForBit($response = array()) {
        if ($response['code'] == 200 && !empty($response['body'])) {
            foreach ($response['body']['values'] as $commit) {
                if (isset($commit['user']) && !empty($commit['user']) && $commit['user']['username'] === $this->contributer) {
                    ++self::$finalCount;
                } else if (!isset($commit['user'])) {
                    ++self::$finalCount;
                }
            }
            if (isset($response['body']['next']) && $response['body']['next'] != '') {
                $this->getCountForBit($this->makeCurlRequest($response['body']['next'], 'get'));
            }
            return "Total Number Of Commits by $this->contributer : " . self::$finalCount . " \n";
        }
        if (self::$finalCount > 0) {
            return "Total Number Of Commits by $this->contributer: " . self::$finalCount . " \n";
        }
        if (isset($response['body']['error']['message']) && $response['body']['error']['message'] != '') {
            return $response['body']['error']['message'] . "\n";
        }
        return "Unable to Find Count !\n";
    }
/**
 * Process the request as per the class is initialisation
 * @return mixed If known service then String else Array
 */
    public function processRequest() {
        $serviceType = $this->getServiceType();
        if(!$serviceType){return "Invalid Call ! \n";}
        $repoPath = $this->getRepoName();
        if(!defined("__APIURL__" . $serviceType)){
            return "API URL not found for $serviceType\n";
        }
        $apiUrl = sprintf(constant("__APIURL__" . $serviceType), $repoPath);
        $response = $this->makeCurlRequest($apiUrl, 'get');
        switch ($serviceType) {
            case 'github.com':
                return $this->getCountForGit($response);
                break;
            case 'bitbucket.org':
                return $this->getCountForBit($response);
                break;
            default :
                return $response;
                break;
        }
    }

}
