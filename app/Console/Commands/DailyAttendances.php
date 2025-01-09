<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Attendances;

class DailyAttendances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-attendances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add attendances for all student every day.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            //define a today date
            $date = now();

            //get all user id
            $users = User::where('role', 'Siswa')->pluck('id')->toArray();

            //get user id from existed attendances
            $existingUserId = Attendances::whereDate('created_at', $date)->pluck('student_id')->toArray();

            //filter not exist attendances
            $notExistingUserId = array_diff($users, $existingUserId);

            //create new attendance for all user
            $newAttendances = [];

            //set all new attendances into one array
            foreach ($notExistingUserId as $user) {
                $newAttendances[] = [
                    'student_id' => $user,
                    'teacher_id' => null,
                    'status' => 'Hadir',
                    'description' => '',
                    'created_at' => $date,
                    'updated_at' => $date
                ];
            }

            if (empty($newAttendances)) {
                // if new attendance is empty just give no added info
                $this->info('No new attendances were added for today.');
            } else {
                //insert all attendances at once
                Attendances::insert($newAttendances);
                // Output success message
                $this->info('Attendances for all students added successfully!');
            }

        } catch (\Exception $e) {
            $this->info('Error ocured: '. $e->getMessage());
        }
    }
}
