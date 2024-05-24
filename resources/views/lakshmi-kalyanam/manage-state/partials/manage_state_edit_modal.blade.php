<div class="modal fade" id="edit_state_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit State</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="data_update_form" enctype="multipart/form-data">
            <div class="row p-3">
                 <div class="col-md-12 mb-3">
                   <label for="name" class="form-label">Country</label>
                   <select class="form-select" name="edit_country" id="edit_country">
                    <option value="">- Select Country -</option>
					@for ($i=0; $i < $country->count(); $i++)
                    <option value="{{ $country[$i]->id }}">{{ $country[$i]->name }}</option>
                    @endfor
                   </select>
                   <p class="validate_errors" id="edit_country_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">State</label>
                    <input type="email" class="form-control" id="edit_state_title" name="edit_state_title" placeholder="Enter your State">
                    <p class="validate_errors" id="edit_state_title_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">Sort Order</label>
                    <input type="email" class="form-control" id="edit_sort_order" name="edit_sort_order" placeholder="Enter sort order">
                    <p class="validate_errors" id="edit_sort_order_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>
                <div class="col-md-12 mb-3">
                   <label for="name" class="form-label">Status</label>
                   <select class="form-select" id="edit_status_of_data" name="edit_status_of_data">
                     <option value="">Select Status</option>
                     <option value="Active">Active</option>
                     <option value="InActive">Inactive</option>
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
