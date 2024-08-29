<?php

namespace AsaasIntegracao\Tests\Application\Services;

use PHPUnit\Framework\TestCase;
use AsaasIntegracao\Application\Services\ClienteService;
use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Domain\Entities\Cliente;
use PHPUnit\Framework\MockObject\MockObject;

class ClienteServiceTest extends TestCase
{
    /** @var Config&MockObject */
    private $configMock;

    /** @var ClienteService&MockObject */
    private $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->configMock = $this->createMock(Config::class);
        $this->subject = new ClienteService($this->configMock);
    }

    public function testIndex()
    {
        $response = '[{"id": "1", "name": "Cliente 1"}]';

        $this->subject = $this->getMockBuilder(ClienteService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with('/', 'GET', [])
            ->willReturn($response);

        $result = $this->subject->index();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
    }

    public function testCreate()
    {
        $payload = ['name' => 'Novo Cliente'];
        $response = '{"id": "1", "name": "Novo Cliente"}';

        $this->subject = $this->getMockBuilder(ClienteService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with('/', 'POST', ['form_params' => $payload])
            ->willReturn($response);

        $actual = $this->subject->create($payload);

        $this->assertInstanceOf(Cliente::class, $actual);
        $this->assertEquals('1', $actual->id);
        $this->assertEquals('Novo Cliente', $actual->name);
    }

    public function testShow()
    {
        $id = '1';
        $response = '{"id": "1", "name": "Cliente 1"}';

        $this->subject = $this->getMockBuilder(ClienteService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with("/$id", 'GET', [])
            ->willReturn($response);

        $actual = $this->subject->show($id);

        $this->assertInstanceOf(Cliente::class, $actual);
        $this->assertEquals('1', $actual->id);
        $this->assertEquals('Cliente 1', $actual->name);
    }

    public function testUpdate()
    {
        $id = '1';
        $payload = ['name' => 'Cliente Atualizado'];
        $response = '{"id": "1", "name": "Cliente Atualizado"}';

        $this->subject = $this->getMockBuilder(ClienteService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with("/$id", 'PUT', ['json' => $payload])
            ->willReturn($response);

        $actual = $this->subject->update($id, $payload);

        $this->assertInstanceOf(Cliente::class, $actual);
        $this->assertEquals('1', $actual->id);
        $this->assertEquals('Cliente Atualizado', $actual->name);
    }

    public function testDelete()
    {
        $id = '1';
        $response = 'deleted';

        $this->subject = $this->getMockBuilder(ClienteService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with("/$id", 'DELETE', [])
            ->willReturn($response);

        $result = $this->subject->delete($id);

        $this->assertTrue($result);
    }

    public function testRestore()
    {
        $id = '1';
        $response = true;

        $this->subject = $this->getMockBuilder(ClienteService::class)
            ->setConstructorArgs([$this->configMock])
            ->onlyMethods(['api'])
            ->getMock();

        $this->subject->expects($this->once())
            ->method('api')
            ->with("/$id/restore", 'POST', [])
            ->willReturn($response);

        $result = $this->subject->restore($id);

        $this->assertTrue($result);
    }
}
