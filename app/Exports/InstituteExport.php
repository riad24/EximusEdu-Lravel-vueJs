<?php

namespace App\Exports;




use App\Services\InstituteService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InstituteExport implements FromCollection, WithHeadings
{

    public $instituteService;
    public $request;

    public function __construct(InstituteService $instituteService, $request)
    {
        $this->instituteService = $instituteService;
        $this->request         = $request;
    }

    /**
     * @throws \Exception
     */
    public function collection() : \Illuminate\Support\Collection
    {
        $instituteArray = [];
        $institutes     = $this->instituteService->list($this->request);
        foreach ($institutes as $institute) {
            $instituteArray[] = [
                $institute->name,
                $institute->email,
                $institute->phone,
            ];
        }
        return collect($instituteArray);
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
