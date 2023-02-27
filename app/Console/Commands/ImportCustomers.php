<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minicli\Curly\Client;
use Illuminate\Support\Facades\Storage;
use App\Models\Customers; 

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Customers to mysql';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file_n = storage_path('app\customers.csv');
        $file = fopen($file_n, "r");
        $all_data = array();
        while (($data = fgetcsv($file, 200, ",")) !==FALSE) {

            Customers::create([
            'job_title' => $data[1],
            'email_address' => $data[2],
            'first_last_name' => $data[3],
            'registered_since' => $data[4],
            'phone' => $data[5]
        ]);
            
      
        }
          
        fclose($file);
     
        
        return Command::SUCCESS;
    }
}
