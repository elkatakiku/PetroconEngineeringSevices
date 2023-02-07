<div class="pcontainer popup-sucess">
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

            <form id="resumeForm">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">

                <p>Do you want to resume operation of <em><?= $data['task'] ?></em>?</p>
            </form>

        </div>

        <footer class="pfooter">
            <button type="submit" form="resumeForm" class="btn success-btn">Continue</button>
            <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
        </footer>
    </div>
</div>