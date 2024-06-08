<?php

namespace App\Service;

use App\Models\Tag;

class TagService{

    public function addService($request){
        $slug = explode(' ', $request['tag']);
        $request['slug'] = implode('-', $slug);
        Tag::create($request);
    }

    public function updateService($request, $tag)
    {
        $slug = explode(' ', $request['tag']);
        $request['slug'] = implode('-', $slug);
        $tag->update($request);
    }
}