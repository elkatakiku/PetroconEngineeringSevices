
<?php
  session_start();
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php";?>
  <body>
    <nav id="topbar" class="navbar navbar-expand-md navbar-light">
      <button id="sidebarCollapseToggler" type="button" class="btn icon-btn">
          <span class="material-icons">menu</span>
      </button>
      <strong class="user-type flex-grow-1">Petrocon</strong>
      <span class="material-icons">circle_notifications</span>
      <p class="user-name">Eli Lamzon</p>
      <span id="user-display" class="material-icons">account_circle</span>
    </nav>

    <div class="wrapper">
      <div id="sidebar">
        <nav>
          <ul class="list-unstyled components">
            <li class="">
              <a class="d-flex align-content-start" href="../dashboard.html">
                <span class="material-icons">dashboard</span>
                <div class="collapsible">
                  <span>Dashboard</span>
                </div> 
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="item-dropdown">
              <div class="dropdown-tile">
                <a class="d-flex align-content-start" data-toggle="collapse" href="#projectsCollapse" aria-expanded="false" aria-controls="contentId"> 
                  <span class="material-icons">handyman</span>
                  <div class="collapsible">
                    <span>
                      Projects
                      <span class="material-icons">arrow_drop_down</span>
                    </span>
                  </div>
                </a>
              </div>
              <ul class="collapse list-unstyled sub-menu" id="projectsCollapse">
                <li class="">
                  <a class="" href="projects.html">All</a>
                </li>
                <li class="">
                  <a class="" href="#">Done</a>
                </li>
                <li class="">
                  <a class="" href="#">Ongoing</a>
                </li>
                <li class="">
                  <a class="" href="#">Pending</a>
                </li>
              </ul>
            </li>
            <li class="active">
              <a class="d-flex align-content-start" href="message.html">
                <span class="material-icons">chat_bubble</span>
                <div class="collapsible">
                  <span>Messages</span>
                </div>
              </a>
            </li>
            <li class="item-dropdown">
              <div class="dropdown-tile">
                <a class="d-flex align-content-start" data-toggle="collapse" href="#teamCollapse" aria-expanded="false" aria-controls="contentId"> 
                  <span class="material-icons">workspaces</span>
                  <div class="collapsible">
                    <span>
                      Team
                      <span class="material-icons">arrow_drop_down</span>
                    </span>
                  </div>
                </a>
              </div>
              <ul class="collapse list-unstyled sub-menu" id="teamCollapse">
                <li class="">
                  <a class="" href="employees-admin.html">Employees</a>
                </li>
                <li class="">
                  <a class="" href="workers-admin.html">Workers</a>
                </li>
              </ul>
            </li>
            <li class="">
              <a class="d-flex align-content-start" href="users-admin.html">
                <span class="material-icons">people</span>
                <div class="collapsible">
                  <span>Users</span>
                </div>
              </a>
            </li>
  
            <hr>
  
            <li class="">
              <a class="d-flex align-content-start" href="profile.html">
                <span class="material-icons">person</span>
                <div class="collapsible">
                  <span>Profile</span>
                </div>
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="">
              <a class="d-flex align-content-start" href="../login/login.html">
                <span class="material-icons">logout</span>
                <div class="collapsible">
                  <span>Logout</span>
                </div>
              </a>
            </li>
          </ul>
        </nav>
      </div>
 
      <!----------MESSAGES----------------->
      <main class="content">
        <div class="column">
          <div class="left-side">
            <div class="msg-label">
              <h4>Messages</h4>
            </div>
            <div class="wrappers">
             <section class="users">
                <header>
                  <?php
                  include_once "php/config.php";
                  $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                  $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
                  $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                  if(mysqli_num_rows($sql) > 0){
                    $row = mysqli_fetch_assoc($sql);
                  }
                  ?>
                    <div class="contents">
                      <img src="php/images/<?php echo $row['img'] ?>" alt="">
                        <div class="details">
                          <span><?php echo $row['fname'] ." ". $row ['lname']?></span>
                          <p><?php echo $row['status']?></p>
                        </div>
                    </div>
                </header>
                <div class="search">
                  <span class="text">Select an user to start message</span>
                  <input type="text" placeholder="Enter name to search...">
                  <button><i class="fas fa-search"></i></button>
                </div>
                  <div class="users-list">
                    <a href="#">
                    <div class="contents">
                      <img src="php/images/<?php echo $row['img'] ?>" alt="">
                        <div class="details">
                          <span><?php echo $row['fname'] ." ". $row ['lname']?></span>
                          <p><?php echo $row['status']?></p>
                        </div>
                    </div>
                          <div class="status-dot">
                            <i class="fas fa-circle"></i>
                          </div>
                    </a>
                  </div>
                  <!----------->
                  <div class="users-list">
                    <a href="#">
                    <div class="contents">
                      <img src="php/images/<?php echo $row['img'] ?>" alt="">
                        <div class="details">
                          <span><?php echo $row['fname'] ." ". $row ['lname']?></span>
                          <p><?php echo $row['status']?></p>
                        </div>
                    </div>
                          <div class="status-dot">
                            <i class="fas fa-circle"></i>
                          </div>
                    </a>
                  </div>
                  <!----------->
             </section>
            </div>
          </div>
          <!---CHAT AREA--->
          <div class="right-side">
            <div class="wrappers">
              <section class="chat-area">
                 <header>
                      <!---<a href="#" class="back-icon"><i class="fas fa-arrow-left"></i></a>--->
                       <img src="php/images/<?php echo $row['img'] ?>" alt="">
                       <div class="details">
                          <span><?php echo $row['fname'] ." ". $row ['lname']?></span>
                          <p><?php echo $row['status']?></p>
                        </div>
                     </div>
                 </header>
                      <div class="chat-box">
                          <div class="chat outgoing">
                              <div class="details">
                                  <p>sample text</p>
                              </div>
                          </div>
                          <div class="chat incoming">
                            <img src="../images/1con.jpg" alt="">
                            <div class="details">
                                <p>sample text</p>
                            </div>
                         </div>
                      </div>
                      <form action="#" class="typing-area">
                          <input type="text" placeholder="type your message here...">
                            <button><ion-icon name="send-sharp"></ion-icon></button>
                      </form>
              </section>
              </div>
              <!----->
          </div>
      </div>
        
        </main>
        <!------------->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/4de3040dc0.js" crossorigin="anonymous"></script>

    <!-- External JS -->
    <script src="../scripts/index.js"></script>
    <script src="../messages/javascript/users.js"></script> <!--Search users-->
    <script src="../messages/javascript/chat.js"></script>              

    <!------send PIC------>
    <script>
      var loadFile = function (event) {
     var image = document.getElementById("output");
     image.src = URL.createObjectURL(event.target.files[0]);
     };
       </script>

    
    </body>
</html>
