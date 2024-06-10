<?php

namespace App\Service;

use App\Models\Blog;


class BlogService
{

    private $imageservice;
    public function __construct()
    {
        $this->imageservice = new ImageService();
    }

    public function fetchBlogs()
    {
        $blogs=Blog::with('image')->latest()->get();
        return $blogs;
    }

    public function addService($request)
    {
        $slug = explode(' ', $request['title']);
        $request['slug'] = implode('-', $slug);
        $request['category_id'] = $request['category'];
        $blog = Blog::create($request);
        // if image exist
        if (isset($request['image'])) {
            $this->imageservice->saveImage($blog, $request['image'], 'blog');
        }
    }
}
