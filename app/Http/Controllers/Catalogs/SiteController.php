<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Multimedia\ImageController;
use App\Http\Controllers\MyBaseController;
use App\Http\Models\Category;
use App\Http\Models\Multimedia;
use App\Http\Models\Site;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class SiteController extends MyBaseController
{

    /**
     *
     */
    public function index()
    {
        $this->layout->content = View::make('site.index', [

        ]);
    }

    public function getList(Request $request)
    {
        $data = $request->all();
        $query = Site::query();

        $recordsTotal = $query->get()->count();

        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);
        $parameters = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
        if (isset($parameters['term']) && $parameters['term']) {
            $term = $parameters['term'];
            $term = str_replace(' ', '', $term);
            if ($term != '') {
                $query->where('name', 'like', "%$term%");
            }
        }

        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'nickname';
        $page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = $recordsTotal; // total items in array

        // sort
        $query->orderBy($field, $sort);
        // Pagination: $perpage 0; get all data
        if ($perpage > 0) {
            $pages = ceil($total / $perpage); // calculate total pages
            $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }
            $query->offset((int)$offset);
            $query->limit((int)$perpage);
        }
        $data = $query->get()->toArray();
        $meta = [
            'page' => $page,
            'pages' => $pages,
            'perpage' => $perpage,
            'total' => $total,
        ];
        $sort = [
            'sort' => $sort,
            'field' => $field,
        ];
        $result = array(
            'meta' => $meta + $sort,
            'data' => $data
        );
        return Response::json(
            $result
        );
    }

    public function getForm($id = null)
    {
        $method = 'POST';
        $model = isset($id) ? Site::query()->find($id) : new Site();
        $categories = Category::query()
            ->get()
            ->pluck('name', 'id')
            ->toArray();
        $view = View::make('site.loads._form', [
            'method' => $method,
            'model' => $model,
            'categories' => $categories
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function postSave(Request $request)
    {
        try {
            $data = $request->all();
            if ($data['entity_id'] == '') { //Create
                $model = new Site();
            } else { //Update
                $model = Site::query()->find($data['entity_id']);
            }
            $model->fill($data);
            $latitude = (float)$data['latitude'];
            $longitude = (float)$data['longitude'];
            $model->location = new Point($latitude, $longitude);
            $model->saveOrFail();
            $model->categories()->sync($data['categories']);

            $imageController = new ImageController();
            $images = $data['images'] ?? [];
            foreach ($images as $file) {
                $folder = "site/{$model->id}";
                $fileName = $imageController->saveFileAwsS3($file, $folder);
                $imageModel = new Multimedia();
                $imageModel->file_name = $fileName;
                $imageModel->type = 'IMAGE';
                $model->images()->save($imageModel);
            }

            $audio = $data['audios'] ?? [];
            foreach ($audio as $file) {
                $folder = "site/{$model->id}";
                $fileName = $imageController->saveFileAwsS3($file, $folder);
                $imageModel = new Multimedia();
                $imageModel->file_name = $fileName;
                $imageModel->type = 'AUDIO';
                $model->images()->save($imageModel);

            }

            $deletedMultimediaIds = $data['multimediaDeleted'] ?? [];
            $deletedMultimedia = Multimedia::query()
                ->whereIn('id', $deletedMultimediaIds)
                ->get();
            foreach ($deletedMultimedia as $itemMultimedia) {
                $path = "site/{$model->id}/{$itemMultimedia->file_name}";
                if (Storage::disk('s3')->exists($path)) {
                    Storage::disk('s3')->delete($path);
                }
                $itemMultimedia->delete();
            }


            return Response::json(true);
        } catch (\Exception $e) {
            return Response::json([
                'status' => 'error',
                'message' => 'Error al guardar',
                'w' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postIsNameUnique(Request $request)
    {
        $validation = Validator::make($request->all(), ['name' => 'unique:sites,name,' . $request->get('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }

}
