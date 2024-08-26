<?php

namespace AsaasIntegracao\Application\Services;

use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Domain\Entities\Cobranca;

class CobrancaService extends AbstractService
{
    public function __construct(Config $config)
    {
        parent::__construct($config, "payments");
    }

    /**
     * Cria um objeto cobrança a partir da resposta da API.
     *
     * @param string $response
     * @return Cobranca
     */
    protected function createEntityFromResponse(string $response): Cobranca
    {
        $data = json_decode($response, true);
        return new Cobranca($data);
    }

    public function getLinhaDigitavel($id)
    {
        return $this->api("$this->pathApi/$id/identificationField");
    }
    
    public function getQrCode($id)
    {
        return $this->api("$this->pathApi/$id/pixQrCode");
    }
}
