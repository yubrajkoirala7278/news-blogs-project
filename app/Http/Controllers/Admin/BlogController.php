<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Category;
use App\Service\BlogService;
use Illuminate\Http\Request;

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
    public function index()
    {
        try {
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
            $categories=Category::latest()->get();
            return view('backend.blog.create',compact('categories'));
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
        //
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
    public function destroy(string $id)
    {
        //
    }
}
