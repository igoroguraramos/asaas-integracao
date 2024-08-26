<?php

namespace AsaasIntegracao\Domain;

class Config {
    public $accessToken;
    public $baseUri = "https://sandbox.asaas.com";
    public $ssl = true;
    public $version = "v3";
    public $userAgent = "x";

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
