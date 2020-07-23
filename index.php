<?php

require 'vendor/autoload.php';

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

        throw new Exception(
            "Unable to find a Configuration with id(" . $id . ")"
        );
    }

    function findConfigurationByName($name) {
        $response = $this->executeRequest("configurations/name/" . $name);

        $this->handleError($response);
        $configurations = $response->body->data;

        if (count($configurations) > 0) {
            return $configurations[0];
        }

        throw new Exception(
            "Unable to find a Configuration with name(" . $name . ")"
        );
    }

    function findConfigurationByPath($path) {
        $response = $this->executeRequest("configurations/path/" . $path);

        $this->handleError($response);

        return $response->body->data;
    }

    function executeRequest($path) {
        return Httpful\Request::get($this->apiUrl . "/" . $path)
            ->addHeader(
                "Authorization",
                "Bearer " . $this->appId . ":" . $this->appSecret
            )
            ->send();
    }

    function handleError($response) {
        if ($response->body->statusCode >= 400) {
            print_r($response);

            throw new Exception("Failed to fetch configuration");
        }
    }
}

?>
