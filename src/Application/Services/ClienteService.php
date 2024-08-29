<?php

namespace AsaasIntegracao\Application\Services;

use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Domain\Entities\Cliente;

class ClienteService extends AbstractService
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->setPathUrl("customers");
    }

    /**
     * Cria um objeto Cliente a partir da resposta da API.
     *
     * @param string $response
     * @return Cliente
     */
    protected function createEntityFromResponse(string $response): Cliente
    {
        $data = json_decode($response, true);
        return new Cliente($data);
    }
}
