<?php

namespace App\Services;


use App\Http\Requests\StudentRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Student;
use App\Models\StudentField;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StudentService
{
    public $student;
    protected $studentFilter = [
        'name',
        'class_name',
        'email',
        'phone',
        'status',
    ];

    /**
     * @throws Exception
     */
    public function list(PaginateRequest $request)
    {
        try {
            $requests    = $request->all();
            $method      = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType   = $request->get('order_type') ?? 'desc';

            return Student::with('institute')->where(function ($query) use ($requests) {
                foreach ($requests as $key => $request) {
                    if (in_array($key, $this->studentFilter)) {
                        $query->where($key, 'like', '%' . $request . '%');
                    }
                }
            })->orderBy($orderColumn, $orderType)->$method(
                $methodValue
            );
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function store(StudentRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->student = Student::create([
                    'class_name'        => $request->class_name,
                    'name'              => $request->name,
                    'email'             => $request->email,
                    'phone'             => $request->phone,
                    'institute_id'      => $request->institute_id,
                    'status'            => $request->status,
                ]);
                $studentFields = json_decode($request->studentFields);
                if(!blank($studentFields)){
                    foreach ($studentFields as $key=> $studentField){
                        $field = new StudentField;
                        $field->field_name      = $studentField->field_key;
                        $field->field_value     = $studentField->field_value;
                        $field->student_id      = $this->student->id;
                        $field->institute_id    = $request->institute_id;
                        $field->field_id        = $studentField->field_id;
                        $field->save();
                    }
                }
            });
            return $this->student;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(StudentRequest $request, Student $student) : Student
    {
        try {
            DB::transaction(function () use ($request, $student) {

                    $student->class_name     = $request->class_name;
                    $student->name           = $request->name;
                    $student->email          = $request->email;
                    $student->phone          = $request->phone;
                    $student->institute_id   = $request->institute_id;
                    $student->status         = $request->status;
                    $student->save();

                $studentFields = json_decode($request->studentFields);
                if(!blank($studentFields)){
                    foreach ($student->studentFields as $field) {
                        $field->delete();
                    }
                    foreach ($studentFields as $key=> $studentField){
                        $field = new StudentField;
                        $field->field_name      = $studentField->field_key;
                        $field->field_value     = $studentField->field_value;
                        $field->student_id      = $student->id;
                        $field->institute_id    = $request->institute_id;
                        $field->field_id        = $studentField->field_id;
                        $field->save();
                    }
                }
            });
            return Student::find($student->id);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Student $student)
    {
        try {
            DB::transaction(function () use ($student) {
                if(!blank($student->studentFields)){
                    foreach ($student->studentFields as $field) {
                        $field->delete();
                    }
                }
                $student->delete();

            });
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function show(Student $student) : Student
    {
        try {
            return $student;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }


}
