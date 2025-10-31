<?php

namespace Itau\API;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Itau\API\Exception\ItauException;

/**
 * Class HttpClientRequest
 * 
 * Nova implementação do Request usando Illuminate\Http\Client\PendingRequest
 * em vez de curl_exec
 *
 * @package Itau\API
 */
class HttpClientRequest
{
    public const CURL_TYPE_POST = "POST";
    public const CURL_TYPE_PUT = "PUT";
    public const CURL_TYPE_GET = "GET";
    public const CURL_TYPE_DELETE = "DELETE";

    /**
     * HttpClientRequest constructor.
     *
     * @param Itau $credentials
     */
    public function __construct(Itau $credentials)
    {
        if ($credentials->getClientId() == "") return;

        if (! $credentials->getAuthorizationToken()) {
            $this->auth($credentials);
        }
    }

    /**
     * Cria uma instância do PendingRequest com configurações padrão
     *
     * @param Itau $credentials
     * @return PendingRequest
     */
    private function createHttpClient(Itau $credentials): PendingRequest
    {
        $client = Http::timeout(60)
            ->connectTimeout(60)
            ->withoutVerifying(); // Equivalente a CURLOPT_SSL_VERIFYPEER => 0

        // TODO: usar certificados somente em PROD
        // if ($credentials->getCertificate()) {
        //     $client->withOptions([
        //         'cert' => $credentials->getCertificate(),
        //         'ssl_key' => $credentials->getCertificateKey(),
        //     ]);
        // }

        return $client;
    }

    public function auth(Itau $credentials)
    {
        $endpoint = $credentials->getEnvironment()->getApiUrlAuth();

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'x-itau-correlationID' => '2',
            'x-itau-flowID' => '1',
            'User-Agent' => 'Itau-api-php/1.0',
        ];

        $request = [
            'grant_type' => 'client_credentials',
            'client_id' => $credentials->getClientId(),
            'client_secret' => $credentials->getClientSecret()
        ];

        // try {
        $response = $this->createHttpClient($credentials)
            ->withHeaders($headers)
            ->asForm()
            ->post($endpoint);

        $statusCode = $response->status();

        if ($statusCode >= 400) {
            throw new ItauException($response->body(), 100);
        }

        // Status code 204 don't have content
        if ($statusCode === 204) {
            return [
                'status_code' => 204
            ];
        }

        if ($response->failed()) {
            throw new ItauException("Request failed: " . $response->body(), $statusCode);
        }

        $responseDecode = $response->json();

        if (is_array($responseDecode) && isset($responseDecode['error'])) {
            throw new ItauException($responseDecode['error_description'], 100);
        }

        $credentials->setAuthorizationToken($responseDecode["access_token"]);
        return $credentials;

        // } catch (Exception $e) {
        //     if ($e instanceof ItauException) {
        //         throw $e;
        //     }
        //     throw new ItauException($e->getMessage(), 100);
        // }
    }

    public function solicitacaoCertificado(Itau $credentials, $token, $conteudoCertificado)
    {
        $endpoint = "https://sts.itau.com.br/seguranca/v1/certificado/solicitacao";

        $headers = [
            'Content-Type' => 'text/plain',
            'Authorization' => 'Bearer ' . $token,
        ];

        try {
            $response = $this->createHttpClient($credentials)
                ->withHeaders($headers)
                ->withBody($conteudoCertificado, 'text/plain')
                ->post($endpoint);

            $statusCode = $response->status();

            if ($statusCode >= 400) {
                throw new ItauException($response->body(), 100);
            }

            // Status code 204 don't have content
            if ($statusCode === 204) {
                return [
                    'status_code' => 204
                ];
            }

            if ($response->failed()) {
                throw new ItauException("Empty response: " . $response->body(), $statusCode);
            }

            return $response->body();
        } catch (Exception $e) {
            if ($e instanceof ItauException) {
                throw $e;
            }
            throw new ItauException($e->getMessage(), 100);
        }
    }

    public function get(Itau $credentials, $fullUrl, $params = null)
    {
        return $this->send($credentials, $fullUrl, self::CURL_TYPE_GET, $params);
    }

    public function post(Itau $credentials, $fullUrl, $params)
    {
        return $this->send($credentials, $fullUrl, self::CURL_TYPE_POST, $params);
    }

    public function patch(Itau $credentials, $fullUrl, $params = null)
    {
        return $this->send($credentials, $fullUrl, 'PATCH', $params);
    }

    private function send(Itau $credentials, $fullUrl, $method, $jsonBody = null)
    {
        $defaultHeaders = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Bearer ' . $credentials->getAuthorizationToken(),
            'x-itau-apikey' => $credentials->getClientId(),
            'x-itau-correlationID' => '2',
            'User-Agent' => 'Itau-api-php/1.0',
        ];

        try {
            $client = $this->createHttpClient($credentials)->withHeaders($defaultHeaders);

            // Preparar o body se necessário
            if (!empty($jsonBody)) {
                $body = is_string($jsonBody) ? $jsonBody : json_encode($jsonBody);
                $client = $client->withBody($body, 'application/json');
            }

            // Executar requisição baseada no método
            $response = match (strtoupper($method)) {
                self::CURL_TYPE_GET => $client->get($fullUrl),
                self::CURL_TYPE_POST => $client->post($fullUrl),
                self::CURL_TYPE_PUT => $client->put($fullUrl),
                self::CURL_TYPE_DELETE => $client->delete($fullUrl),
                'PATCH' => $client->patch($fullUrl),
                default => throw new ItauException("Unsupported HTTP method: $method", 100),
            };

            $statusCode = $response->status();

            if ($statusCode >= 400) {
                throw new ItauException($response->body(), 100);
            }

            $responseDecode = $response->json();

            if (is_null($responseDecode)) {
                $responseDecode = ['status_code' => $statusCode];
            } else {
                $responseDecode['status_code'] = $statusCode;
            }

            return $responseDecode;
        } catch (Exception $e) {
            if ($e instanceof ItauException) {
                throw $e;
            }
            throw new ItauException("Request Exception, error: {$e->getMessage()}", 100);
        }
    }

    public function renovarCertificado(Itau $credentials, $conteudoCertificado)
    {
        $endpoint = "https://sts.itau.com.br/seguranca/v2/certificado/renovacao";

        $headers = [
            'Content-Type' => 'text/plain',
            'Authorization' => 'Bearer ' . $credentials->getAuthorizationToken(),
            'x-itau-apikey' => $credentials->getClientId(),
            'x-itau-correlationID' => '2',
        ];

        try {
            $client = $this->createHttpClient($credentials)
                ->withHeaders($headers)
                ->withBody($conteudoCertificado, 'text/plain');

            // TODO: Configurar certificados quando necessário
            // if ($credentials->getCertificate()) {
            //     $client = $client->withOptions([
            //         'cert' => $credentials->getCertificate(),
            //         'ssl_key' => $credentials->getCertificateKey(),
            //         'verify' => $credentials->getCertificate(),
            //     ]);
            // }

            $response = $client->post($endpoint);
            $statusCode = $response->status();

            if ($statusCode >= 400) {
                throw new ItauException($response->body(), 100);
            }

            // Status code 204 don't have content
            if ($statusCode === 204) {
                return [
                    'status_code' => 204
                ];
            }

            if ($response->failed()) {
                throw new ItauException("Empty response: " . $response->body(), $statusCode);
            }

            return $response->body();
        } catch (Exception $e) {
            if ($e instanceof ItauException) {
                throw $e;
            }
            throw new ItauException($e->getMessage(), 100);
        }
    }
}
