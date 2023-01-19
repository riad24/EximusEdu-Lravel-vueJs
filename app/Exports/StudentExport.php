<?php

namespace App\Exports;




use App\Services\StudentService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{

    public $studentService;
    public $request;

    public function __construct(StudentService $studentService, $request)
    {
        $this->studentService = $studentService;
        $this->request         = $request;
    }

    /**
     * @throws \Exception
     */
    public function collection() : \Illuminate\Support\Collection
    {
        $studentArray = [];
        $students     = $this->studentService->list($this->request);
        foreach ($students as $student) {
            $studentArray[] = [
                $student->name,
                $student->email,
                $student->phone,
            ];
        }
        return collect($studentArray);
    }

    public function headings() : array
    {
        return [
            trans('all.label.name'),
            trans('all.label.email'),
            trans('all.label.phone'),
        ];
    }

}
