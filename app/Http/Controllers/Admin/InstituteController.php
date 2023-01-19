<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InstituteExport;
use App\Http\Requests\InstituteRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\InstituteResource;
use App\Models\Institute;
use App\Services\InstituteService;
use Exception;
use Maatwebsite\Excel\Facades\Excel;


class InstituteController extends AdminController
{
    private $productService;


    public function __construct(InstituteService $productService)
    {
        parent::__construct();
        $this->productService          = $productService;
    }

    public function index(PaginateRequest $request)
    {
        try {
            return InstituteResource::collection($this->productService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(InstituteRequest $request)
    {
        try {
            return new InstituteResource($this->productService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(InstituteRequest $request, Institute $product)
    {
        try {
            return new InstituteResource($this->productService->update($request, $product));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Institute $product)
    {
        try {
            $this->productService->destroy($product);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Institute $product)
    {
        try {
            return new InstituteResource($this->productService->show($product));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function export(PaginateRequest $request)
    {
        try {
            return Excel::download(new InstituteExport($this->productService, $request), 'Institute.xlsx');
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

}
