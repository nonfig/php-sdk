<?php

require 'vendor/autoload.php';
require 'NConfiguration.php';
/**
 * @class Nonfig Base API Wrapper
 */
class Nonfig {
    /**
     * @var string Application ID of a Consumer
     */
    public $appId;
    /**
     * @var string Application Secret of a Consumer
     */
    public $appSecret;
    /**
     * @var string Defaults to RESTful APIs URL
     */
    public $baseUrl;
    /**
     * @var string URI base path for configuration
     */
    public $apiUrl;

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

        if (count($configurations) == 0) {
            throw new Exception(
                "Unable to find a Configuration with id(" . $id . ")"
            );
        }

        return $this->toNonfigConfigResponse($configurations, true);
    }

    function findConfigurationByName($name) {
        $response = $this->executeRequest("configurations/name/" . $name);

        $this->handleError($response);
        $configurations = $response->body->data;

        if (count($configurations) == 0) {
            throw new Exception(
                "Unable to find a Configuration with name(" . $name . ")"
            );
        }

        return $this->toNonfigConfigResponse($configurations, true);
    }

    function findConfigurationByPath($path) {
        $response = $this->executeRequest("configurations/path/" . $path);

        $this->handleError($response);

        return $this->toNonfigConfigResponse($response->body->data, false);
    }

    function findConfigurationByLabels($labels) {
        $response = $this->executeRequest("configurations/labels/" . $labels);

        $this->handleError($response);

        return $this->toNonfigConfigResponse($response->body->data, false);
    }

    function executeRequest($path) {
        return Httpful\Request::get($this->apiUrl . "/" . $path)
            ->addHeader(
                "Authorization",
                "Bearer " . $this->appId . ":" . $this->appSecret
            )
            ->send();
    }

    function toNonfigConfigResponse($data, $single = true) {
        if ($single == true) {
            $configuration = new NConfiguration();
            $configuration->load($data[0]);

            return $configuration;
        }

        $arr = array();

        foreach ($data as $row) {
            $configuration = new NConfiguration();
            $configuration->load($row);

            $arr[] = $configuration;
        }

        return $arr;
    }

    function handleError($response) {
        if ($response->code >= 400) {
            throw new Exception("Failed to fetch configuration");
        }
    }
}

?>
