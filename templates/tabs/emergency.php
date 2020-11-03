<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <h5 class="mark">Emergency Contacts</h5>
    <div id="contact" class="row">
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">First Name</label>
                <input name="first_name" type="text" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">Last Name</label>
                <input name="last_name" type="text" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">Phone</label>
                <input name="phone_no" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-2 col-lg-1">
            <div class="form-group">
                <label for="">&nbsp;</label><br>
                <button id="add-contact" type="button" class="btn btn-primary">
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