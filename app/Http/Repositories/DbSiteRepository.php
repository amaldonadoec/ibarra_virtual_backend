<?php

namespace App\Http\Repositories;


use App\Http\Models\Site;
use App\Http\Transformers\ResponseTransformer;
use Illuminate\Http\Exceptions\HttpResponseException;

class DbSiteRepository
{
    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll($input = [])
    {
        try {
            $query = Site::query()
                ->select('sites.*')
                ->where('sites.status', 1);
            if (isset($input['categoryId']) && $input['categoryId']) {
                $categoryId = $input['categoryId'];
                $query->join('sites_by_categories', 'sites_by_categories.site_id', '=', 'sites.id');
                $query->where('sites_by_categories.category_id', $categoryId);
            }
            $term = $input['query'] ?? '';
            $term = str_replace(' ', '', $term);
            if ($term != '') {
                $query->where('sites.name', 'like', "%$term%");
            }
            $query->groupBy('sites.id');
            $query->with(['images', 'audio']);
            $result = $query->get();

            return $result;
        } catch (\Exception $e) {
            throw new HttpResponseException(
                ResponseTransformer::transformResponse('error', [], 500, $e->getMessage())
            );
        }
    }

}
