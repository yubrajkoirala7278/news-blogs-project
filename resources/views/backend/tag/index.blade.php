@extends('backend.layouts.master')
@section('content')
    <div class="container p-4 bg-white">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4">Tag</h2>
            {{-- open create tag modal --}}
            <button type="button" class="btn btn-transparent text-success " data-bs-toggle="modal" data-bs-target="#createTag"
                id="create-tag-btn">
                <i class="fa-solid fa-circle-plus fs-4"></i>
            </button>
        </div>
        {{-- create --}}
        @include('backend.tag.create')


        {{-- display tags --}}
        <table class="table table-bordered" id="tag-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tag</th>
                    <th>Slug</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


        {{-- edit tag --}}
        @include('backend.tag.edit')
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

            // =======prevent page to load on enter key===
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            // ========================================


            // ========adding data to db=========
            $('#create-tag-btn').click(function(e) {
                $('#create-tag-error').html('');
                $('#ajaxForm')[0].reset();
            });

            var createFormData = $('#ajaxForm')[0];
            $('#saveBtn').click(function() {
                var formData = new FormData(createFormData);
                $('#create-tag-error').html('');
                $.ajax({
                    url: "{{ route('tag.store') }}",
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function(response) {
                        $('#createTag').modal('hide');
                        console.log(response);
                        table.draw();
                        toastify().success(response[1]);
                    },
                    error: function(err) {
                        let errorMessage = err.responseJSON.errors;
                        if (errorMessage) {
                            errorMessage.tag ? $('#create-tag-error').html(
                                errorMessage.tag[0]) : '';
                        } else {
                            toastify().error('Something went wrong!');
                        }
                    }
                })
            })
            // ==================================

            // ==========Read tags for DB==========
            var table = $('#tag-table').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                searchDelay: 3000,
                ajax: "{{ route('tag.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tag',
                        name: 'tag'
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

            // ================delete tag=========
            $('body').on('click', '.deleteTag', function() {
                var tag_id = $(this).data("slug");
                confirm("Are You sure want to delete !");
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/tag/', '') }}" + '/' + tag_id,
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
            $('body').on('click', '.editTag', function() {
                // get form slug
                slug = $(this).data('slug');
                $('#edit-tag-error').html('');

                $.ajax({
                    url: '{{ url('admin/tag', '') }}' + '/' + slug + '/edit',
                    method: 'GET',
                    success: function(response) {
                        console.log(response.tag);
                        $('#editTag').modal('show');
                        $('#edit-tag').val(response.tag);
                    }
                })
            })
            // ================================================================

            // =================updating tag=================
            var updateFormData = $('#ajaxFormUpdate')[0];
            $('#updateBtn').click(function(e) {
                var formUpdateData = new FormData(updateFormData);
                $.ajax({
                    url: '{{ url('admin/tag/', '') }}' + '/' + slug,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formUpdateData,
                    success: function(response) {
                        $('#editTag').modal('hide');
                        table.draw();
                    },
                    error: function(err) {
                        let errorMessage = err.responseJSON.errors;
                        if (errorMessage) {
                            errorMessage.tag ? $('#edit-tag-error').html(
                                errorMessage.tag[0]) : '';
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
