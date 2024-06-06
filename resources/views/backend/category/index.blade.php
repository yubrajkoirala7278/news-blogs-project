@extends('backend.layouts.master')
@section('content')
    <div class="container p-4 bg-white">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4">Category</h2>
            {{-- open create category modal --}}
            <button type="button" class="btn btn-transparent text-success " data-bs-toggle="modal"
                data-bs-target="#createCategory" id="create-category-btn">
                <i class="fa-solid fa-circle-plus fs-4"></i>
            </button>
        </div>
        {{-- create --}}
        @include('backend.category.create')


        {{-- display categories --}}
        <table class="table table-bordered" id="category-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>Slug</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


        {{-- edit category --}}
        @include('backend.category.edit')
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // ======setup csrf token======
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // ============================


            // ========adding data to db=========
            $('#create-category-btn').click(function() {
                $('#create-category-error').html('');
                $('#ajaxForm')[0].reset();
            });

            var createFormData = $('#ajaxForm')[0];
            $('#saveBtn').click(function() {
                var formData = new FormData(createFormData);
                $('#create-category-error').html('');
                $.ajax({
                    url: "{{ route('category.store') }}",
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function(response) {
                        $('#createCategory').modal('hide');
                        table.draw();
                        toastify().success(response[1]);
                    },
                    error: function(err) {
                        let errorMessage = err.responseJSON.errors;
                        if (errorMessage) {
                            errorMessage.category ? $('#create-category-error').html(
                                errorMessage.category[0]) : '';
                        } else {
                            toastify().error('Something went wrong!');
                        }
                    }
                })
            })
            // ==================================


            // ==========Read Categories for DB==========
            var table = $('#category-table').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                searchDelay: 3000,
                ajax: "{{ route('category.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            // =======================================


            // ================delete category=========
            $('body').on('click', '.deleteCategory', function() {
                var category_id = $(this).data("slug");
                confirm("Are You sure want to delete !");
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/category/', '') }}" + '/' + category_id,
                    success: function(response) {
                        table.draw();
                        toastify().success(response[1]);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
            // =======================================

            // =============fill the current data to form for updation==========
            let slug = '';
            $('body').on('click', '.editCategory', function() {
                // get form slug
                slug = $(this).data('slug');
                $('#edit-category-error').html('');

                $.ajax({
                    url: '{{ url('admin/category', '') }}' + '/' + slug + '/edit',
                    method: 'GET',
                    success: function(response) {
                        console.log(response.category);
                        $('#editCategory').modal('show');
                        $('#edit-category').val(response.category);
                    }
                })
            })
            // ================================================================

            // =================updating category=================
            var updateFormData = $('#ajaxFormUpdate')[0];
            $('#updateBtn').click(function() {
                var formUpdateData = new FormData(updateFormData);
                $.ajax({
                    url: '{{ url('admin/category/', '') }}' + '/' + slug,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formUpdateData,
                    success: function(response) {
                        $('#editCategory').modal('hide');
                        table.draw();
                    },
                    error: function(err) {
                        let errorMessage = err.responseJSON.errors;
                        if (errorMessage) {
                            errorMessage.category ? $('#edit-category-error').html(
                                errorMessage.category[0]) : '';
                        } else {
                            toastify().error('Something went wrong!');
                        }
                    }
                })
            });
            // ===================================================
        });
    </script>
@endsection
