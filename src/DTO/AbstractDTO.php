<?php

declare(strict_types=1);

namespace B4x\FirmaoApi\DTO;

abstract class AbstractDTO implements \JsonSerializable
{
//     public function jsonSerialize(): array
//     {
//         return array_filter(get_object_vars($this), fn($value) => $value !== null);
//     }
// }
public function jsonSerialize(): array
{
    $data = [];
    $reflectionClass = new \ReflectionClass($this);
    foreach ($reflectionClass->getProperties() as $property) {
        $property->setAccessible(true);
        $key = $property->getName();
        $value = $property->getValue($this);
        if (($value !== null && !is_array($value)) || (is_array($value) && !empty($value))) {
            $data[$key] = $value;
        }
    }
    return $data;
}
}