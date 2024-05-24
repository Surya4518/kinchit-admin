<div class="modal fade" id="edit_service_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit service</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body">
          <form method="post" id="data_update_form" enctype="multipart/form-data">
              <div class="row p-3">
                   <div class="col-md-12 mb-3">
                     <label for="name" class="form-label">Title</label>
                     <input type="text" class="form-control" name="edit_service_title" id="edit_service_title" placeholder="Enter your Title">
                     <p class="validate_errors" id="edit_service_title_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label for="name" class="form-label">Content</label>
                      <textarea id="edit_service_content"  cols="30" rows="10" class="form-control" name="edit_service_content" placeholder="Enter your Description"></textarea>
                      <p class="validate_errors" id="edit_service_content_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label for="name" class="form-label">Sort Order</label>
                      <input type="email" class="form-control" id="edit_short_order" name="edit_short_order" placeholder="Enter sort order">
                      <p class="validate_errors" id="edit_short_order_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="col-8">
                              <label for="name" class="form-label">Image</label>
                      <input type="file" class="form-control" id="edit_upload_image" name="edit_upload_image" placeholder="Enter sort order">
                        </div>
                        <div class="col-4">
                              <img src="uploads/2024/03/1711784743.jpg" alt="image" id="edit_image" srcset="">
                      <p class="validate_errors" id="edit_upload_image_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                        </div>
                    </div>
                    
                  </div>
                  <div class="col-12 mt-4">
                      <label for="video_url">Upload Video</label>
                      <textarea class="form-control" name="edit_video_url" id="edit_video_url" ></textarea>
                      <p class="validate_errors" id="edit_video_url_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                     <label for="name" class="form-label">Status</label>
                     <select class="form-select" id="edit_status_of_data" name="edit_status_of_data">
                       <option value="">Select Status</option>
                       <option value="Active">Active</option>
                       <option value="Inactive">Inactive</option>
                     </select>
                     <input type="hidden" name="edit_id" id="edit_id">
                     <p class="validate_errors" id="edit_status_of_data_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="UpdateTheData()">Submit</button>
        </div>
      </div>
    </div>
  </div>
