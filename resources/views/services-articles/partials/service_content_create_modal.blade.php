<style>
    .modal{
        overflow:auto;
    }
</style>

<div id="service_content_create_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Service Content</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body mx-3">
            <form method="post" id="create_service_content_form">
            <div class="md-form mb-5">
                <label for="">Content Title : </label>
                <input type="text" class="form-control" name="service_content_title" id="service_content_title">
                <input type="hidden" name="service_article_id" id="service_article_id">
                <p id="service_content_title_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
              <div class="md-form mb-5">
                <label for="">Content Title : </label>
                <textarea name="service_content_description" id="service_content_description" class="summernote" cols="30" rows="10"></textarea>
                <p id="service_content_description_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
            </form>
        </div>
        <div class="modal-footer mx-auto">
            <button class="btn btn-secondary" onclick="CreateServiceContent()">Submit</button>
        </div>
      </div>
    </div> <!-- modal-bialog .// -->
  </div> <!-- modal.// -->
