@extends('backend.layouts.master')
@section('content')
<div class="container bg-white p-4">
    <a class="btn btn-success mb-2" href="javascript:void(0)" id="createNewCategory"> Add Category</a>
    <table class="table table-bordered data-table">
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
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="categoryForm" name="categoryForm" class="form-horizontal">
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="category" name="category"
                                placeholder="Enter Category" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(function() {



        /*------------------------------------------

         --------------------------------------------

         Pass Header Token

         --------------------------------------------

         --------------------------------------------*/

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });



        /*------------------------------------------

        --------------------------------------------

        Render DataTable

        --------------------------------------------

        --------------------------------------------*/

        var table = $('.data-table').DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('category.index') }}",

            columns: [

                {
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



        /*------------------------------------------

        --------------------------------------------

        Click to Button

        --------------------------------------------

        --------------------------------------------*/

        $('#createNewCategory').click(function() {

            $('#saveBtn').val("create-category");

            $('#category_id').val('');

            $('#categoryForm').trigger("reset");

            $('#modelHeading').html("Create New Category");
            $('#saveBtn').html("Save");

            $('#ajaxModel').modal('show');

        });



        /*------------------------------------------

        --------------------------------------------

        Click to Edit Button

        --------------------------------------------

        --------------------------------------------*/

        $('body').on('click', '.editCategory', function() {

            $('#saveBtn').html("Update");

            var category_id = $(this).data('id');

            $.get("{{ route('category.index') }}" + '/' + category_id + '/edit', function(
            data) {

                $('#modelHeading').html("Edit Category");

                $('#saveBtn').val("edit-user");

                $('#ajaxModel').modal('show');

                $('#category_id').val(data.id);

                $('#category').val(data.category);


            })

        });



        /*------------------------------------------

        --------------------------------------------

        Create Category Code

        --------------------------------------------

        --------------------------------------------*/

        $('#saveBtn').click(function(e) {

            e.preventDefault();

            $('#saveBtn').html("Loading..");



            $.ajax({

                data: $('#categoryForm').serialize(),

                url: "{{ route('category.store') }}",

                type: "POST",

                dataType: 'json',

                success: function(data) {



                    $('#categoryForm').trigger("reset");

                    $('#ajaxModel').modal('hide');

                    table.draw();



                },

                error: function(data) {

                    console.log('Error:', data);

                    $('#saveBtn').html('Save Changes');

                }

            });

        });



        /*------------------------------------------

        --------------------------------------------

        Delete Category Code

        --------------------------------------------

        --------------------------------------------*/

        $('body').on('click', '.deleteCategory', function() {



            var category_id = $(this).data("id");

            confirm("Are You sure want to delete !");



            $.ajax({

                type: "DELETE",

                url: "{{ route('category.store') }}" + '/' + category_id,

                success: function(data) {

                    table.draw();

                },

                error: function(data) {

                    console.log('Error:', data);

                }

            });

        });



    });
</script>
@endsection

</html>