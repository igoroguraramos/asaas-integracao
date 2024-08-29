<?php

namespace AsaasIntegracao\Application\Services;

use Exception;
use GuzzleHttp\Client;
use AsaasIntegracao\Domain\Config;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class Service
{
    protected $pathApi;
    protected $client;
    private const JSON_CONTENT_TYPE = 'Content-Type: application/json';

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
        $result = null;

        $uri = $this->pathApi;
        $uri .= $url;

        try {
            $response = $this->client->request($method, $uri, $options);

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

    public function setPathUrl($pathUrl)
    {
        $this->pathApi .= "/$pathUrl";
    }
}
