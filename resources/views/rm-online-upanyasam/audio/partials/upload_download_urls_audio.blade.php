<div id="update_download_urls_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download URLs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="border: none;background: transparent;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form method="POST" id="update_download_urls_form">
                    <input type="hidden" name="parent_id" id="parent_id">
                    <input type="hidden" name="category_id" id="category_id">
                    <label>Download URLs</label>
                        <div class="multi-field-wrapper">
                            <div class="multi-fields addmoreinputs">
                                <div class="multi-field mg-t-20">
                                    <input type="text" class="form-control" name="stuff[]" style="width: 85%;">
                                    <button type="button" class="btn-transition btn btn-outline-secondary remove-field" style="float: right;margin-top: -36px;"><i class="fe fe-x" style="font-size: 14px;"></i></button>
                                  </div>
                            </div>
                          <button type="button" class="add-field">Add field</button>
                        </div>
                  </form>
            </div>
            <div class="modal-footer mx-auto">
                <button class="btn btn-secondary" type="button" onclick="UpdateDownloadAudioURLs()">Submit</button>
            </div>
        </div>
    </div> <!-- modal-bialog .// -->
</div> <!-- modal.// -->
