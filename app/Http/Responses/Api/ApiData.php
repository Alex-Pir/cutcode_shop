<?php

namespace App\Http\Responses\Api;

use Illuminate\Contracts\Support\Arrayable;

final readonly class ApiData implements Arrayable
{
    public function __construct(
        private string $type,
        private int|string $id,
        private array $attributes
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'attributes' => $this->getAttributes(),
        ];
    }
}
