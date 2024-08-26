<?php

namespace AsaasIntegracao\Tests\Application;

use PHPUnit\Framework\TestCase;
use AsaasIntegracao\Application\Asaas;
use AsaasIntegracao\Application\Services\ClienteService;
use AsaasIntegracao\Application\Services\CobrancaService;
use AsaasIntegracao\Domain\Config;

class AsaasTest extends TestCase
{
    public function testClienteServiceIsInstantiated()
    {
        /** @var Config $configMock */
        $configMock = $this->createMock(Config::class);

        $asaas = new Asaas($configMock);

        $this->assertInstanceOf(ClienteService::class, $asaas->cliente());
    }
    public function testCobrancaServiceIsInstantiated()
    {
        /** @var Config $configMock */
        $configMock = $this->createMock(Config::class);

        $asaas = new Asaas($configMock);

        $this->assertInstanceOf(CobrancaService::class, $asaas->cobranca());
    }
}
