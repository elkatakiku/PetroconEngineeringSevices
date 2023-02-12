<div class="pcontainer">
    <div class="pcontent">
        <div class="pheader">
            <h2 class="ptitle">Add Payment</h2>
            <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="linear-container pbody">

            <!-- Alert -->
            <div class="alert alert-danger mb-0" role="alert"></div>

            <!-- Content -->
            <form id="paymentForm">
                <input type="hidden" name="projectId" value="<?= $data['projId'] ?>">
                <input type="hidden" name="id">

                <div class="form-group">
                    <label for="">Date</label>
                    <input type="date" class="form-control" name="date" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                    <label for="">Bill</label>
                    <input type="text" class="form-control" name="description" required>
                </div>

                <div class="form-group">
                    <label for="">Amount</label>
                    <input type="number" class="form-control" step="any" name="amount" min=0
                           oninput="validity.valid||(value='');" required>
                </div>

            </form>
        </div>

        <div class="pfooter">
            <button type="submit" form="paymentForm" class="btn action-btn">Save</button>
            <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
        </div>
    </div>
</div>