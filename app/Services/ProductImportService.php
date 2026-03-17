<?php

namespace App\Services;

use App\Models\Product;
use App\DTO\ProductDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductImportService
{
    public function import(): array
    {
        try {

            $response = Http::retry(3,1000)
                ->get('https://fakestoreapi.com/products');

            if(!$response->successful()){
                Log::error('API externa falhou');
                return ['error' => true];
            }

            $products = $response->json();

            $imported = 0;
            $updated = 0;
            $skipped = 0;

            foreach($products as $item){

                $dto = ProductDTO::fromApi($item);

                $product = Product::withTrashed()
                    ->where('external_id',$dto->external_id)
                    ->first();

                $data = (array) $dto;

                if(!$product){

                    Product::create($data);
                    $imported++;

                    continue;
                }

                // se estiver deletado, restaurar
                if($product->trashed()){
                    $product->restore();
                }

                // verificar se mudou algo
                $hasChanges = false;

                foreach($data as $field => $value){
                    if($product->$field != $value){
                        $hasChanges = true;
                        break;
                    }
                }

                if(!$hasChanges){
                    $skipped++;
                    continue;
                }

                $product->update($data);
                $updated++;
            }

            Log::info('product_import',[
                'imported'=>$imported,
                'updated'=>$updated,
                'skipped'=>$skipped
            ]);

            return [
                'imported'=>$imported,
                'updated'=>$updated,
                'skipped'=>$skipped
            ];

        }catch(\Exception $e){

            Log::error('Erro integração API',[
                'message'=>$e->getMessage()
            ]);

            return ['error'=>true];
        }
    }
}