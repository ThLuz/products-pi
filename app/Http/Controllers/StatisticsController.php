<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function __invoke()
    {
        return [

            'total_products'=>Product::count(),

            'average_price'=>Product::avg('price'),

            'highest_price'=>Product::max('price'),

            'lowest_price'=>Product::min('price'),

            'categories_count'=>Product::select(
                'category',
                DB::raw('count(*) as total')
            )->groupBy('category')->get()
        ];
    }
}
