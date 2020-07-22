<?php

// includes Httpful library
require "util/httpful.phar";

// $url = "http://search.twitter.com/search.json";
// $query = urlencode("#PHP");
// $response = Httpful\Request::get($url . "?q=$query")->send();

// echo "<pre>";
// print_r($response);

class Nonfig {
    
    function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->baseUrl = "https://app.nonfig.com";
        $this->apiUrl = $this->baseUrl . "/api/v1";
    }
    
    function findConfigurationById($id) {
        print($this->apiUrl);
    }
    
    function executeRequest() {
    
    }
}

// pls remove this below
$nonfig = new Nonfig("a", "b");
$nonfig->findConfigurationById("a");

?>
