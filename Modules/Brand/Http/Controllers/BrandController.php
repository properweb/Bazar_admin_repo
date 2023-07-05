<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Brand\Http\Services\BrandService;
use Illuminate\Http\JsonResponse;
use Modules\Login\Entities\User;
use Modules\Brand\Http\Requests\BrandRequest;
use Modules\Role\Http\Requests\RoleRequest;

class BrandController extends Controller
{
    private BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Call View page of brand listing
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        return view('brand::index');
    }

    /**
     * Get all Brand Via Ajax
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function brandData(Request $request): JsonResponse
    {
        $data = $this->brandService->brandData($request);
        return response()->json($data);
    }

    /**
     * Details of Brand
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
        $data = $this->brandService->detail($id);

        return view('brand::details', ['detail' => $data]);

    }

    /**
     * Delete Role
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
        $this->brandService->delete($id);
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    /**
     * Show Brand Trash
     *
     * @return Renderable
     */
    public function trash(): Renderable
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $response = $this->brandService->showTrash();

        return view('brand::trash', ['data' => $response['data']]);
    }

    /**
     * Create Brand
     *
     * @param Request $request
     * @return Renderable
     */
    public function create(Request $request): Renderable
    {
        $countries = $this->brandService->getCountry();
        $categories = $this->brandService->getCategory();

        return view('brand::create', ['countries' => $countries,'categories' => $categories]);

    }

    /**
     * Create New Brand
     *
     * @param BrandRequest $request
     * @return RedirectResponse
     */
    public function createBrand(BrandRequest $request): RedirectResponse
    {
        $this->brandService->createBrand($request->validated(),$request);
        return redirect()->back()->with('success', 'Brand Created Successfully and send an email to brand with login information');

    }

    /**
     * Get state By country
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getState(Request $request): JsonResponse
    {
        $states = $this->brandService->getState($request);

        return response()->json($states);

    }

    /**
     * Get city By state
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCity(Request $request): JsonResponse
    {
        $states = $this->brandService->getCity($request);

        return response()->json($states);

    }

    /**
     * Show Brand in Website
     *
     * @param $id
     * @return mixed
     */
    public function live($id): mixed
    {
        $user = auth()->user();
        if (empty($user)) {
            return redirect()->intended('/login');
        }
        $this->brandService->live($id);

        return redirect()->back()->with('success', 'Brand has been live');
    }
}
