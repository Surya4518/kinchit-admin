<div class="modal fade" id="create_subsection_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Subsection</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="data_create_form" enctype="multipart/form-data">
            <div class="row p-3">
                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">Sub section</label>
                    <input type="email" class="form-control" id="subsec_title" name="subsec_title" placeholder="Enter your Subsection">
                    <p class="validate_errors" id="subsec_title_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>
                 <div class="col-md-12 mb-3">
                   <label for="name" class="form-label">Community</label>
                   <select class="form-select" id="community" name="community">
                    <option value="">- Select Community -</option>
                    @for ($i=0; $i < $community->count(); $i++)
                    <option value="{{ $community[$i]->id }}">{{ $community[$i]->name }}</option>
                    @endfor
                   </select>
                   <p class="validate_errors" id="community_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">Sort Order</label>
                    <input type="email" class="form-control" id="sort_order" name="sort_order" placeholder="Enter sort order">
                    <p class="validate_errors" id="sort_order_error" style="color: #f90404;font-size: 13px;font-family: 'circular';"></p>
                </div>

                <div class="col-md-12 mb-3">
                   <label for="name" class="form-label">Staus</label>
                   <select class="form-select" id="status_of_data" name="status_of_data"  aria-label="Default select example">
                    <option value="">- Select Status -</option>
                    <option value="Active">Active</option>
                    <option value="InActive">InActive</option>
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
