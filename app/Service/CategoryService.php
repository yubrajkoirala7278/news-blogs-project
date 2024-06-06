<?php


namespace App\Service;

use App\Models\Category;

class CategoryService{
    public function addServive($request){
        Category::create($request);
    }
}