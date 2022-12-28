<main class="content">    
    <div class="wapper">
      
      <div class="profile-bg d-block">
      </div>

        <div class="profile-details-container">
          <div class="profile-display">
            <img src="<?=IMAGES_PATH?>ic0n.jpg" class="profile-img">
            <div class="profile-display-info">
              <h2 class="profile-name">Kathiana Fernandez <i class="fa-solid fa-pen-to-square"></i></h2> 
              <p >kathiana@email.com</p>
              <p class="position">Twerker</p>
            </div>
          </div>

          <form action="<?= SITE_URL.US.'profile/profiles' ?>" method="POST" id="proform">
              <div class="form-group">
                <label for="">Full Name</label>
                <input type="text" class="form-control" name="fullname" id="" aria-describedby="helpId" placeholder="Edit Full Name">
              </div>
              <div class="form-group">
                <label for="">Position/Title</label>
                <input type="text" class="form-control" name="position" id="" aria-describedby="helpId" placeholder="Edit Position/Title">
              </div>
              <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="form-control" name="username" id="" aria-describedby="helpId" placeholder="Edit Username">
              </div>
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email" id="" aria-describedby="helpId" placeholder="Edit Email">
              </div>
              <div class="form-group">
                <button type="button" class="btn action-btn" data-toggle="popup" data-target="#popupChangePass">
                  Change Password</button> <!---pop up to----->
              </div>
          </form>

          <div class="btn-side" style="text-align: center;">
            <button type="submit" form="proform" class="btn action-btn" onclick="changePage('clientprofile.html')">Save Change</button>
            <button type="button" class="btn outline-action-btn" onclick="changePage('clientprofile.html')">Cancel</button>
          </div>
        </div>
      </main>

<!-- Popup -->
<div class="popup popup-center" id="popupChangePass" tabindex="-1" aria-hidden="true">
    <div class="pcontainer">
        <div class="pcontent">
            <div class="pheader">
                <i class="fa-solid fa-lock"></i>
                <h2 class="ptitle">Change Password? <h2>
                        <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
            </div>

            <div class="pbody">
                <div class="form-group">
                    <label for=""> Current Password</label>
                    <input type="password" class="form-control" name="currentpass" id="" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" class="form-control" name="newpass" id="" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="">Confirm New Password</label>
                    <input type="password" class="form-control" name="confirmnew" id="" placeholder="Password">
                </div>
            </div>
            
            <div class="pfooter">
                <button type="submit" class="btn action-btn">Save Changes</button>
                <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
            </div>
        </div>
    </div>
</div>