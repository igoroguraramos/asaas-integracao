<?php

namespace AsaasIntegracao\Application;

use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Application\Services\Service;
use AsaasIntegracao\Application\Services\ClienteService;
use AsaasIntegracao\Application\Services\CobrancaService;

class Asaas
{
    private ClienteService $cliente;
    private CobrancaService $cobranca;
    private Service $service;

    public function __construct(Config $config)
    {
        $this->cliente = new ClienteService($config);
        $this->cobranca = new CobrancaService($config);
        $this->service = new Service($config);
    }

    public function api($pathUrl, $method = "GET", $payload = [])
    {
        $options = [];

        if($method !== "GET") {
            $keyArray = $method === "POST" ? "form_params" : "json";
            $options = [$keyArray => $payload];
        }

        $response = $this->service->api($pathUrl, $method, $options);
        return json_decode($response, true);
    }

    public function cliente()
    {
        return $this->cliente;
    }

    public function cobranca()
    {
        return $this->cobranca;
    }
}
