@extends('backend.layouts.master')

@section('title')
    Post Edit Page
@endsection

@push('admin_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('admin_content')
    <div class="row">
        <h1>Post Edit Form</h1>
        <div class="col-12">
            <div class="d-flex justify-content-start">
                <a href="{{ route('post.index') }}" class="btn btn-primary">
                    <i class="fas fa-backward"></i>
                    Back to Post lists
                </a>
            </div>
        </div>

        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.update', $posts->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Category Section -->
                            <div class="col-12 mb-3">
                                <label for="category-name" class="form-label">Select Category</label>
                                <select name="category_id" class="form-select">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if ($posts->category_id == $category->id)
                                            selected
                                        @endif
                                        >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Category Section -->

                            <!-- Creator Name Section -->
                            <div class="col-12 mb-3">
                                <label for="creator-name" class="form-label">Creator Name</label>
                                <input type="text" name="creator_name"
                                    class="form-control @error('creator_name') is-invalid @enderror"
                                    placeholder="Enter Creator Name" value="{{ $posts->creator_name }}">
                                @error('creator_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Creator Name Section -->


                            <!-- Post title Section -->
                            <div class="col-6 mb-3">
                                <label for="post-title" class="form-label">Post Title</label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror" placeholder="Enter Post title"
                                    id="title" value="{{ $posts->title }}">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Post title Section -->

                            <!-- Post Description -->
                            <div class="col-12 mb-3">
                                <label for="long_description" class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                    id="" cols="30" rows="5">{{ $posts->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Post Description -->




                            <!-- Post Image Section -->
                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">Post Image</label>
                                <input type="file" class="form-control dropify" name="image" id=""
                                data-default-file="{{ asset("uploads/post/$posts->image") }}">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Post Image Section -->


                            <div class="mt-5">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('admin_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endpush
