<div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoice-tab">
    <h5 class="mark">Invoices</h5>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label class="styled">Type</label>
                <select name="type" class="form-control">
                    <option value="0" disabled>Please Select</option>
                    <option value="Attendance">Attendance</option>
                    <option value="Damage">Damage</option>
                    <option value="Medical">Medical</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label class="styled">Amount</label>
                <input class="form-control" name="amount" type="number" min="1" step="any" />
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled">Note</label>
                <textarea class="form-control" name="note" rows="5"></textarea>
            </div>
        </div>
        <div class="col-md-2 col-lg-1">
            <div class="form-group">
                <label>&nbsp;</label><br>
                <button id="add-invoice" type="button" class="btn btn-info btn-form" disabled>
                <i class="fas fa-plus"></i>&nbsp;Add
                </button>
            </div>
        </div>
    </div>
    <h5 class="mark">Invoice History</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="120">Date</th>
                <th width="120">Added By</th>
                <th width="250">Type</th>
                <th width="120">Amount (&pound;)</th>
                <th width="120">Status</th>
                <th>Note</th>
                <th class="text-center" width="75">Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>