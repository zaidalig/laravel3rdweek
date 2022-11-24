<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

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
        Product::where('status', 'A')
            ->update(['status' => 'Approved', 'approved_at' => Carbon::now()]);
        $this->info('All Products Are Approved');

    }
}
