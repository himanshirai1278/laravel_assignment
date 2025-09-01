<?php

namespace App\Jobs;

use App\Models\Product;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;
    public $defaultImage;

    public $timeout = 1200;

    public function __construct(string $path, string $defaultImage = 'images/default-product.png')
    {
        $this->path = $path;
        $this->defaultImage = $defaultImage;
    }

    public function handle(): void
    {
        $localPath = storage_path('app/'.$this->path);
        $reader = ReaderEntityFactory::createReaderFromFile($localPath);
        $reader->open($localPath);

        $header = [];
        foreach ($reader->getSheetIterator() as $sheet) {
            $i = 0;
            foreach ($sheet->getRowIterator() as $row) {
                $cells = array_map(fn($c)=> trim((string)$c->getValue()), $row->getCells());
                if ($i === 0) { $header = $cells; $i++; continue; }
                $data = array_combine($header, $cells);

                if (!$data) { continue; }

                // Validation (basic)
                if (!isset($data['name']) || $data['name']==='') continue;
                if (!isset($data['price']) || !is_numeric($data['price'])) continue;
                if (!isset($data['stock']) || !is_numeric($data['stock'])) $data['stock']=0;

                Product::updateOrCreate(
                    ['name'=>$data['name']],
                    [
                        'description'=>$data['description'] ?? null,
                        'price'=>(float)$data['price'],
                        'image'=>$data['image'] ?: $this->defaultImage,
                        'category'=>$data['category'] ?? null,
                        'stock'=>(int)$data['stock'],
                    ]
                );
            }
        }
        $reader->close();

        Storage::delete($this->path);
    }
}
