<?php

declare(strict_types=1);

namespace B4x\FirmaoApi\DTO;

final class Semiproduct extends AbstractDTO
{
    public function __construct(
        private ?float $currentStoreState = null,
        private ?int $id = null,
        private ?array $parent = null,
        private ?array $permissions = null,
        private ?array $product = null,
        private ?string $productCode = null,
        private ?float $quantity = null,
        private ?string $unit = null
    ) {
    }

    public function getCurrentStoreState(): ?float
    {
        return $this->currentStoreState;
    }

    public function setCurrentStoreState(?float $currentStoreState): self
    {
        $this->currentStoreState = $currentStoreState;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getParent(): ?array
    {
        return $this->parent;
    }

    public function setParent(?array $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    public function getPermissions(): ?array
    {
        return $this->permissions;
    }

    public function setPermissions(?array $permissions): self
    {
        $this->permissions = $permissions;
        return $this;
    }

    public function getProduct(): ?array
    {
        return $this->product;
    }

    public function setProduct(?array $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(?string $productCode): self
    {
        $this->productCode = $productCode;
        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;
        return $this;
    }
}