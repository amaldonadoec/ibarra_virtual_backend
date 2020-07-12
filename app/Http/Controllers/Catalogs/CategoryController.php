<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Multimedia\ImageController;
use App\Http\Controllers\MyBaseController;
use App\Http\Models\Category;
use App\Http\Models\Multimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CategoryController extends MyBaseController
{

    /**
     *
     */
    public function index()
    {
        $this->layout->content = View::make('category.index', [
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListCategories()
    {
        $data = Input::all();
        $query = Category::query();
        $recordsTotal = $query->get()->count();
        $datatable = !empty($data['datatable']) ? $data['datatable'] : [];
        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $datatable);

        $sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'name';
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

    /**
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFormCategory($id = null)
    {
        $method = 'POST';
        $category = isset($id) ? Category::find($id) : new Category();
        $view = View::make('category.loads._form', [
            'method' => $method,
            'category' => $category
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListSelect2()
    {
        $data = Input::all();
        $query = Category::query()->select('id', 'name as text');
        if (isset($data['q']) && !empty($data['q'])) {
            $query->where('name', 'like', '%' . $data['q'] . '%');
        }
        if (isset($data['id']) && !empty($data['id'])) {
            $query->where('id', '=', $data['id']);
        }
        $query->where('status', '=', true);
        $query->limit(10)->orderBy('name', 'asc');
        $categoryList = $query->get()->toArray();
        return Response::json(
            $categoryList
        );
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
            if ($data['category_id'] == '') { //Create
                $category = new Category();
            } else { //Update
                $category = Category::query()->find($data['category_id']);
            }
            $category->fill($data);
            $category->saveOrFail();

            $imageController = new ImageController();
            $images = $data['images'] ?? [];
            foreach ($images as $file) {
                $folder = "categories/{$category->id}";
                $fileName = $imageController->saveFileAwsS3($file, $folder);
                $imageModel = new Multimedia();
                $imageModel->file_name = $fileName;
                $imageModel->type = 'IMAGE';
                $category->images()->save($imageModel);
            }

            $deletedMultimediaIds = $data['multimediaDeleted'] ?? [];
            $deletedMultimedia = Multimedia::query()
                ->whereIn('id', $deletedMultimediaIds)
                ->get();
            foreach ($deletedMultimedia as $itemMultimedia) {
                $path = "categories/{$category->id}/{$itemMultimedia->file_name}";
                if (Storage::disk('s3')->exists($path)) {
                    Storage::disk('s3')->delete($path);
                }
                $itemMultimedia->delete();
            }

            return Response::json(true);
        } catch (\Exception $e) {
            return Response::json([
                'status' => 'error',
                'message' => 'Error al guardar la categoría'
            ], 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function postIsNameUnique()
    {
        $validation = Validator::make(Input::all(), ['name' => 'unique:categories,name,' . Input::get('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }
}
