<?php

namespace AsaasIntegracao\Domain;

class Config {
    public $accessToken;
    public $baseUri = "https://sandbox.asaas.com";
    public $ssl = true;
    public $version = "v3";
    public $userAgent = "x";
    public $production = true;
    public $pathUrl;

    public function __construct(array $data = [])
    {
        $production = $data["production"] ?? $this->production;
        
        $this->pathUrl = "/api/$this->version";

        if($production)
        {
            $this->baseUri =  "https://api.asaas.com";
            $this->pathUrl =  "/$this->version";
        }

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
