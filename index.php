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
        $response = $this->executeRequest("configurations/id/" . $id);
        
        $this->handleError($response);
        $configurations = $response->body->data;
        
        if (count($configurations) > 0) {
            return $configurations[0];
        }
        
        throw new Exception("Unable to find a Configuration with id(" . $id . ")");
    }
    
    function executeRequest($path) {
        return Httpful\Request::get($this->apiUrl . "/" . $path)
            ->addHeader("Authorization", "Bearer " . $this->appId . ":" . $this->appSecret)
            ->send();
    }
    
    function handleError($response) {
        if ($response->body->success == false) {
            throw new Exception("Failed to fetch configuration");
        }
    }
}

// pls remove this below
$nonfig = new Nonfig("f1afd7c6-c570-4fc0-a08a-5ed65bf9811e", "cT99KHl4kT17ewFotCef");
$config = $nonfig->findConfigurationById("8400a3a0-9c14-47cc-b598-f5037fd5a9ce");

print_r($config);

?>
