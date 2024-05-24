<div id="gallery_category_edit_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Gallery Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="edit_gallery_category_form">
            <div class="row">
                    <div class="col-12 md-form mb-5">
                    <label for="">Category Name : </label>
                    <input type="hidden" class="form-control" name="edit_gallery_category_id" id="edit_gallery_category_id">
                    <input type="text" class="form-control" name="edit_category_name" id="edit_category_name">
                    <p id="category_name_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                  <div class="col-12 md-form mb-5">
                    <label for="">Sort Order : </label>
                    <input type="text" class="form-control" name="edit_short_order" id="edit_short_order">
                    <p id="short_order_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                  <!-- <div class="col-12 md-form mb-5">
                    <label for="">Status: </label>
                    <input type="text" class="form-control" name="edit_status" id="edit_status">
                    <p id="status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div> -->
                  <div class="col-md-12 mb-3">
                     <label for="name" class="form-label">Status</label>
                     <select class="form-select" id="edit_status" name="edit_status">
                       <option value="">Select Status</option>
                       <option value="Active">Active</option>
                       <option value="Inactive">Inactive</option>
                     </select>
                     <!-- <input type="hidden" name="edit_id" id="edit_id"> -->
                     <p class="validate_errors" id="edit_status_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>
                </div>
                </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="UpdateTheDataOfGalleryCategory()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
