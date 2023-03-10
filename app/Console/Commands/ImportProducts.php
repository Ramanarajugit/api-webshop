<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Minicli\Curly\Client;
use Illuminate\Support\Facades\Storage;
use App\Models\Products; 
class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.test
     *
     * @var string
     */
    protected $description = 'Import products to mysql db';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // this is test command for me.
        $file_n = storage_path('app\products.csv');
        $file = fopen($file_n, "r");
        Log::info("Products import started successfully");
        while (($data = fgetcsv($file, 200, ",")) !==FALSE) {

            Products::create(['product_name' => $data[1],'price' => $data[2]]);

        }
        fclose($file);

        Log::info("Products import completed successfully");
        return Command::SUCCESS;
    }
}
