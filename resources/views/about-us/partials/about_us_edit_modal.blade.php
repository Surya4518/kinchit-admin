<div id="service_artical_edit_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width: 75%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <form method="post" id="edit_service_form">
        <div class="row">
            <div class="col-12 md-form mb-5">
              <label for="">Title : </label>
              <input type="text" class="form-control" name="edit_title" id="edit_title">
              <p id="edit_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
            <div class="col-12 md-form mb-5">
              <label for="">Content : </label>
              <textarea class="form-control summernote" name="edit_content" id="edit_content"></textarea>
              <p id="edit_content_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
            <div class="col-12 md-form mb-5">
              <label for="">Status : </label>
              <select name="edit_status" class="form-control" id="edit_status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
              <p id="edit_status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
            <div class="col-md-12 mb-3"> 
              <label for="name" class="form-label">Video Content :</label>
            <!-- <input type="file" class="form-control" id="edit_image" name="edit_image" placeholder="Enter sort order"> -->
            <textarea name="edit_video_content" id="edit_video_content"  class="form-control"  cols="30" rows="10"></textarea>
            <p id="edit_video_content_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
          </div>
            <div class="col-12 md-form mb-5">
              <label for="">Shord Order : </label>
              <input type="number" class="form-control" name="edit_shord_order" id="edit_shord_order">
              <p id="edit_shord_order_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
               <input type="hidden" name="edit_service_id" id="edit_service_id">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer mx-auto">
        <button class="btn btn-secondary" onclick="UpdateTheDataOfAboutUs()">Submit</button>
      </div>
    </div>
  </div> <!-- modal-bialog .// -->
</div> <!-- modal.// -->