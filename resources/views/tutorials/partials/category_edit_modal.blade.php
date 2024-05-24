<div id="tutorial_category_edit_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="edit_tutorial_category_form">
            <div class="md-form mb-5">
                <label for="">Category Name : </label>
                <input type="text" class="form-control" placeholder="Enter the category name" name="edit_tut_category_name" id="edit_tut_category_name">
                <p class="validate_errors" id="edit_tut_category_name_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Category Type : </label>
                <select class="form-control" name="edit_tut_category_type" id="edit_tut_category_type">
                    <option value="">Select Type</option>
                    <option value="audio">Audio</option>
                    <option value="video">Video</option>
                </select>
                <input type="hidden" name="edit_tut_category_id" id="edit_tut_category_id">
                <p class="validate_errors" id="edit_tut_category_type_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Category Description : </label>
                <textarea class="form-control summernote" name="edit_tut_category_description" id="edit_tut_category_description" cols="30" rows="10"></textarea>
                <p class="validate_errors" id="edit_tut_category_description_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="UpdateTheDataTutorialCategory()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
