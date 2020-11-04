<div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="report-tab">
    <h5 class="mark">Reports</h5>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label class="styled">Room</label>
                <select name="room" class="form-control"></select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label class="styled">Year</label>
                <select name="year" class="form-control">
                    <?php
                    for ($iLoop = (date('Y') - 1); $iLoop <= date('Y'); $iLoop++) {
                        ?>
                        <option value="<?= $iLoop; ?>"><?= $iLoop; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-2 col-lg-2">
            <div class="form-group">
                <label>&nbsp;</label><br>
                <button id="generate-report" type="button" class="btn btn-info">
                    <i class="fas fa-plus"></i>&nbsp;Generate
                </button>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <canvas id="report-chart" width="400" height="400"></canvas>
        </div>
    </div>
</div>