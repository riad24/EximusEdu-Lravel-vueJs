<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentExport;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\StudentService;
use Exception;
use Maatwebsite\Excel\Facades\Excel;


class StudentController extends AdminController
{
    private $studentService;


    public function __construct(StudentService $studentService)
    {
        parent::__construct();
        $this->studentService          = $studentService;
    }

    public function index(PaginateRequest $request)
    {
        try {
            return StudentResource::collection($this->studentService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(StudentRequest $request)
    {
        try {
            return new StudentResource($this->studentService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(StudentRequest $request, Student $student)
    {
        try {
            return new StudentResource($this->studentService->update($request, $student));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $this->studentService->destroy($student);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Student $student)
    {
        try {
            return new StudentResource($this->studentService->show($student));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function export(PaginateRequest $request)
    {
        try {
            return Excel::download(new StudentExport($this->studentService, $request), 'Student.xlsx');
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

}
