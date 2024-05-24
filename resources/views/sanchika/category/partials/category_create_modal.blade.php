<div id="sanchik_category_create_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="create_sanchik_category_form">
            <div class="md-form mb-5">
                <label for="">Category Name : </label>
                <input type="text" class="form-control" placeholder="Enter the category name" name="sanchik_category_name" id="sanchik_category_name">
                <p class="validate_errors" id="sanchik_category_name_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Status : </label>
                <select class="form-control" name="sanchik_category_status" id="sanchik_category_status">
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <p class="validate_errors" id="sanchik_category_status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Sort Order : </label>
                <input type="number" class="form-control" placeholder="Enter the sort order" name="sanchik_category_sort" id="sanchik_category_sort">
                <p class="validate_errors" id="sanchik_category_sort_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="CreateCategory()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
