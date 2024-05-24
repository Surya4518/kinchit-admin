<div id="donation_category_edit_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Donation Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="edit_donation_category_form">
            <div class="row">
                    <div class="col-12 md-form mb-5">
                    <label for="">Category Name : </label>
                    <input type="hidden" class="form-control" name="edit_donation_category_id" id="edit_donation_category_id">
                    <input type="text" class="form-control" name="edit_category_name" id="edit_category_name">
                    <p id="category_name_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
                  </div>
                  <div class="col-12 md-form mb-5">
                    <label for="">Amount : </label>
                    <input type="text" class="form-control" name="edit_amount" id="edit_amount">
                    <p id="short_order_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
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
                </div>
                </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="UpdateTheDataOfDonationCategory()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
