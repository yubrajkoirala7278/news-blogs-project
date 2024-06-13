<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Category;
use App\Service\BlogService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    private $blogService;
    public function __construct()
    {
        $this->blogService = new BlogService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->blogService->fetchBlogs();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $editUrl = url('/admin/blog/' . $row->slug . '/edit');
                        $deleteBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-slug="' . $row->slug . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteBlog">Delete</a>';
                        $btn = '<a href="' . $editUrl . '" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-primary btn-sm">Edit</a> ';
                        $btn .= $deleteBtn;
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('backend.blog.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = Category::latest()->get();
            return view('backend.blog.create', compact('categories'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        try {
            $this->blogService->addService($request->except('_token'));
            return redirect()->route('blog.index')->with('success', 'Blog added successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
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
    public function edit(string $id)
    {
        return view('backend.blog.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            $blog->delete();
            return back()->with('success', 'Blog deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function updateBlogStatus(Request $request, Blog $blog)
    {
        dd('i am here');
        try {
            $blog->is_published = $request->is_published;
            $blog->save();
            return response()->json([
                'success' => 'status updated successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
}
