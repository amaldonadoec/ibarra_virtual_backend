<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Processes\CategoryProcess;

class CategoryController extends Controller
{
    /**
     * @var CategoryProcess
     */
    private $categoryProcess;

    /**
     * CategoryController constructor.
     * @param CategoryProcess $categoryProcess
     */
    public function __construct(CategoryProcess $categoryProcess)
    {
        $this->categoryProcess = $categoryProcess;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->categoryProcess->findAll();
    }

}