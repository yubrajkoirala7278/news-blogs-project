@extends('backend.layouts.master')
@section('page_name')
    <h1>Blogs</h1>
@endsection
@section('content')
    <div class="bg-white p-4">
        <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                @if ($errors->has('title'))
                    <span class="text-sm text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" placeholder="Description" id="description" name="description">{{old('description')}}</textarea>
                @if ($errors->has('description'))
                    <span class="text-sm text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                @if (count($categories) > 0)
                    <select class="form-select" name="category">
                        <option selected disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category') == $category->id)>{{ $category->category }}</option>
                        @endforeach
                    </select>
                @endif
                @if ($errors->has('category'))
                    <span class="text-sm text-danger">{{ $errors->first('category') }}</span>
                @endif

            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                @if ($errors->has('image'))
                    <span class="text-sm text-danger">{{ $errors->first('image') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection
