<?php


namespace App\Service;

use App\Models\Category;

class CategoryService
{
    public function addServive($request)
    {
        $slug = explode(' ', $request['category']);
        $request['slug'] = implode('-', $slug);
        Category::create($request);
    }

    public function updateService($request, $category)
    {
        $slug = explode(' ', $request['category']);
        $request['slug'] = implode('-', $slug);
        $category->update($request);
    }
}
