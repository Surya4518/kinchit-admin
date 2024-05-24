<div class="modal fade" id="assign_student_for_course_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Assign Course</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none;background: transparent;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <form method="post" id="assign_course_form">
            <div class="md-form mb-5">
                <label for="course_id">Course</label>
                <select class="form-control" name="course_id" id="course_id">
                    <option value="">---Select Course---</option>
                    @for ($i=0; $i < $courses->count(); $i++)
                    <option value="{{ $courses[$i]->ID }}">{{ $courses[$i]->post_title }}</option>
                    @endfor
                </select>
                <p id="course_id_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
              </div>
            <div class="md-form mb-5">
                <label for="student_id">Students</label>
              <select class="form-control" name="student_id[]" multiple id="student_id">
                <option value="">Select Student</option>
            </select>
            <p id="student_id_error" style="color: red;font-size: 12px;margin-left: 2px;"></p>
            </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-secondary" onclick="AssignCourseForStudent()">Submit</button>
      </div>
    </div>
  </div>
</div>

