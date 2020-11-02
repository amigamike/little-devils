<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <h5 class="mark">Child Details</h5>
    <div class="toolbar-tab row">
        <div class="col-12">
            <a href="/" class="btn btn-info float-right">
                <i class="fas fa-plus"></i>&nbsp;New
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">First Name</label>
                <input name="child_first_name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="styled" for="">Last Name</label>
                <input name="child_last_name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="styled" for="">DOB</label>
                <input name="child_dob" type="text" class="form-control datepicker" placeholder="dd/mm/yyyy">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">Address 1</label>
                <input name="child_address_line_1" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="styled" for="">Address 2</label>
                <input name="child_address_line_2" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="styled" for="">Town</label>
                <input name="child_city" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="styled" for="">County</label>
                <input name="child_county" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="styled" for="">Postcode</label>
                <input name="child_postcode" type="text" class="form-control">
            </div>
        </div>
        <input name="child_id" type="hidden">
    </div>
    <div class="toolbar-tab row">
        <div class="col-12">
            <button class="btn btn-primary float-right">
                <i class="fas fa-save"></i>&nbsp;Save
            </button>
        </div>
    </div>
</div>