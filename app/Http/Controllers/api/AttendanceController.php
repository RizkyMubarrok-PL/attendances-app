<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Rules\EnumStatus;
use App\Models\Attendances;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStudentAttendance (Request $request, string $attendance_id, Attendances $attendance)
    {
        try {            
            //check exists attendance
            if (!$attendance->checkAttendance($attendance_id)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Student attendance not found.',
                    'data' => [
                        'attendances' => $attendance
                    ]
                ], 404);
            }

            //validate the request value
            $validate = $request->validate([
                'teacher_id' => 'required|exists:users,id',
                'status' => ['required', 'string', new EnumStatus],
                'description' => 'string'
            ], 
            [
                'teacher_id.required' => 'required a teacher id.',
                'teacher_id.exists' => 'Teacher id is not exists in users table.',
                'status.required' => 'Required status value.',
                'status.enum' => 'Invalid status value.'
            ]);

            //define the teacher id and status
            $teacher_id = $validate['teacher_id'];
            $status = $validate['status'];
            $description = $validate['description'];

            //update student attendance
            $attendance->updateAttendance($attendance_id, $teacher_id, $status, $description);

            //get join value of student attendance            
            $data = $attendance->getStudentAttendance($attendance_id);

            //give a success msg and the data
            return response()->json([
                'success' => true,
                'msg' => 'Update student attendance.',
                'data' => [
                    'attendances' => $data
                ]
            ], 200);
        }  catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validation Error.',
                'msg' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'There is an error.',
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function getClassAttendances(Request $request, Attendances $attendances)
    {
        try {
            $request->merge([
                'date' => $request->has('date') && $request->input('date') ?
                    Carbon::parse($request->input(['date']))->format('Y-m-d') : now()->format('Y-m-d'),
            ]);

            // if ($request->has('date')) {

            // }

            $validate = $request->validate([
                'class_id' => 'required|exists:classes,id',
                'date' => 'string|date_format:Y-m-d'
            ], [
                'class_id.exists' => 'class_id is not exists in classes table.'
            ]);

            $class_id = $validate['class_id'];
            $date = $validate['date'];

            $classAttendances = $attendances->getClassAttendance($class_id, $date);

            if ($classAttendances->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Data was Empty.',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'success' => true,
                'msg' => 'Get Attendances all student.',
                'data' => [
                    'attendances' => $classAttendances
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validation Error.',
                'msg' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'There is an error.',
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function getStudentAttendances(Request $request, Attendances $attendances)
    {
        try {
            $request->merge([
                'date_start' => $request->has('date_start') && $request->input('date_start') ?
                    Carbon::parse($request->input(['date_start']))->format('Y-m-d') : null,
                'date_end' => $request->has('date_end') && $request->input('date_end') ?
                    Carbon::parse($request->input(['date_end']))->format('Y-m-d') : null
            ]);

            $validate = $request->validate([
                'student_id' => 'required|string|exists:users,id',
                'date_start' => 'nullable|string|date_format:Y-m-d',
                'date_end' => 'nullable|string|date_format:Y-m-d',
                'status' => ['nullable', 'string', new EnumStatus()]
            ], [
                'student_id.exists' => 'student_id is not exists in users table.',
                'date_start.date_format' => 'Invalid date format.',
                'date_end.date_format' => 'Invalid date format.',
                'status.enum' => 'Invalid Enum value.'
            ]);

            $student_id = $validate['student_id'];
            $start = $validate['date_start'];
            $end = $validate['date_end'];
            $status = $validate['status'];

            $studentAttendances = $attendances->getStudentAttendances($student_id, $start, $end, $status);

            return response()->json([
                'success' => true,
                'msg' => 'Get student Attendances.',
                'data' => [
                    'input' => $validate,
                    'attendances' => $studentAttendances
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'There is a error.',
                'msg' => 'error: ' . $e
            ], 500);
        }
    }

    public function updateClassAttendances (Request $request, Attendances $attendances){
        try {
            $validate = $request->validate([
                'teacher_id' => 'required|exists:users,id',
                'attendances' => 'required|array',
                'attendances.*.attendance_id' => 'required|exists:attendances,id',
                'attendances.*.status' => ['required', Rule::in(['Hadir', 'Alpha', 'Izin'])],
                'attendances.*.description' => ['nullable', 'string',],
            ]);
    
            $teacher_id = $validate['teacher_id'];
    
            foreach ($validate['attendances'] as $attendance) {
                $data = [
                    'status' => $attendance['status'],
                    'teacher_id' => $attendance['status'] == 'Izin' ? $teacher_id : null, 
                    'description' => $attendance['status'] == 'Izin' ? $attendance['description'] : null,
                ];
                $attendances->where('id', $attendance['attendance_id'])->update($data);
            }
    
            return response()->json([
                'status' => true,
                'message' => 'Successfully update attendances.'
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validation Error.',
                'msg' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'There is an error.',
                'msg' => $e->getMessage()
            ], 500);
        }
    }
}
