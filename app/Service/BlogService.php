<?php

namespace App\Service;

use App\Models\Blog;


class BlogService{

    public function fetchBlogs(){
        dd('fetch blogs');
    }

    public function addService($request){
        $slug = explode(' ', $request['title']);
        $request['slug'] = implode('-', $slug);
        $request['user_id']=auth()->id();
        dd($request);
        Blog::create($request->except('image'));
    }
}