@extends('backend.layouts.master')
@section('content')
    <div class="p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-success fw-semibold fs-4">Blogs</h2>
            <a href="{{ route('blog.create') }}" class="btn btn-transparent" data-toggle="tooltip" data-placement="bottom"
                title="Add Blogs"><i class="fa-solid fa-circle-plus fs-4 text-success"></i></a>
        </div>
        <table class="table data-table">
            <thead>
                <tr>
                    <th scope="col">S/N</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
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

           


            /*------------------------------------------

            --------------------------------------------

            Render DataTable

            --------------------------------------------

            --------------------------------------------*/
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                ordering: false,
                searchDelay: 3000,
                ajax: "{{ route('blog.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'is_published',
                        name: 'is_published',
                        render: function(data, type, full, meta) {
                                return `<div class='form-check form-switch'> <input class = 'form-check-input blog-status'
                                type = "checkbox"
                                role = "switch"
                                id = "blog-status">
                                    <label class = "form-check-label"
                                for = "blog-status"> ${data?'Published':'Unpublished'} </label> </div>
                                `;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],


            });


             //=== Set initial background color based on the switch value===
             $('.blog-status').each(function() {
                if ($(this).prop('checked')) {
                    $(this).css('background-color', 'green');
                } else {
                    $(this).css('background-color', 'red');
                }
            });
            // =========================================

            // =======toggle blog status switch==========
            $(document).on('click', '.blog-status', function() {
                var slug = $(this).data('slug');
                var isPublished = $(this).prop('checked') ? 1 : 0;

                if (isPublished) {
                    $(this).css('background-color', 'green');
                } else {
                    $(this).css('background-color', 'red');
                }

                // Create a FormData object
                var formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('is_published', isPublished);

                // Send AJAX request
                $.ajax({
                    url: '{{ url('admin/blog-status/') }}/' + slug,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            // ===============================

        })
    </script>
@endsection
