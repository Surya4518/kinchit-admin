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
              <p id="service_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
            <div class="col-12 md-form mb-5">
              <label for="">Content : </label>
              <textarea class="form-control" name="edit_content" id="edit_content"></textarea>
              <p id="content_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
            <div class="col-12 md-form mb-5">
              <label for="">Status : </label>
              <select name="edit_status" class="form-control" id="edit_status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
              <p id="status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
            <div class="col-12 md-form mb-5">
              <label for="">Service Url : </label>
              <select name="edit_service_url" class="form-control" id="edit_service_url">
                <option value="">Select</option>
                @foreach($service as $service)
                <option value="{{$service->page_slug}}">{{$service->page_slug}}</option>
                @endforeach
              </select>
              <p id="service_url_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
            <!-- <div class="col-12 md-form mb-5">
              <label for="">Image : </label>
              <input type="file" class="form-control" name="edit_image" id="edit_image">
              <p id="image_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div> -->
            <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="col-8">
                              <label for="name" class="form-label">Image</label>
                      <input type="file" class="form-control" id="edit_image" name="edit_image" placeholder="Enter sort order">
                        </div>
                        <div class="col-4">
                              <img src="" alt="image" id="view_image" srcset="">
                      <p class="validate_errors" id="edit_upload_image_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                        </div>
                    </div>
                    
          </div>
            <div class="col-12 md-form mb-5">
              <label for="">Shord Order : </label>
              <input type="number" class="form-control" name="edit_shord_order" id="edit_shord_order">
              <p id="shord_order_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
               <input type="hidden" name="edit_service_id" id="edit_service_id">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer mx-auto">
        <button class="btn btn-secondary" onclick="UpdateTheDataOfService()">Submit</button>
      </div>
    </div>
  </div> <!-- modal-bialog .// -->
</div> <!-- modal.// -->