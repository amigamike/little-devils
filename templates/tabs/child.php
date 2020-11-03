<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <h5 class="mark">Child Details</h5>
    <div class="toolbar-tab row">
        <div class="col-12">
            <a href="/" class="btn btn-info float-right">
                <i class="fas fa-plus"></i>&nbsp;New
            </a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col float-right">
            <small class="required float-right">* required fields</small>
        </div>
    </div>
    <div id="child-data" class="row">
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">First Name<span class="required">*</span></label>
                <input name="first_name" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="styled" for="">Last Name<span class="required">*</span></label>
                <input name="last_name" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="styled" for="">DOB<span class="required">*</span></label>
                <input name="dob" type="text" class="form-control datepicker" placeholder="dd/mm/yyyy" required>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">Address 1<span class="required">*</span></label>
                <input name="address_line_1" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="styled" for="">Address 2</label>
                <input name="address_line_2" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="styled" for="">Town<span class="required">*</span></label>
                <input name="city" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="styled" for="">County<span class="required">*</span></label>
                <input name="county" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="styled" for="">Postcode<span class="required">*</span></label>
                <input name="postcode" type="text" class="form-control" required>
            </div>
        </div>
        <input name="id" type="hidden">
        <input name="type" type="hidden" value="child">
    </div>
</div>