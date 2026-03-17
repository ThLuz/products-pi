<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function list(array $filters)
    {
        $query = Product::query();

        if(isset($filters['price_min'])){
            $query->where('price','>=',$filters['price_min']);
        }

        if(isset($filters['price_max'])){
            $query->where('price','<=',$filters['price_max']);
        }

        if(isset($filters['category'])){
            $query->where('category',$filters['category']);
        }

        if(isset($filters['search'])){
            $query->where('title','like','%'.$filters['search'].'%');
        }

        if(isset($filters['rating_min'])){
            $query->where('rating_rate','>=',$filters['rating_min']);
        }

        // ordenar apenas campos permitidos
        $allowedSorts = ['price','title','rating_rate'];

        if(isset($filters['sort']) && in_array($filters['sort'],$allowedSorts)){
            $query->orderBy($filters['sort']);
        }

        $perPage = min($filters['per_page'] ?? 15,100);

        return $query->paginate($perPage);
    }
}