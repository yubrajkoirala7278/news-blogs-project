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
        {{-- create  --}}
        @include('backend.category.create')


        {{-- display categories --}}
        <table class="table table-bordered" id="category-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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



            // =========reset form===========
            function resetForm() {
                $('#create-category-error').html('');
                $('#create-slug-error').html('');
                $('#ajaxForm')[0].reset();
            }
            // ============================



            // ========adding data to db=========
            $('#create-category-btn').click(function() {
                resetForm();
            });

            var createFormData = $('#ajaxForm')[0];
            $('#saveBtn').click(function() {
                var formData = new FormData(createFormData);
                $.ajax({
                    url: "{{ route('category.store') }}",
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function(response) {
                        $('#createCategory').modal('hide');
                        toastify().success(response[1]);
                    },
                    error: function(err) {
                        let errorMessage = err.responseJSON.errors;
                        if (errorMessage) {
                            errorMessage.category ? $('#create-category-error').html(
                                errorMessage.category[0]) : '';
                            errorMessage.slug ? $('#create-slug-error').html(errorMessage.slug[
                                0]) : '';
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
                deferRender:true,
                searchDelay:3000,
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            // =======================================
        });
    </script>
@endsection
