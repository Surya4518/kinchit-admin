<div id="sanchik_content_create_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Content</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="create_sanchik_content_form">
            <div class="md-form mb-5">
                <label for="">Category : </label>
                <select class="form-control" name="sanchik_category" id="sanchik_category">
                    <option value="">Select Category</option>
                    @for ($i=0; $i < $category->count(); $i++)
                    <option value="{{ $category[$i]->id }}">{{ $category[$i]->category_name }}</option>
                    @endfor
                </select>
                <p class="validate_errors" id="sanchik_category_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
            <div class="md-form mb-5">
                <label for="">Title : </label>
                <input type="text" class="form-control" placeholder="Enter the category name" name="pdf_title" id="pdf_title">
                <p class="validate_errors" id="pdf_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Language : </label>
                <select class="form-control" name="sanchik_language" id="sanchik_language">
                    <option value="">Select Category</option>
                    @for ($i=0; $i < $language->count(); $i++)
                    <option value="{{ $language[$i]->id }}">{{ $language[$i]->name }}</option>
                    @endfor
                </select>
                <p class="validate_errors" id="sanchik_language_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">PDF : </label>
                <input type="file" accept=".pdf" class="form-control" name="sanchik_pdf" id="sanchik_pdf">
                <p class="validate_errors" id="sanchik_pdf_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Status : </label>
                <select class="form-control" name="sanchik_pdf_status" id="sanchik_pdf_status">
                    <option value="">Select Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <p class="validate_errors" id="sanchik_pdf_status_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Sort Order : </label>
                <input type="number" class="form-control" placeholder="Enter the sort order" name="sanchik_pdf_sort" id="sanchik_pdf_sort">
                <p class="validate_errors" id="sanchik_pdf_sort_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="CreatePDFContent()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
