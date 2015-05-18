<?php
require_once 'Constants.php';
/**
 * All Http requests
 *
 * @author Bhagawati Kumar[bhagawatikumar(At)gmail(dot)com]
 */
class HTTPRequest {

    public $requestURL;
    public $requestMethod;
    public $authUsername;
    public $authPassword;
    
    /**
     * Sets the requestURL 
     * @param string $url
     */
    public function setUrl($url){
        $this->requestURL = $url;
    }
    /**
     * Sets the requestMethod
     * @param string $method
     */
    public function setMethod($method){
        $this->requestMethod = $method;
    }
    
    /**
     * Sets the authUsername
     * @param string $username
     */
    public function setAuthUsername($username){
        $this->authUsername = $username;
    }
    
    /**
     * Sets the authPAssword
     * @param string $password
     */
    public function setAuthPassword($password){
        $this->authPassword = $password;
    }

    /**
     * Makes the cURL Request to the Remote Host
     * @param array $data => Array of variables to be passed eg. array('key_name' => 'value','key_name2' => 'value2' ...)
     * @return Array If error return the cURL error
     */
    public function request($data = array()) {
        if (!empty($data)) {
            $tmpUrl = '';                                           //Temp URL Generation 
            if (strtoupper($this->requestMethod) == 'GET') {        //If requestMethod id GET the adding the $data elements to the requestURL
                if (!strpos($this->requestURL, '?')) {
                    $tmpUrl = '?';
                }
                foreach ($data as $key => $d) {
                    if ($tmpUrl == '') {
                        $tmpUrl .= '&';
                    }
                    $tmpUrl .= $key . "=" . rawurlencode($d);
                }
                $this->requestURL .= $tmpUrl;
            }
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->requestURL);
        curl_setopt($ch, CURLOPT_HEADER, true);
        if($this->authUsername && $this->authPassword){                         //If authUsername and authPassword is set
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ); 
            curl_setopt($ch, CURLOPT_USERPWD, "$this->authUsername:$this->authPassword");
            curl_setopt($ch, CURLOPT_USERAGENT, $this->authUsername);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->authUsername);
        if (!empty($data) && $this->requestMethod == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $output = curl_exec($ch);
        $header_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($output, $header_size);
        if (!$output) {
            pr(curl_error($ch));
        }
        curl_close($ch);
        $response['code'] = $header_code;                   //Response Code from API
        $response['body'] = json_decode($body,TRUE);        //Json Decoding the response
        return $response;
    }

}
