<main class="content">
    <div class="trailer">
        <h2 class="trail"><span class="cut-text"><?= $data['project']['description'] ?></span>&nbsp/&nbspInvitations</h2>
    </div>
     <!-- Header -->
    <div class="page-header">
        <span>     
            <a id="backBtn" href="<?= SITE_URL.'/project/details/'.$data['project']['id'] ?>" class="linear link-btn mb-2">
                <span class="material-icons">
                    arrow_back
                </span>
                <small>Go back</small>
            </a>
            <h1 class="page-title">Invitations</h1>
        </span>

        <div class="search-form align-self-end">
            <div class="input-container">
                <div class="input-prepend">
                    <i class="fa fa-search icon" aria-hidden="true"></i>
                </div>
                <input type="text" name="" id="searchInvitations" placeholder="Search people">
            </div>
        </div>
    </div>
    
    <div class="main-content mt-0">
        <form class="linear-container mb-3" id="inviteForm">
            <div class="alert alert-danger" role="alert"></div>
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Enter name here">
            </div>
            <div class="linear basis-12">
                <div class="form-group basis-10 mb-0">
<!--                    <label for="">Email</label>-->
                    <span class="loading-input">
                            <input type="email" class="form-control top" name="email" id="email" aria-describedby="helpId" placeholder="Enter email here" required>
                            <div class="loading" style="display: none;">
                                <div class="spinner-grow spinner-grow-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </span>
                    <small id="helpId" class="form-text text-danger"></small>
                </div>
<!--                <div class="form-group">-->
<!--                    <input type="email" class="form-control" name="email" placeholder="Enter email here" required>-->
<!--                </div>-->
                <div class="basis-12 basis-md-2 pl-md-0 pos-relative">
                    <button type="submit" class="btn action-btn btn-block" id="inviteSubmit">Invite</button>
                    <span class="cstm-spinner white-border" style="display: none;"></span>
                </div>
            </div>
        </form>

        <div class="mesa-container">
            <table class="mesa" id="inviteTable">
                <thead class="mesa-head">
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <!-- <tbody>
                    <tr>
                        <th scope="row"></th>
                        <td>vana</td>
                        <td>09152934627</td>
                        <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                    </tr>
                    
                    <tr>
                        <th scope="row"></th>
                        <td>vana</td>
                        <td>09152934627</td>
                        <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                    </tr>
                    
                    <tr>
                        <th scope="row"></th>
                        <td>vana</td>
                        <td>09152934627</td>
                        <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                    </tr>
                    
                    <tr>
                    <th scope="row"></th>
                    <td>vana</td>
                    <td>09152934627</td>
                    <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                    </tr>
                    
                    <tr>
                    <th scope="row"></th>
                    <td>effer</td>
                    <td>09152934627</td>
                    <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                    </tr>
                    
                    <tr>
                    <th scope="row"></th>
                    <td>elkatakiki</td>
                    <td>elimarimae@emailcom</td>
                    <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                    </tr>
                    
                    <tr>
                    <th scope="row"></th>
                    <td>kath</td>
                    <td>09152934627</td>
                    <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                    </tr>
                </tbody> -->
            </table>
        </div>

    </div>
</main>

<script>
    let projectId = '<?= $data['project']['id'] ?>';
</script>