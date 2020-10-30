<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <h5 class="mark">Child Logs</h5>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label class="styled" for="">Type</label>
                <select name="" id="" class="form-control">
                    <option value="">Please Select</option>
                    <option>Attendance Note</option>
                    <option>Covid-19</option>
                    <option>Medical</option>
                    <option>Accident</option>
                    <option>Temp Collection Password</option>
                    <option>Other</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled" for="">Details</label>
                <textarea class="form-control" name="" id="" rows="5"></textarea>
            </div>
        </div>
        <div class="col-md-2 col-lg-1">
            <div class="form-group">
                <label for="">&nbsp;</label><br>
                <button class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
    <h5 class="mark">Log History</h5>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th width="120">Date</th>
                <th width="120">Added By</th>
                <th width="250">Type</th>
                <th>Details</th>
                <th class="text-center" width="75">Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>04/11/2020</td>
                <td>Nursery</td>
                <td class="text-bold">Attendance Note</td>
                <td>Missed a session today</td>
                <td class="text-center"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
            </tr>
            <tr>
                <td>05/11/2020</td>
                <td>Parent</td>
                <td class="text-bold">Covid-19</td>
                <td>Had a test and came out clear</td>
                <td class="text-center"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></td>
            </tr>
        </tbody>
    </table>
</div>