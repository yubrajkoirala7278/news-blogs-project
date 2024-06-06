<div class="modal fade" id="editCategory" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editCategoryLabel"
    aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editCategoryLabel">Edit Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ajaxFormUpdate">
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit-category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="edit-category" name="category">
                        <span class="text-danger text-sm" id="edit-category-error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="updateBtn">Submit</button>
            </div>
        </div>
    </div>
</div>
