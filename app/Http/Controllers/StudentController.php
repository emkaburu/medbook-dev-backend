<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:view-student');
        $this->middleware('permission:create-student', ['only' => ['create','store']]);
        $this->middleware('permission:update-student', ['only' => ['edit','update']]);
        $this->middleware('permission:destroy-student', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $students = Student::with(['user'])->where('student_name', 'like', '%'.$request->search.'%')->paginate(setting('record_per_page', 15));
        }else{
            $students = Student::with(['user'])->paginate(setting('record_per_page', 15));
        }
        $title =  'Manage Categories';
        return view('student.index', compact('students','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create student';
        return view('student.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $request->merge(['user_id' => Auth::user()->id]);
        Student::create($request->all());
        flash('Student created successfully!')->success();
        return redirect()->route('student.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $title = "Student Details";
        $student->with('user');
        return view('student.edit', compact('title', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->all());
        flash('Student updated successfully!')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        flash('Student deleted successfully!')->info();
        return back();
    }
}
