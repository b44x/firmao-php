<?php

declare(strict_types=1);

namespace B4x\FirmaoApi\Http;

use B4x\FirmaoApi\Exception\FirmaoApiException;
use Psr\Http\Message\ResponseInterface;

final class ResponseHandler
{
    public function handle(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();
        $data = json_decode($body, true);

        if ($statusCode >= 400) {
            throw new FirmaoApiException(
                $data['message'] ?? 'Unknown error occurred',
                $statusCode
            );
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new FirmaoApiException('Invalid JSON response from API');
        }

        // Jeśli mamy changelog, wyciągnij ID z pierwszego wpisu
        if (isset($data['changelog']) && !empty($data['changelog'])) {
            $data['id'] = $data['changelog'][0]['objectId'];
        }

        return $data;
    }
}