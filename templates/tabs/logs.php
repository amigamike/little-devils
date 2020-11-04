<div class="tab-pane fade" id="logs" role="tabpanel" aria-labelledby="logs-tab">
    <h5 class="mark">Child Logs</h5>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label class="styled">Type</label>
                <select name="type" class="form-control">
                    <option value="0" disabled>Please Select</option>
                    <option value="Attendance Note">Attendance Note</option>
                    <option value="Covid-19">Covid-19</option>
                    <option value="Medical">Medical</option>
                    <option value="Accident">Accident</option>
                    <option value="Temp Collection Password">Temp Collection Password</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled">Details</label>
                <textarea class="form-control" name="info" rows="5"></textarea>
            </div>
        </div>
        <div class="col-md-2 col-lg-1">
            <div class="form-group">
                <label>&nbsp;</label><br>
                <button id="add-log" type="button" class="btn btn-info btn-form" disabled>
                <i class="fas fa-plus"></i>&nbsp;Add
                </button>
            </div>
        </div>
    </div>
    <h5 class="mark">Log History</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="120">Date</th>
                <th width="120">Added By</th>
                <th width="250">Type</th>
                <th>Details</th>
                <th class="text-center" width="75">Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>