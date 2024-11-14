<?php

declare(strict_types=1);

namespace B4x\FirmaoApi\Utils;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

final class Serializer
{
    private SymfonySerializer $serializer;

    public function __construct()
    {
        $this->serializer = new SymfonySerializer(
            [new ObjectNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
    }

    public function serialize(object $data): array
    {
        $normalized = $this->serializer->normalize($data->jsonSerialize());
        return $this->flattenArray($normalized);
    }
    
    private function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];
        
        foreach ($array as $key => $value) {
            $newKey = $prefix ? $prefix . '.' . $key : $key;
            
            if (is_array($value)) {
                // Jeśli wartość jest numeryczną tablicą, nie spłaszczaj jej
                if (array_keys($value) === range(0, count($value) - 1)) {
                    $result[$newKey] = $value;
                } else {
                    $result = array_merge($result, $this->flattenArray($value, $newKey));
                }
            } else {
                $result[$newKey] = $value;
            }
        }
        
        return $result;
    }

    public function deserialize(array $data, string $type): object
    {
        return $this->serializer->denormalize($data, $type);
    }

    /**
     * @return array<object>
     */
    public function deserializeArray(array $data, string $type): array
    {
        return $this->serializer->denormalize($data, $type . '[]');
    }
}
