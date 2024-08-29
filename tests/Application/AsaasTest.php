<?php

namespace AsaasIntegracao\Tests\Application;

use PHPUnit\Framework\TestCase;
use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Application\Asaas;
use PHPUnit\Framework\MockObject\MockObject;
use AsaasIntegracao\Application\Services\Service;
use AsaasIntegracao\Application\Services\ClienteService;
use AsaasIntegracao\Application\Services\CobrancaService;

class AsaasTest extends TestCase
{
    /** @var Config&MockObject */
    private $configMock;
    private $serviceMock;
    private $asaas;

    protected function setUp(): void
    {
        $this->configMock = $this->createMock(Config::class);
        $this->serviceMock = $this->createMock(Service::class);

        $this->asaas = new Asaas($this->configMock);

        $reflection = new \ReflectionClass($this->asaas);

        $serviceProperty = $reflection->getProperty('service');
        $serviceProperty->setAccessible(true);
        $serviceProperty->setValue($this->asaas, $this->serviceMock);
    }

    public function testClienteServiceIsInstantiated()
    {
        $this->assertInstanceOf(ClienteService::class, $this->asaas->cliente());
    }

    public function testCobrancaServiceIsInstantiated()
    {
        $this->assertInstanceOf(CobrancaService::class, $this->asaas->cobranca());
    }

    public function testApiReturnsDecodedJsonResponse()
    {
        $pathUrl = '/example/path';
        $expectedResponse = ['key' => 'value'];

        $this->serviceMock->expects($this->once())
            ->method('api')
            ->with($pathUrl)
            ->willReturn(json_encode($expectedResponse));

        $result = $this->asaas->api($pathUrl);

        $this->assertSame($expectedResponse, $result);
    }
}
