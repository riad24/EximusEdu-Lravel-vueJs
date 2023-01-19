<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FieldExport;
use App\Http\Requests\FieldRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\FieldResource;
use App\Models\Field;
use App\Services\FieldService;
use Exception;
use Maatwebsite\Excel\Facades\Excel;


class FieldController extends AdminController
{
    private $fieldService;


    public function __construct(FieldService $fieldService)
    {
        parent::__construct();
        $this->fieldService          = $fieldService;
    }

    public function index(PaginateRequest $request)
    {
        try {
            return FieldResource::collection($this->fieldService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(FieldRequest $request)
    {
        try {
            return new FieldResource($this->fieldService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(FieldRequest $request, Field $field)
    {
        try {
            return new FieldResource($this->fieldService->update($request, $field));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Field $field)
    {
        try {
            $this->fieldService->destroy($field);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Field $field)
    {
        try {
            return new FieldResource($this->fieldService->show($field));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function export(PaginateRequest $request)
    {
        try {
            return Excel::download(new FieldExport($this->fieldService, $request), 'Field.xlsx');
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

}
