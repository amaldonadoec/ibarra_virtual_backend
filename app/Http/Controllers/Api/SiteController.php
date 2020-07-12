<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Processes\SiteProcess;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * @var SiteProcess
     */
    private $siteProcess;

    /**
     * CategoryController constructor.
     * @param SiteProcess $siteProcess
     */
    public function __construct(SiteProcess $siteProcess)
    {
        $this->siteProcess = $siteProcess;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return $this->siteProcess->findAll($request);
    }

}
