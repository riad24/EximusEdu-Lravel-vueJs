<?php

namespace App\Services;


use App\Http\Requests\InstituteRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Institute;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InstituteService
{
    public $institute;
    protected $instituteFilter = [
        'name',
        'email',
        'phone',
        'slug',
        'status',
        'description'
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

            return Institute::with('media')->where(function ($query) use ($requests) {
                foreach ($requests as $key => $request) {
                    if (in_array($key, $this->instituteFilter)) {
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
    public function store(InstituteRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->institute = Institute::create($request->validated() + ['slug' => Str::slug($request->name)]);

            });
            return $this->institute;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(InstituteRequest $request, Institute $institute) : Institute
    {
        try {
            DB::transaction(function () use ($request, $institute) {
                $institute->update($request->validated() + ['slug' => Str::slug($request->name)]);
            });
            return Institute::find($institute->id);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Institute $institute)
    {
        try {
            DB::transaction(function () use ($institute) {
                $institute->variations()->delete();
                $institute->delete();
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
    public function show(Institute $institute) : Institute
    {
        try {
            return $institute;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }


}
