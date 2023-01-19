<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InstituteExport;
use App\Http\Requests\InstituteRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\FieldResource;
use App\Http\Resources\InstituteResource;
use App\Models\Institute;
use App\Services\InstituteService;
use Exception;
use Maatwebsite\Excel\Facades\Excel;


class InstituteController extends AdminController
{
    private $instituteService;


    public function __construct(InstituteService $instituteService)
    {
        parent::__construct();
        $this->instituteService          = $instituteService;
    }

    public function index(PaginateRequest $request)
    {
        try {
            return InstituteResource::collection($this->instituteService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(InstituteRequest $request)
    {
        try {
            return new InstituteResource($this->instituteService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(InstituteRequest $request, Institute $institute)
    {
        try {
            return new InstituteResource($this->instituteService->update($request, $institute));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Institute $institute)
    {
        try {
            $this->instituteService->destroy($institute);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Institute $institute)
    {
        try {
            return new InstituteResource($this->instituteService->show($institute));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function export(PaginateRequest $request)
    {
        try {
            return Excel::download(new InstituteExport($this->instituteService, $request), 'Institute.xlsx');
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function fields(Institute $institute)
    {
        try {
            return FieldResource::collection($institute->fields);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

}
