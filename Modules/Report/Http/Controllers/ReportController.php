<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Report\Http\Services\ReportService;
use Modules\Retailer\Http\Services\RetailerService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    protected  ReportService $reportService;
    protected  RetailerService $retailerService;

    public function __construct(ReportService $reportService, RetailerService $retailerService)
    {
        $this->reportService = $reportService;
        $this->retailerService = $retailerService;
    }

    /**
     * Call View page of brand listing with total sales and amount
     *
     * @return Renderable
     */
    public function sale(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        return view('report::sale');
    }

    /**
     * Call brand sale with total sales and amount
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saleData(Request $request): JsonResponse
    {

        $data = $this->reportService->saleData($request);
        return response()->json($data);
    }

    /**
     * Sale Chart
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saleChart(Request $request): JsonResponse
    {
        $data = $this->reportService->saleChart($request);
        return response()->json($data);
    }

    /**
     * Export Brand
     *
     * @param Request $request
     * @return void
     */
    public function exportBrand(Request $request)
    {

        $data = $this->reportService->exportBrand($request);
        return response()->json($data);
    }

    /**
     * Call View page of brand register report
     *
     * @return Renderable
     */
    public function brandReg(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $countries = $this->retailerService->getCountry();
        $categories = $this->retailerService->getCategory();
        return view('report::brandreg', ['countries' => $countries,'categories' => $categories]);
    }

    /**
     * Get all Brand Via Ajax
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function brandRegData(Request $request): JsonResponse
    {
        $data = $this->reportService->brandRegData($request);
        return response()->json($data);
    }

    /**
     * Export Brand Registration
     *
     * @param Request $request
     * @return void
     */
    public function exportBrandReg(Request $request)
    {

        $data = $this->reportService->exportBrandReg($request);
        return response()->json($data);
    }


    /**
     * Call View page of retailer register report
     *
     * @return Renderable
     */
    public function retailerReg(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $countries = $this->retailerService->getCountry();
        $categories = $this->retailerService->getCategory();
        return view('report::retailerreg', ['countries' => $countries,'categories' => $categories]);
    }

    /**
     * Get all retailer Via Ajax
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function retailerRegData(Request $request): JsonResponse
    {
        $data = $this->reportService->retailerRegData($request);
        return response()->json($data);
    }

    /**
     * Export retailer Registration
     *
     * @param Request $request
     * @return void
     */
    public function exportRetailerReg(Request $request)
    {

        $data = $this->reportService->exportRetailerReg($request);
        return response()->json($data);
    }

    /**
     * Call View page of product movement
     *
     * @param Request $request
     * @return Renderable
     */
    public function productReport(Request $request): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }

        return view('report::product');
    }

    /**
     * Call product stock report
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function productData(Request $request): JsonResponse
    {

        $data = $this->reportService->productData($request);
        return response()->json($data);
    }

    /**
     * Export product stock
     *
     * @param Request $request
     * @return void
     */
    public function exportProduct(Request $request)
    {

        $data = $this->reportService->exportProduct($request);
        return response()->json($data);
    }
}
