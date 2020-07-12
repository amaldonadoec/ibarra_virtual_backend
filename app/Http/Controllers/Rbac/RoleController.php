<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\MyBaseController;
use App\Http\Models\Permission;
use App\Http\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class RoleController extends MyBaseController
{

    public function index()
    {
        $this->layout->content = View::make('rbac.roles.index');
    }

    public function getList()
    {
        $data = Input::all();
        $query = Role::query();
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

    public function getFormRole($id = null)
    {
        $method = 'POST';
        $role = isset($id) ? Role::find($id) : new Role();
        $permissions = Permission::all();
        $view = View::make('rbac.roles.loads._form', [
            'method' => $method,
            'role' => $role,
            'permissions' => $permissions
        ])->render();
        return Response::json(array(
            'html' => $view
        ));
    }

    public function postSave()
    {
        try {
            DB::beginTransaction();
            $data = Input::all();
            if ($data['role_id'] == '') { //Create
                $role = new Role();
            } else { //Update
                $role = Role::find($data['role_id']);
            }
            $role->name = trim($data['name']);
            $role->guard_name = trim($data['guard_name']);
            $role->save();
            $permissions = isset($data['permissions']) ? $data['permissions'] : [];
            $role->syncPermissions($permissions);
            DB::commit();
            return Response::json(true);
        } catch (Exception $e) {
            DB::rollback();
            return Response::json(false);
        }
    }

    public function postIsNameUnique()
    {
        $validation = Validator::make(Input::all(), ['name' => 'unique:roles,name,' . Input::get('id') . ',id']);
        return Response::json($validation->passes() ? true : false);
    }
}
