<div class="modal fade" id="create_city_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add City</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="data_create_form" enctype="multipart/form-data">
            <div class="row p-3">
                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">City</label>
                    <input type="email" class="form-control" id="city_title" name="city_title" placeholder="Enter your city">
                    <p class="validate_errors" id="city_title_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>
                <div class="col-md-12 mb-3">
                   <label for="name" class="form-label">State</label>
                   <select class="form-select" id="state" name="state">
                     <option value="">Select state</option>
                     @for ($i=0; $i < $state->count(); $i++)
                    <option value="{{ $state[$i]->id }}">{{ $state[$i]->name }}</option>
                    @endfor
                   </select>
                   <p class="validate_errors" id="state_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">Sort Order</label>
                    <input type="text" class="form-control" id="sort_order" name="sort_order" placeholder="Enter sort order">
                    <p class="validate_errors" id="sort_order_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>
                <div class="col-md-12 mb-3">
                   <label for="name" class="form-label">Status</label>
                   <select class="form-select" id="status_of_data" name="status_of_data">
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="InActive">Inactive</option>
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
