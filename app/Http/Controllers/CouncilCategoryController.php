<?php

namespace App\Http\Controllers;

use App\Models\CouncilCategory;
use App\Http\Requests\StoreCouncilCategoryRequest;
use App\Http\Requests\UpdateCouncilCategoryRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CouncilCategoryController extends Controller
{
    private CouncilCategory $_councilCategory;
    private DataTables $_datatables;

    public function __construct()
    {
        $this->_councilCategory = new CouncilCategory;
        $this->_datatables = datatables();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->isDropdown) {
                return $this->_councilCategory
                    ->when($request->term, function ($item) use ($request) {
                        $item->where('name', 'LIKE', "%{$request->term}%");
                    })->get()
                    ->map(fn ($item) => [
                        'id' => $item->id,
                        'text' => $item->name
                    ]);
            }

            return $this->_datatables->eloquent($this->_councilCategory->query())
                ->toJson(true);
        }

        if ($request->route()->getPrefix() === 'api') {
            return abort(403);
        }

        return view('page.panel.council-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouncilCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CouncilCategory $councilCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CouncilCategory $councilCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouncilCategoryRequest $request, CouncilCategory $councilCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CouncilCategory $councilCategory)
    {
        //
    }
}
