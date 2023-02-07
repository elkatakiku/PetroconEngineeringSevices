<div class="pcontainer popup-attention">
    <div class="pcontent">
        <header class="pheader">
            <h2 class="ptitle cut-text"><?= $data['task'] ?></h2>
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
                    <label>Progress</label>
                    <div class="form-group linear mb-0 flex-grow-1">
                        <input type="number" class="form-control" name="progress" value="<?= $data['progress'] ?>" min="0" max="100" oninput="validity.valid||(value='');" required>
                        <span style="font-weight: bold">%</span>
                    </div>
                </div>

<!--                <div class="form-group">-->
<!--                    <label>Documentation</label>-->
<!--                    <input type="file" name="" id="" multiple>-->
<!--                </div>-->

            </form>

        </div>

        <footer class="pfooter">
            <button type="submit" form="progressForm" class="btn attention-btn">Save</button>
            <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
        </footer>
    </div>
</div>