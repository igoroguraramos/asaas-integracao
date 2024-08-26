<?php

namespace AsaasIntegracao\Tests\Application\Services;

use PHPUnit\Framework\TestCase;
use AsaasIntegracao\Application\Services\CobrancaService;
use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Domain\Entities\Cobranca;
use PHPUnit\Framework\MockObject\MockObject;

class CobrancaServiceTest extends TestCase
{
    /** @var Config&MockObject */
    private $configMock;

    /** @var CobrancaService&MockObject */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configMock = $this->createMock(Config::class);
        $this->subject = new CobrancaService($this->configMock);
    }

    public function testIndex()
    {
        $response = '[{"id": "1", "customer": "cus_G7Dvo4iphUNk"}]';

        $this->subject = $this->getMockBuilder(CobrancaService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with('/api/v3/payments', 'GET', [])
            ->willReturn($response);

        $result = $this->subject->index();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('customer', $result[0]);
    }

    public function testCreate()
    {
        $payload = ['customer' => 'cus_G7Dvo4iphUNk'];
        $response = $this->mockResponse();

        $this->subject = $this->getMockBuilder(CobrancaService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with('/api/v3/payments', 'POST', ['form_params' => $payload])
            ->willReturn($response);

        $actual = $this->subject->create($payload);

        $this->assertInstanceOf(Cobranca::class, $actual);
        $this->assertEquals('1', $actual->id);
        $this->assertEquals('cus_G7Dvo4iphUNk', $actual->customer);
    }

    public function testShow()
    {
        $id = '1';
        $response = $this->mockResponse();

        $this->subject = $this->getMockBuilder(CobrancaService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with("/api/v3/payments/$id", 'GET', [])
            ->willReturn($response);

        $actual = $this->subject->show($id);

        $this->assertInstanceOf(Cobranca::class, $actual);
        $this->assertEquals('1', $actual->id);
        $this->assertEquals('cus_G7Dvo4iphUNk', $actual->customer);
    }

    public function testUpdate()
    {
        $id = '1';
        $payload = ['customer' => 'cus_G7Dvo4iphUNk'];
        $response = $this->mockResponse();

        $this->subject = $this->getMockBuilder(CobrancaService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with("/api/v3/payments/$id", 'PUT', ['json' => $payload])
            ->willReturn($response);

        $actual = $this->subject->update($id, $payload);

        $this->assertInstanceOf(Cobranca::class, $actual);
        $this->assertEquals('1', $actual->id);
        $this->assertEquals('cus_G7Dvo4iphUNk', $actual->customer);
    }

    public function testDelete()
    {
        $id = '1';
        $response = 'deleted';

        $this->subject = $this->getMockBuilder(CobrancaService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with("/api/v3/payments/$id", 'DELETE', [])
            ->willReturn($response);

        $result = $this->subject->delete($id);

        $this->assertTrue($result);
    }

    public function testRestore()
    {
        $id = '1';
        $response = true;

        $this->subject = $this->getMockBuilder(CobrancaService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with("/api/v3/payments/$id/restore", 'POST', [])
            ->willReturn($response);

        $result = $this->subject->restore($id);

        $this->assertTrue($result);
    }

    public function mockResponse()
    {
        return '{"id": "1", "customer": "cus_G7Dvo4iphUNk"}';
    }
}
