<?php

declare(strict_types=1);

namespace B4x\FirmaoApi\Client;

use B4x\FirmaoApi\Config\Configuration;
use B4x\FirmaoApi\Exception\FirmaoApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

final class FirmaoClient implements FirmaoClientInterface
{
    private Client $httpClient;

    public function __construct(
        private readonly Configuration $config,
        private readonly LoggerInterface $logger
    ) {
        $this->httpClient = new Client([
            'base_uri' => $this->config->getBaseUrl(),
            'headers' => [
                'Authorization' => $this->config->getAuthorizationHeader(),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function get(string $endpoint, array $params = []): ResponseInterface
    {
        return $this->request('GET', $endpoint, ['query' => $params]);
    }

    public function post(string $endpoint, array $data = []): ResponseInterface
    {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    public function put(string $endpoint, array $data = []): ResponseInterface
    {
        return $this->request('PUT', $endpoint, ['json' => $data]);
    }

    public function delete(string $endpoint): ResponseInterface
    {
        return $this->request('DELETE', $endpoint);
    }

    private function request(string $method, string $endpoint, array $options = []): ResponseInterface
    {
        $fullEndpoint = sprintf('/%s/svc/v1/%s', $this->config->getOrganizationId(), ltrim($endpoint, '/'));

        // $options['debug'] = true; // Enable logging for debugging purposes
        $options['verify'] =false;
        try {
            $this->logger->debug('Sending request to Firmao API', [
                'method' => $method,
                'endpoint' => $fullEndpoint,
                'options' => $options,
            ]);

            $response = $this->httpClient->request($method, $fullEndpoint, $options);

            $this->logger->debug('Received response from Firmao API', [
                'statusCode' => $response->getStatusCode(),
                'body' => (string) $response->getBody(),
            ]);

            return $response;
        } catch (GuzzleException $e) {
            $this->logger->error('Error while sending request to Firmao API', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            throw new FirmaoApiException(
                'Error while sending request to Firmao API: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}