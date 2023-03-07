@extends('backend.layouts.master')

@section('title')
    Comment Create Page
@endsection

@push('admin_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('admin_content')
    <div class="row">
        <h1>Comment Create Form</h1>
        <div class="col-12">
            <div class="d-flex justify-content-start">
                <a href="{{ route('comment.index') }}" class="btn btn-primary">
                    <i class="fas fa-backward"></i>
                    Back to Comment lists
                </a>
            </div>
        </div>

        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('comment.store') }}" method="post">
                        @csrf

                        <div class="row">


                            <!-- Category Section -->
                            <div class="col-12 mb-3">
                                <label for="post-name" class="form-label">Select Post Title</label>
                                <select name="post_id" class="form-select">
                                    @foreach ($posts as $post)
                                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                                    @endforeach
                                </select>
                                @error('post_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Category Section -->
                            <!-- Post Description -->
                            <div class="col-12 mb-3">
                                <label for="long_description" class="form-label">Comment</label>
                                <textarea name="comment_des" class="form-control @error('comment_des') is-invalid @enderror" id="comment_des"
                                    id="" cols="30" rows="5"></textarea>
                                @error('comment_des')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Post Description -->







                            <div class="mt-5">
                                <button type="submit" class="btn btn-success">Store</button>
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
