<?php

namespace AsaasIntegracao\Application\Services;

use Exception;
use GuzzleHttp\Client;
use AsaasIntegracao\Domain\Config;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use AsaasIntegracao\Domain\Exceptions\ApiRequestException;

class Service
{
    protected $pathApi;
    protected $client;

    public function __construct(Config $config)
    {
        $this->pathApi = $config->pathUrl;

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

    public function api($url = "/", $method = "GET", $options = [])
    {
        $uri = $this->pathApi . $url;

        try {
            $response = $this->client->request($method, $uri, $options);
            return $response->getBody()->getContents();
        } catch (ClientException | ServerException | RequestException $e) {
            $response = $e->getResponse();
            $statusCode = $response ? $response->getStatusCode() : 500;
            $body = $response ? $response->getBody()->getContents() : null;

            $detail = $this->extractErrorMessage($body);

            $problemDetails = [
                'type' => 'api-error',
                'title' => 'Erro na API',
                'status' => $statusCode,
                'detail' => $detail,
                'instance' => $uri,
            ];

            throw new ApiRequestException($problemDetails, $statusCode);
        } catch (ConnectException $e) {
            $problemDetails = [
                'type' => 'api-error',
                'title' => 'Falha de conexão com a API',
                'status' => 503,
                'detail' => 'Não foi possível conectar com a API.',
                'instance' => $uri,
            ];

            throw new ApiRequestException($problemDetails, 503);
        } catch (\Throwable $e) {
            $problemDetails = [
                'type' => 'api-error',
                'title' => 'Erro interno inesperado',
                'status' => 500,
                'detail' => 'Ocorreu um erro interno inesperado.',
                'instance' => $uri,
            ];

            throw new ApiRequestException($problemDetails, 500, $e);
        }
    }

    protected function extractErrorMessage(?string $body): string
    {
        $message = 'Erro desconhecido';

        if ($body) {
            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $message = 'Erro de resposta não interpretável';
            } elseif (isset($data['errors']) && is_array($data['errors'])) {
                $message = implode('; ', array_map(function ($err) {
                    return $err['description'] ?? $err['code'] ?? 'Erro';
                }, $data['errors']));
            } elseif (isset($data['message'])) {
                $message = $data['message'];
            }
        }

        return $message;
    }

    protected function sendProblemDetailsResponse(string $type, string $title, int $status, string $detail, string $instance = ''): void
    {
        http_response_code($status);
        header('Content-Type: application/problem+json');
        echo json_encode([
            'type' => $type,
            'title' => $title,
            'status' => $status,
            'detail' => $detail,
            'instance' => $instance
        ]);
    }


    public function setPathUrl($pathUrl)
    {
        $this->pathApi .= "/$pathUrl";
    }
}
