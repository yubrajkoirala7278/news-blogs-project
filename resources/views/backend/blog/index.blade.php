@extends('backend.layouts.master')
@section('content')
<div class="p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="text-success fw-semibold fs-4">Blogs</h2>
        <a href="{{route('blog.create')}}" class="btn btn-transparent" data-toggle="tooltip" data-placement="bottom"
            title="Add Blogs"><i class="fa-solid fa-circle-plus fs-4 text-success"></i></a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">S/N</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Image</th>
                <th scope="col">Author</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (count($blogs)>0)
            @foreach ($blogs as $key=>$blog)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$blog->title}}</td>
                <td>{{$blog->description}}</td>
                <td><span>{{$blog->is_published==1?'':'unpublished'}}</span></td>
                <td>{{$blog->image->filename}}</td>
                <td>Yubraj Koirala</td>
                <td>@mdo</td>
            </tr>
            @endforeach

            @else

            @endif

        </tbody>
    </table>
</div>
@endsection
@section('content')
This is dashboard section
@endsection