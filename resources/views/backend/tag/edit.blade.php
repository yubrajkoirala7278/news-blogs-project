<div class="modal fade" id="editTag" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editTagLabel"
    aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editTagLabel">Edit Tag</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ajaxFormUpdate">
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit-tag" class="form-label">Tag</label>
                        <input type="text" class="form-control" id="edit-tag" name="tag">
                        <span class="text-danger text-sm" id="edit-tag-error"></span>
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