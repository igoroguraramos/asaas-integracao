<?php

namespace AsaasIntegracao\Application\Services;

use Exception;
use GuzzleHttp\Client;
use AsaasIntegracao\Domain\Config;
use AsaasIntegracao\Domain\Entities\AbstractEntity;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

abstract class AbstractService
{
    abstract protected function createEntityFromResponse(string $response);

    protected $pathApi;
    protected $client;
    private const JSON_CONTENT_TYPE = 'Content-Type: application/json';

    public function __construct(Config $config, $pathApi)
    {
        $this->pathApi = "/api/$config->version/$pathApi";
        
        $this->client = new Client(
            [
                "base_uri" => $config->baseUri,
                "verify" => $config->ssl,
                "headers" => [
                    'Content-Type' => 'application/json',
                    "User-Agent" => $config->userAgent,
                    "access_token" => $config->accessToken,
                ]
            ]
        );
    }

    public function api($url, $method = "GET", $options = [])
    {
        $result = null;

        try {
            $response = $this->client->request($method, $url, $options);

            $result = $response->getBody()->getContents();
        } catch (ClientException $e) {
            header(self::JSON_CONTENT_TYPE, true, $e->getCode());
            $result = json_encode([
                "error" => $e->getMessage()
            ]);
        } catch (ServerException $e) {
            header(self::JSON_CONTENT_TYPE, true, $e->getCode());
            $result = json_encode([
                "error" => $e->getMessage()
            ]);
        } catch (ConnectException $e) {
            header(self::JSON_CONTENT_TYPE, true, $e->getCode());
            $result = json_encode([
                "error" => $e->getMessage()
            ]);
        } catch (RequestException $e) {
            header(self::JSON_CONTENT_TYPE, true, $e->getCode());
            $result = json_encode([
                "error" => $e->getMessage()
            ]);
        } catch (Exception $e) {
            header(self::JSON_CONTENT_TYPE, true, $e->getCode());
            $result = json_encode([
                "error" => $e->getMessage()
            ]);
        }

        return $result;
    }

    /**
     * Listar
     *
     * @return array
     */
    public function index(): array
    {
        $response = $this->api($this->pathApi);
        return json_decode($response, true);
    }

    /**
     * Criar
     *
     * @param array $payload
     */
    public function create(array $payload)
    {
        $response = $this->api($this->pathApi, "POST", ["form_params" => $payload]);
        return $this->createEntityFromResponse($response);
    }

    /**
     * Mostrar
     *
     * @param string $id
     */
    public function show(string $id)
    {
        $response = $this->api("$this->pathApi/$id");
        return $this->createEntityFromResponse($response);
    }

    /**
     * Atualizar
     *
     * @param string $id
     * @param array $payload
     */
    public function update(string $id, array $payload)
    {
        $response = $this->api("$this->pathApi/$id", "PUT", ["json" => $payload]);
        return $this->createEntityFromResponse($response);
    }

    /**
     * Excluir
     *
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->api("$this->pathApi/$id", "DELETE");
    }

    /**
     * Restaurar Exclusão
     *
     * @param string $id
     * @return bool
     */
    public function restore(string $id): bool
    {
        return $this->api("$this->pathApi/$id/restore", "POST");
    }
}
