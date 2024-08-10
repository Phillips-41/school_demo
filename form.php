<div class="modal fade" id="userModal" role="dialog" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adding or Updating Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span >&times;</span>
                </button>
            </div>
            <form action="POST" id="addform" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Name -->
                    <div class="form-group">
                        <label >Name :</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter Your Name" autocomplete="off" required="required" id="username" name="username">
                        </div>
                    </div>
                    <!-- email -->
                    <div class="form-group">
                        <label >Email :</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter Your Email" autocomplete="off" required="required" id="email" name="email">
                        </div>
                    </div>
                    <!-- Adress -->
                     <div class="form-group">
                        <label >Address :</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter Your Adsress" autocomplete="off" required="required" id="address" name="address">
                        </div>
                    </div>
                    <!-- class -->
                     <div class="form-group">
                        <label >Class Name :</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter Your Class" autocomplete="off" required="required" id="class" name="class">
                        </div>
                    </div>
                    <!-- Photo -->
                     <div class="form-group">
                        <label >Upload Photo :</label>
                        <div class="input-group">
                            <label class="custom-file-label" for="userphoto">Choose File</label>
                            <input type="file" class="custom-file-input" name="userphoto" id="userphoto">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                    <input type="hidden" name="action" value="addstudent">
                    <input type="hidden" name="studentId" value="" id="studentId">
                </div>
            </form>
            </div>
        </div>
    </div>