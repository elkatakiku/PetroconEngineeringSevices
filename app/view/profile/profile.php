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

          <form action="<?= SITE_URL.US.'profile/profiles'?>" method="POST" id="proform">
            <div class="form-group">
              <label for="">First Name</label>
              <input type="text" class="form-control" name="firstName" id="" aria-describedby="helpId" placeholder="Edit First Name">
            </div>
            <div class="form-group">
              <label for="">Middle Name</label>
              <input type="text" class="form-control" name="middleName" id="" aria-describedby="helpId" placeholder="Edit Middle Name">
            </div>
            <div class="form-group">
              <label for="">Last Name</label>
              <input type="text" class="form-control" name="lastName" id="" aria-describedby="helpId" placeholder="Edit Last Name">
            </div>
            <div class="form-group">
              <label for="">Email</label>
              <input type="text" class="form-control" name="email" id="" aria-describedby="helpId" placeholder="Edit Email">
            </div>
            <div class="form-group">
              <label for="">Address</label>
              <input type="text" class="form-control" name="address" id="" aria-describedby="helpId" placeholder="Edit Address">
            </div>
            <div class="form-group">
              <label for="">Contact no.</label>
              <input type="text" class="form-control" name="contactNo" id="" aria-describedby="helpId" placeholder="Edit Contact no.">
            </div>
            <div class="form-group">
              <label for="">Birthdate</label>
              <input type="date" class="form-control" name="birthdate" id="" aria-describedby="helpId" placeholder="">
            </div>
            <div class="form-group">
              <button type="button" class="btn action-btn" data-toggle="popup" data-target="#popupChangePass"> Change Password</button>
              <!---pop up to----->
            </div>
          </form>
          <div class="btn-side" style="text-align: center;">
            <button type="submit" form="proform" name="modifyProfile" class="btn action-btn">Save Change</button>
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
              <form action="<?= SITE_URL.US.'profile/profilesChangePass' ?>" method="POST" id="changePassForm">
                <div class="form-group">
                    <label for=""> Current Password</label>
                    <input type="password" class="form-control" name="currentPass" id="" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" class="form-control" name="newPass" id="" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="">Confirm New Password</label>
                    <input type="password" class="form-control" name="confirmNew" id="" placeholder="Password">
                </div>
              </form>
            </div>
            
            <div class="pfooter">
                <button type="submit" name="changePassword" form="changePassForm" class="btn action-btn">Save Changes</button>
                <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
            </div>
        </div>
    </div>
</div>