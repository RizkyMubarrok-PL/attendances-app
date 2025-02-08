<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Attendances;

class DeleteAttendancesToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-attendances-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Attendances $attendances)
    {
        $count = $attendances->whereDate('created_at', now())->count();

        if ($count > 0) {
            $attendances->whereDate('created_at', now())->delete();
            Log::info("Deleted $count attendance records from today.");
            $this->info("Successfully deleted $count attendance records.");
        } else {
            Log::info("No attendance records found for deletion.");
            $this->info("No attendance records found to delete.");
        }
    }
}
