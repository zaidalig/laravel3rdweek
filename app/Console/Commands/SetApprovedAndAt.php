<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SetApprovedAndAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:Approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approves Products and update approved_at field with current time ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $product = Product::where('status', 'pending')->get();
        foreach ($product as $product) {

            $product->when(Carbon::now()->diffIndays($product->created_at) == 0, function ($q) {
                $data = ['approved_at' => now(), 'status' => 'Approved'];
                return $q->update($data);
            });

            $this->info('All Products Are Approved');
            Log::info('All Products Are Approved');

        }
    }
}
