<main class="content">
        <!-- Header -->
    
        <!-- ?= $data['type'] ?> pag mageecho lng ng isang data use this shortcut-->
       
        <div class="page-header">
          <nav class="nav-tab-container">
            <div class="linear">
              <h1 class="page-title">
                <?= ucwords($data['type']) ?> <!-- $data array name, need key 'type'  para makuha value -->
              </h1>
            
              <!-- New Employee -->

              <button type="button" class="btn primary-btn align-self-center" data-toggle="popup" data-target="#addUser">
                Add Client
              </button>
            </div>

            <!-- Search -->
            <div class="space-between">
              <div class="search-container">
                <form action="" class="search-form">
                  <div class="input-container">
                    <div class="input-prepend">
                      <i class="fa fa-search icon" aria-hidden="true"></i>
                    </div>
                    <input type="text" name="" id="" placeholder="Search client">
                  </div>
                </form>
              </div>
            </div>
          </nav>
        </div>

        <!-- Users Table -->
        <div class="mesa-container">  
          <table class="mesa" id="usersTable">
            <thead class="mesa-head">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Position</th>
                <th scope="col">Address</th>
                <th scope="col">Contact</th>
                <th scope="col">Birthdate</th>
                <th scope="col">Action</th>
                <th scope="col"></th>
              </tr>
            </thead>
            
          </table>
        </div>

         <!-- Popup -->
        <div class="popup fade popup-center" id="addUser" tabindex="-1" aria-hidden="true">
          <div class="pcontainer">
            <div class="pcontent">
                <div class="pheader">
                  <div class="linear-center">
                      <!-- Can add icon here -->
                      <i class="fa-solid fa-user-plus"></i>
                      <h2 class="ptitle">Client</h2>
                  </div>
                  <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>
      
                <div class="pbody">
                  <form id="usermanform" action="<?= SITE_URL ?>/users/new" method="post">
                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" name="firstname" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" name="lastname" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Middle Name:</label>
                        <input type="text" name="middleName" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Email Address:</label>
                        <input type="email" name="email" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Password Repeat:</label>
                        <input type="password" name="passwordRepeat" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Position:</label>
                        <input type="text" name="position" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Address:</label>
                        <input type="text" name="address" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Contact No.:</label>
                        <input type="text" name="contactNumber" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label>Birthdate:</label>
                        <input type="date" name="birthdate" class="form-control" value="">
                    </div>
                  </form> 
                </div>

        
                <!-- Before -->
      
                  <div class="pfooter">
                    <!-- Prepend -->
                    <button type="submit" name="createUser" form="usermanform" class="btn action-btn" data-dismiss="popup">Submit</button>
                    <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
                    <!-- Append -->
                  </div>
                  <!-- After -->
            </div>
          </div>
        </div><?= $data['type'] ?>
      </main>

      <script>
        let usersId = '<?= $data['type'] ?>'; // to move data of php to js, they connect here
      </script>