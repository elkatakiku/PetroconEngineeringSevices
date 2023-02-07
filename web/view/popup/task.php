<!--<div class="popup popup-center" id="taskPopup" tabindex="-1" aria-hidden="true">-->
    <div class="pcontainer">
        <div class="pcontent">
            <header class="pheader">
                <h2 class="ptitle">Task <?= $data['count'] ?></h2>
                <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                    <span class="material-icons">close</span>
                </button>
            </header>

            <div class="pbody">

                <!-- Alert -->
                <div class="alert alert-danger mb-0" role="alert"></div>

                <form id="taskForm">
                    <input type="hidden" name="projectId" value="<?= $data['id'] ?>">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="order" value="1">

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="1" placeholder="Type the task description here" style="min-height: 1rem; height: 34px; overflow-y: hidden;" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Duration</label>
                        <div class="linear">
                            <input type="date" class="form-control" name="start" data-start="taskDuration" min="<?= $data["completion"]['start'] ?>" max="<?= $data["completion"]['end'] ?>" required>
                            -
                            <input type="date" class="form-control" name="end" data-end="taskDuration" min="<?= $data["completion"]['start'] ?>" max="<?= $data["completion"]['end'] ?>" required>
                        </div>
                    </div>
                </form>

            </div>

            <footer class="pfooter">
                <button type="submit" form="taskForm" class="btn action-btn">Save</button>
                <button type="button" class="btn danger-btn delete-btn">
                    Delete
                </button>
                <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
            </footer>
        </div>
    </div>
<!--</div>-->