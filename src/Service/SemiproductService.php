<?php

declare(strict_types=1);

namespace B4x\FirmaoApi\Service;

use B4x\FirmaoApi\DTO\Semiproduct;

final class SemiproductService extends AbstractService
{
    private const ENDPOINT = 'semiproducts';

    public function list(array $filters = [], ?int $start = null, ?int $limit = null, ?string $sort = null, ?string $dir = null): array
    {
        $params = $this->buildQueryParams($filters, $start, $limit, $sort, $dir);
        
        if (isset($filters['parent(eq)'])) {
            $params['parent(eq)'] = $filters['parent(eq)'];
        }

        $response = $this->client->get(self::ENDPOINT, $params);
        $data = $this->responseHandler->handle($response);

        return $this->serializer->deserializeArray($data['data'], Semiproduct::class);
    }

    public function getByParentId(int $parentId, ?string $sort = 'product', ?string $dir = 'ASC'): array
    {
        $params = [
            'parent(eq)' => $parentId,
            'sort' => $sort,
            'dir' => $dir
        ];

        $response = $this->client->get(self::ENDPOINT, $params);
        $data = $this->responseHandler->handle($response);

        return $this->serializer->deserializeArray($data['data'], Semiproduct::class);
    }
}