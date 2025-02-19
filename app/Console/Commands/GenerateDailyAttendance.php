<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendances;
use App\Models\User;

class GenerateDailyAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-daily-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Attendances $attendances, User $users)
    {
        // check if there is a attendances

        $countTodayAttendances = $attendances->whereDate('created_at', now())->count();

        if ($countTodayAttendances <= 0) {
            // get all studentId and parse it to Array
            $studentsId = $users->where('role', 'siswa')->pluck('id')->toArray();

            $studentAttendances = [];
            foreach ($studentsId as $studentId) {
                $studentAttendances[] = [
                    'student_id' => $studentId,
                    'teacher_id' => null,
                    'status' => null,
                    'description' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $attendances->insert($studentAttendances);

            $this->info('Attendance records created for today.');
        } else {
            $this->info('Attendance records are already exists for today.');
        }
    }
}
