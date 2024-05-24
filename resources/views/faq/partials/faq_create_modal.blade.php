<div class="modal fade" id="create_faq_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Faq</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body">
          <form method="post" id="data_create_form" enctype="multipart/form-data">
              <div class="row p-3">
                   <div class="col-md-12 mb-3">
                     <label for="name" class="form-label">Title</label>
                     <input type="text" class="form-control" name="faq_title" id="faq_title" placeholder="Enter your Title">
                     <p class="validate_errors" id="faq_title_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label for="name" class="form-label">Description</label>
                      <textarea id="faq_description" class="form-control" name="faq_description" placeholder="Enter your Description"></textarea>
                      <p class="validate_errors" id="faq_description_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label for="name" class="form-label">Sort Order</label>
                      <input type="email" class="form-control" id="sort_order" name="sort_order" placeholder="Enter sort order">
                      <p class="validate_errors" id="sort_order_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                  </div>
                  <div class="col-md-12 mb-3">
                     <label for="name" class="form-label">Status</label>
                     <select class="form-select" id="status_of_data" name="status_of_data">
                       <option value="">Select Status</option>
                       <option value="0">Active</option>
                       <option value="1">Inactive</option>
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
