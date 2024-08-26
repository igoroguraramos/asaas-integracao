<?php

namespace AsaasIntegracao\Application;

use AsaasIntegracao\Application\Services\ClienteService;
use AsaasIntegracao\Application\Services\CobrancaService;
use AsaasIntegracao\Domain\Config;

class Asaas
{
    private ClienteService $cliente;
    private CobrancaService $cobranca;

    public function __construct(Config $config)
    {
        $this->cliente = new ClienteService($config);
        $this->cobranca = new CobrancaService($config);
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
