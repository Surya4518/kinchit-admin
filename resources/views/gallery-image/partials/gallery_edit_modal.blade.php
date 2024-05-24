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
              <select name="edit_category_name" id="edit_category_name" class="form-control" require>
                    <option value="">Select</option>
                    @foreach( $gallery_category as $value)
                    <option value="{{$value->id}}">{{$value->category_name}}</option>
                    @endforeach
              </select>
              <p id="category_name_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
            <div class="col-12 md-form mb-5">
              <label for="">Tittle  : </label>
              <input type="text" class="form-control" name="edit_tittle" id="edit_tittle">
              <p id="tittle_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
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
            <!-- <div class="col-12 md-form mb-5">
              <label for="">Image: </label>
              <input type="file" class="form-control" name="edit_upload_image" id="edit_upload_image" require>
              <p id="image_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div> -->
            <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="col-8">
                              <label for="name" class="form-label">Image</label>
                      <input type="file" class="form-control" id="edit_upload_image" name="edit_upload_image" placeholder="Enter sort order">
                        </div>
                        <div class="col-4">
                              <img src="" alt="image" id="edit_image" srcset="">
                      <p class="validate_errors" id="edit_upload_image_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                        </div>
                    </div>
                    
                  </div>
            <div class="col-md-12 mb-3">
                      <label for="name" class="form-label">Description</label>
                      <textarea id="edit_description" cols="30" rows="10" class="form-control  summernote" required name="edit_description" placeholder="Enter your Description"></textarea>
                      <p class="validate_errors" id="edit_description_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
          </div>
        </form>
      </div>
      <div class="modal-footer mx-auto">
        <button class="btn btn-secondary" onclick="UpdateTheDataOfGalleryImage()">Submit</button>
      </div>
    </div>
  </div> <!-- modal-bialog .// -->
</div> <!-- modal.// -->