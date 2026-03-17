<?php

namespace App\DTO;

class ProductDTO
{
    public function __construct(
        public int $external_id,
        public string $title,
        public float $price,
        public ?string $description,
        public string $category,
        public ?string $image,
        public float $rating_rate,
        public int $rating_count
    ){}

    public static function fromApi(array $data): self
    {
        return new self(
            external_id: $data['id'],
            title: $data['title'],
            price: $data['price'],
            description: $data['description'] ?? null,
            category: $data['category'],
            image: $data['image'] ?? null,
            rating_rate: $data['rating']['rate'],
            rating_count: $data['rating']['count']
        );
    }
}