<?php

namespace App\Http\Repositories;


use App\Http\Models\Category;
use App\Http\Transformers\ResponseTransformer;
use Illuminate\Http\Exceptions\HttpResponseException;

class DbCategoryRepository
{


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll()
    {
        try {
            $result = Category::query()
                ->where('status',1)
                ->get();
            return $result;

        } catch (\Exception $e) {
            throw new HttpResponseException(
                ResponseTransformer::transformResponse('error', [], 500, $e->getMessage())
            );
        }
    }

}
