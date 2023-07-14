<?php

namespace Modules\Retailer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Retailer\Http\Services\RetailerService;
use Illuminate\Http\JsonResponse;
use Modules\Retailer\Http\Requests\RetailerRequest;

class RetailerController extends Controller
{
    private RetailerService $retailerService;

    public function __construct(RetailerService $retailerService)
    {
        $this->retailerService = $retailerService;
    }

    /**
     * Call View page of retailer listing
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $countries = $this->retailerService->getCountry();
        $categories = $this->retailerService->getCategory();
        return view('retailer::index', ['countries' => $countries,'categories' => $categories]);
    }

    /**
     * Get all retailer Via Ajax
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function retailerData(Request $request): JsonResponse
    {
        $data = $this->retailerService->retailerData($request);
        return response()->json($data);
    }

    /**
     * Details of Retailer
     *
     * @param  $id
     * @return Renderable
     */
    public function details($id): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $response = $this->retailerService->detail($id);
        $shippings = json_decode($response->shipping);

        return view('retailer::details', ['detail' => $response,'shippings' => $shippings]);
    }

    /**
     * Change status of retailer
     *
     * @param $id
     * @param $status
     * @return mixed
     */
    public function changeStatus($id,$status): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $this->retailerService->changeStatus($id,$status);

        return redirect()->back()->with('success', 'Status changed successfully');
    }

    /**
     * Delete Retailer
     *
     * @param $id
     * @return mixed
     */
    public function delete($id): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $this->retailerService->delete($id);
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    /**
     * Create Retailer
     *
     * @param Request $request
     * @return Renderable
     */
    public function create(Request $request): Renderable
    {
        $countries = $this->retailerService->getCountry();

        return view('retailer::create', ['countries' => $countries]);
    }

    /**
     * Create New Retailer
     *
     * @param RetailerRequest $request
     * @return RedirectResponse
     */
    public function createRetailer(RetailerRequest $request): RedirectResponse
    {
        $this->retailerService->createRetailer($request->validated(),$request);
        return redirect()->back()->with('success', 'Retailer Created Successfully and send an email to Retailer with login information');

    }
}
