<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ImportProductsJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductCsvValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_job_creates_products(): void
    {
        Storage::fake('local');
        $csv = "name,description,price,image,category,stock
"
             . "Item A,Desc,99.99,,Cat,5
";
        Storage::disk('local')->put('imports/test.csv',$csv);

        (new ImportProductsJob('imports/test.csv'))->handle();

        $this->assertDatabaseHas('products',['name'=>'Item A','stock'=>5]);
    }
}
