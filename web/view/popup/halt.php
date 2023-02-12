<div class="pcontainer popup-delete">
    <div class="pcontent">
        <header class="pheader">
            <span class="material-icons ptitle-icon danger-text" style="font-size: 20px">pan_tool</span>
            <h2 class="ptitle cut-text"><?= $data['task'] ?></h2>
            <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                <span class="material-icons">close</span>
            </button>
        </header>

        <div class="pbody">

            <!-- Alert -->
            <div class="alert alert-danger mb-0" role="alert"></div>

            <form id="haltForm">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">

                <div class="form-group mb-2">
                    <label>Reason</label>
                    <textarea class="form-control" name="reason" rows="1" placeholder="Type the reason here"
                              style="min-height: 1rem; height: 34px; overflow-y: hidden;"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>End (Optional)</label>
                    <input type="date" class="form-control" min="<?= date('Y-m-d') ?>" name="end">
                </div>
            </form>

        </div>

        <footer class="pfooter">
            <button type="submit" form="haltForm" class="btn danger-btn">Halt</button>
            <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
        </footer>
    </div>
</div>