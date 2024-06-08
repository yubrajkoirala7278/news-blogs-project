<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Service\TagService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    private $tagService;
    public function __construct() {
        $this->tagService = new TagService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Tag::latest()->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-slug="' . $row->slug . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editTag">Edit</a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-slug="' . $row->slug . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteTag">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('backend.tag.index');
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
    public function store(TagRequest $request)
    {
        try {
            $this->tagService->addService($request->validated());
            return response()->json(['success', 'Tag added successfully']);
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
    public function edit(Tag $tag)
    {
        try {
            return $tag;
        } catch (\Throwable $th) {
            return response()->json(['error', 'Something went wrong!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        try {
            $this->tagService->updateService($request->except('_method'), $tag);
            return response()->json(['success', 'Tag updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error', 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return response()->json(['success', 'Tag deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error', 'Something went wrong!']);
        }
    }
}
