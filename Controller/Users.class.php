<?php
require_once 'API.class.php';

/**
 * 
 */
class Users extends API
{
    protected $User;
    
    function __construct($request, $origin) {
        parent::__construct($request);
        
        $APIKey = new Models\APIKey();
        $User = new Models\User();
        
        if (!array_key_exists('apiKey', $this->request)) {
            throw new Exception('No API Key provided');
        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
            throw new Exception('Invalid API Key');
        } else if (array_key_exists('token', $this->request) &&
            !$User->get('token', $this->request['token'])) {
                throw new Exception('Invalid User Token');        
        }
        
        $this->User = $User;
    }
    
    /*
     * 
     */
    protected function users() {
        if ($this->method == 'GET') {
            return json_encode($this->User->getUsers());
        } else {
            return "Only accepts GET requests";
        }
    }
}



?>
