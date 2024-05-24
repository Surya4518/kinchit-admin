<div id="special_content_create_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Content</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="create_special_Content_form">
            <div class="md-form mb-5">
                <label for="">Category : </label>
                <select class="form-control" name="spe_category" id="spe_category">
                    <option value="">Select Category</option>
                    @for ($i=0; $i < $category->count(); $i++)
                    <option value="{{ $category[$i]->id }}">{{ $category[$i]->category_name }}</option>
                    @endfor
                </select>
                <p class="validate_errors" id="spe_category_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="row want_change"></div>
              <input type="hidden" name="category_type" id="category_type">
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="CreateContent()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
