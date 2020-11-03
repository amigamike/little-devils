<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <h5 class="mark">Emergency Contacts</h5>
    <div class="row mt-4">
        <div class="col float-right">
            <small class="required float-right">* required fields</small>
        </div>
    </div>
    <div id="contact" class="row">
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">First Name<span class="required">*</span></label>
                <input name="first_name" type="text" class="form-control" required>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">Last Name<span class="required">*</span></label>
                <input name="last_name" type="text" class="form-control" required>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">Phone no.<span class="required">*</span></label>
                <input name="phone_no" type="text" class="form-control" required>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">Relationship<span class="required">*</span></label>
                <input name="relationship" type="text" class="form-control" required>
            </div>
        </div>
        <div class="col-md-2 col-lg-1">
            <div class="form-group">
                <label for="">&nbsp;</label><br>
                <button id="add-contact" type="button" class="btn btn-info">
                    <i class="fas fa-plus"></i>&nbsp;Add
                </button>
            </div>
        </div>
    </div>
    <h5 class="mark">Added Contacts</h5>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th width="120">Date</th>
                <th width="120">Name</th>
                <th width="250">Phone</th>
                <th class="text-center" width="75">Delete</th>
            </tr>
        </thead>
        <tbody id="contacts"></tbody>
    </table>
</div>