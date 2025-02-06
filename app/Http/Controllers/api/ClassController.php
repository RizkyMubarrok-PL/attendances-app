<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\TeacherClasses;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function getClasses()
    // {
    //     try {
    //         $classes = Classes::all();

    //         if ($classes->isEmpty()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'No attendance data found for the given class_id and date.',
    //                 'data' => ''
    //             ], 204);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Get all Classes data.',
    //             'data' => $classes
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function getClasses(int $teacherId, TeacherClasses $teacherClasses) {
        try {            
            $classes = $teacherClasses->where('teacher_id', $teacherId)->with('classData')->get();
        
            if ($classes->isNotEmpty()) {
                return response()->json([
                    'status' => true,
                    'data' => $classes
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Teacher class not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'. $e
            ], 500);
        }
        
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
