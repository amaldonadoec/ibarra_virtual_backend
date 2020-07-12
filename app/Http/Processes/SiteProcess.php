<?php

namespace App\Http\Processes;

use App\Http\Repositories\DbSiteRepository;
use App\Http\Resources\SiteResource;
use Illuminate\Http\Request;

class SiteProcess
{
    /**
     * @var dbSiteRepository
     */
    private $dbSiteRepository;


    /**
     * SiteProcess constructor.
     * @param DbSiteRepository $dbSiteRepository
     */
    public function __construct(
        DbSiteRepository $dbSiteRepository
    )
    {
        $this->dbSiteRepository = $dbSiteRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function findAll(Request $request)
    {
        $input = $request->all();
        $result = $this->dbSiteRepository->findAll($input);

        SiteResource::withoutWrapping(); //Remove the data top level key
        return SiteResource::collection($result);
    }

}
