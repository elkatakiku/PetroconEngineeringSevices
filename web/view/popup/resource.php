<div class="pcontainer">
    <div class="pcontent">
        <div class="pheader">
            <h2 class="ptitle">Add Material</h2>
            <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                <span class="material-icons">close</span>
            </button>
        </div>

        <div class="linear-container pbody">

            <!-- Alert -->
            <div class="alert alert-danger mb-0" role="alert"></div>

            <!-- Content -->
            <form action="" class="container" id="itemForm">
                <input type="hidden" name="projectId" value="<?= $data['projId'] ?>">
                <input type="hidden" name="id">

                <div class="row">
                    <div class="col-8 pr-2 pl-0">
                        <div class="form-group m-0">
                            <label for="">Item name</label>
                            <input type="text" class="form-control" name="item">
                        </div>

                        <div class="form-group m-0">
                            <label for="">Note</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-4 pr-0 pl-2">
                        <label for="">Amount</label>
                        <div class="form-group">
                            <input type="number" class="form-control" name="price" step="any" min=0
                                   oninput="validity.valid||(value='');" title="Price per item (PHP)"
                                   placeholder="Price per item (PHP)">
                        </div>

                        <div class="form-group">
                            <input type="number" class="form-control" name="quantity" min=0
                                   oninput="validity.valid||(value='');" title="Quantity" placeholder="Quantity">
                        </div>

                        <div class="form-group">
                            <input type="number" class="form-control" name="total" readonly min=0
                                   oninput="validity.valid||(value='');" title="Total" placeholder="Total">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="pfooter">
            <button type="submit" form="itemForm" class="btn action-btn">Save</button>
            <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
        </div>
    </div>
</div>