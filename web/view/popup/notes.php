<div class="pcontainer popup-attention">
    <div class="pcontent">
        <header class="pheader">
            <h2 class="ptitle cut-text"><?= $data['resource'] ?></h2>
            <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                <span class="material-icons">close</span>
            </button>
        </header>

        <div class="pbody">

            <!-- Alert -->
            <div class="alert alert-danger mb-0" role="alert"></div>

            <form id="progressForm">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">

                <div class="form-group">
                    <label for="">Note</label>
                    <textarea class="form-control" name="notes" rows="2" placeholder="Enter the notes here."><?= $data['notes'] ?></textarea>
                </div>
            </form>

        </div>

        <footer class="pfooter">
            <button type="submit" form="progressForm" class="btn attention-btn">Save</button>
            <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
        </footer>
    </div>
</div>