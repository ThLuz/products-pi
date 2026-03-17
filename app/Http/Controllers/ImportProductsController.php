<?php

namespace App\Http\Controllers;

use App\Services\ProductImportService;

class ImportProductsController extends Controller
{
    public function __invoke(ProductImportService $service)
    {
        return response()->json(
            $service->import()
        );
    }
}
