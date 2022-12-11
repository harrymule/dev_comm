<?php

namespace App\Console\Commands;

use App\Models\main_data;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldEntries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'old_entries:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        main_data::where('created_at', '<', Carbon::now()->subDays(30)->toDateTimeString() )->each(function ($record) {
            $record->delete();
        });
    }
}
