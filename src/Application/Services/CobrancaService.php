<?php

namespace AsaasIntegracao\Application\Services;

use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Domain\Entities\Cobranca;

class CobrancaService extends AbstractService
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->setPathUrl("payments");
    }

    /**
     * Cria um objeto cobrança a partir da resposta da API.
     *
     * @param string $response
     * @return Cobranca
     */
    protected function createEntityFromResponse(string $response): Cobranca
    {
        $data = $this->handleApiResponse($response);
        return new Cobranca($data);
    }

    public function getLinhaDigitavel($id)
    {
        return json_decode($this->api("/$id/identificationField"), true);
    }
    
    public function getQrCode($id)
    {
        return json_decode($this->api("/$id/pixQrCode"), true);
    }
}
