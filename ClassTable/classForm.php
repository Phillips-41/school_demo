<div class="modal fade" id="classModal" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding or Updating Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span >&times;</span>
                </button>
            </div>
            <form action="POST" id="classform" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Name -->
                    <div class="form-group">
                        <label >Class Name :</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter Your Name" autocomplete="off" required="required" id="className" name="className">
                        </div>
                    </div>
                <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                    <input type="hidden" name="action" value="addclass">
                    <input type="hidden" name="classId" value="" id="classId">
                </div>
            </form>
            </div>
        </div>
    </div>