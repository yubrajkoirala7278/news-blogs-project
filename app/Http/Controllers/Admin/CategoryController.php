<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Service\CategoryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    private $categoryService;
    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Category::latest()->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-slug="' . $row->slug . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategory">Edit</a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-slug="' . $row->slug . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteCategory">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('backend.category.index');
        } catch (\Throwable $th) {
            return response()->json(['error', 'Something went wrong!']);
        }
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
    public function store(CategoryRequest $request)
    {
        try {
            $this->categoryService->addServive($request->validated());
            return response()->json(['success', 'Category added successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error', 'Something went wrong!']);
            // return response()->json(['error',$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        try {
            return $category;
        } catch (\Throwable $th) {
            return response()->json(['error', 'Something went wrong!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $this->categoryService->updateService($request->except('_method'), $category);
            return response()->json(['success', 'Category updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error', 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json(['success', 'Category deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error', 'Something went wrong!']);
        }
    }
}
