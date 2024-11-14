<?php

declare(strict_types=1);

namespace B4x\FirmaoApi\Client;

use B4x\FirmaoApi\Exception\FirmaoApiException;
use Psr\Http\Message\ResponseInterface;

interface FirmaoClientInterface
{
    /**
     * @throws FirmaoApiException
     */
    public function get(string $endpoint, array $params = []): ResponseInterface;

    /**
     * @throws FirmaoApiException
     */
    public function post(string $endpoint, array $data = []): ResponseInterface;

    /**
     * @throws FirmaoApiException
     */
    public function put(string $endpoint, array $data = []): ResponseInterface;

    /**
     * @throws FirmaoApiException
     */
    public function delete(string $endpoint): ResponseInterface;
}