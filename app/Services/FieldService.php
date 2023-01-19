<?php

namespace App\Services;


use App\Http\Requests\FieldRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Field;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FieldService
{
    public $field;
    protected $fieldFilter = [
        'title',
        'slug',
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

            return Field::with('institute')->where(function ($query) use ($requests) {
                foreach ($requests as $key => $request) {
                    if (in_array($key, $this->fieldFilter)) {
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
    public function store(FieldRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->field = Field::create($request->validated() + ['slug' => Str::slug($request->title)]);

            });
            return $this->field;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(FieldRequest $request, Field $field) : Field
    {
        try {
            DB::transaction(function () use ($request, $field) {
                $field->update($request->validated() + ['slug' => Str::slug($request->name)]);
            });
            return Field::find($field->id);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Field $field)
    {
        try {
            DB::transaction(function () use ($field) {
                $field->delete();
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
    public function show(Field $field) : Field
    {
        try {
            return $field;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }


}
