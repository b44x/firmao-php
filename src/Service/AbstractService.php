<?php

declare(strict_types=1);

namespace B4x\FirmaoApi\Service;

use B4x\FirmaoApi\Client\FirmaoClientInterface;
use B4x\FirmaoApi\Exception\FirmaoApiException;
use B4x\FirmaoApi\Http\ResponseHandler;
use B4x\FirmaoApi\Utils\Serializer;

abstract class AbstractService
{
    public function __construct(
        protected FirmaoClientInterface $client,
        protected ResponseHandler $responseHandler,
        protected Serializer $serializer
    ) {
    }

    protected function buildQueryParams(array $filters = [], ?int $start = null, ?int $limit = null, ?string $sort = null, ?string $dir = null): array
    {
        $params = [];

        if (!empty($filters)) {
            foreach ($filters as $field => $filter) {
                if (is_array($filter)) {
                    $params[$field . '(' . $filter['operator'] . ')'] = $filter['value'];
                }
            }
        }

        if ($start !== null) {
            $params['start'] = $start;
        }

        if ($limit !== null) {
            $params['limit'] = $limit;
        }

        if ($sort !== null) {
            $params['sort'] = $sort;
        }

        if ($dir !== null) {
            $params['dir'] = $dir;
        }

        return $params;
    }
}