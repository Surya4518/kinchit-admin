<div class="modal fade" id="create_services_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Services</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body">
          <form method="post" id="data_create_form" enctype="multipart/form-data">
              <div class="row p-3">
                   <div class="col-md-12 mb-3">
                     <label for="name" class="form-label">Title</label>
                     <input type="text" class="form-control" name="service_title" required id="service_title" placeholder="Enter your Title">
                     <p class="validate_errors" id="service_title_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label for="name" class="form-label">Content</label>
                      <textarea id="service_description" cols="30" rows="10" class="form-control  summernote" required name="service_content" placeholder="Enter your Content"></textarea>
                      <p class="validate_errors" id="service_content_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label for="name" class="form-label">Sort Order</label>
                      <input type="number" class="form-control" required id="sort_order" name="sort_order" placeholder="Enter sort order">
                      <p class="validate_errors" id="sort_order_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label for="name" class="form-label">image</label>
                      <input type="file" class="form-control" required id="upload_image" name="upload_image" >
                      <p class="validate_errors" id="upload_image_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-12 mt-4">
                      <label for="video_url">Upload Video</label>
                      <textarea class="form-control" name="video_url" id="video_url" ></textarea>
                      <p class="validate_errors" id="video_url_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                     <label for="name" class="form-label">Status</label>
                     <select class="form-select" id="status_of_data" name="status_of_data" required>
                       <option value="">Select Status</option>
                       <option value="Active">Active</option>
                       <option value="Inactive">Inactive</option>
                     </select>
                     <p class="validate_errors" id="status_of_data_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="CreateData()">Submit</button>
        </div>
      </div>
    </div>
  </div>
