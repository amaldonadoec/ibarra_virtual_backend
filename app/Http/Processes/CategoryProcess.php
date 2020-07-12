<?php


namespace App\Http\Processes;


use App\Http\Repositories\DbCategoryRepository;
use App\Http\Resources\CategoryResource;

class CategoryProcess
{
    /**
     * @var DbCategoryRepository
     */
    private $dbCategoryRepository;


    /**
     * CategoryProcess constructor.
     * @param DbCategoryRepository $dbCategoryRepository
     */
    public function __construct(
        DbCategoryRepository $dbCategoryRepository
    )
    {
        $this->dbCategoryRepository = $dbCategoryRepository;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function findAll()
    {
        $result = $this->dbCategoryRepository->findAll();

        CategoryResource::withoutWrapping(); //Remove the data top level key
        return CategoryResource::collection($result);
    }


}