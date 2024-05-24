<div id="edit_special_category_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="edit_special_category_form">
            <div class="md-form mb-5">
                <label for="">Category Name : </label>
                <input type="text" class="form-control" placeholder="Enter the category name" name="edit_spec_category_name" id="edit_spec_category_name">
                <p class="validate_errors" id="edit_spec_category_name_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Category Type : </label>
                <select class="form-control" name="edit_spec_category_type" id="edit_spec_category_type">
                    <option value="">Select Type</option>
                    <option value="audio">Audio</option>
                    <option value="video">Video</option>
                    <option value="content">Content</option>
                </select>
                <p class="validate_errors" id="edit_spec_category_type_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Status : </label>
                <select class="form-control" name="edit_spec_category_status" id="edit_spec_category_status">
                    <option value="">Select Type</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <p class="validate_errors" id="edit_spec_category_status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Thumbimage : </label>
                <input type="file" accept=".jpg,.jpeg,.png,.webp" class="form-control" name="edit_spec_category_image" id="edit_spec_category_image">
                <p class="validate_errors" id="edit_spec_category_image_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                <p><img src="" width="20%" id="thumbimage" height="20%">
                <!--<button type="button" onclick="DeleteImage()"><i class="fa fa-trash"></i></button>-->
                </p>
              </div>
              <div class="md-form mb-5">
                <label for="">Sort Order : </label>
                <input type="number" class="form-control" placeholder="Enter the sort order" name="edit_spec_category_sort" id="edit_spec_category_sort">
                <p class="validate_errors" id="edit_spec_category_sort_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                <input type="hidden" name="edit_spec_cat_id" id="edit_spec_cat_id">
              </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="UpdateTheDataCategory()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
