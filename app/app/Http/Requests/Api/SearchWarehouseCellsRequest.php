<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use App\Http\Requests\ApiRequest;
use App\Enums\WarehouseCellStatusEnum;


class SearchWarehouseCellsRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            $this->searchRules(),
            $this->paginationRules(),
            [
                'status' => ['sometimes', Rule::enum(WarehouseCellStatusEnum::class)],
                'warehouse_object_id' => ['sometimes', 'integer', 'exists:warehouse_objects,id'],
                'city_id' => ['sometimes', 'integer', 'exists:cities,id'],
            ]
        );
    }
}
