@extends('backend.layouts.master')

@section('title')
    Post Page
@endsection

@push('admin_style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">


    <style>
        .datatable_length {
            padding: 20px 0;
        }
    </style>
@endpush

@section('admin_content')
    <div class="row">
        <h1>Post List Table</h1>
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <a href="{{ route('post.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>
                    Add New Post
                </a>
            </div>
        </div>
        <div class="col-12">
            <div class="table-responsive my-2">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Post Image</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Create Time</th>
                            <th scope="col">Creator Name</th>
                            <th scope="col">Post Title</th>
                            <th scope="col">Post Description</th>
                            <th scope="col">Options</th>

                    </thead>
                    <tbody>
                        @foreach ($posts as $key => $post)
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>
                                <img src="{{ asset('uploads/post') }}/{{ $post->image }}" alt=""
                                    class="img-fluid rounded h-20 w-20">
                            </td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ $post->created_at->format('d/M/Y') }}</td>
                            <td>{{ $post->creator_name }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->description }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">setting</button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('post.edit', $post->id) }}">
                                                <i class="fas fa-edit"></i> Edit</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="dropdown-item del_warn"><i
                                                        class="fas fa-trash"></i>
                                                    Delete</button>

                                            </form>

                                        </li>
                                    </ul>
                                </div>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('admin_script')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                pagingType: 'first_last_numbers',
            });
        });

        $('.del_warn').click(function(event) {
            let form = $(this).closest('form');
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(async result => {
                if (result.isConfirmed) {
                    await form.submit();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        })
    </script>
@endpush
