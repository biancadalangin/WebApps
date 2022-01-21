<?php 

include 'core/init.php';
  
$user_id = $_SESSION['user_id'];

$user = User::getData($user_id);
$who_users = Follow::whoToFollow($user_id);
$notify_count = User::CountNotification($user_id);

if (User::checkLogIn() === false) 
header('location: index.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Paws & Claws</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">

    <!-- time function to force css file to reload -->
    
    <link rel="stylesheet" href="assets/css/main_style.css?v=<?php echo time(); ?>">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <link rel="shortcut icon" type="image/png" href="assets/images/logo-main.png" style="width: 10;"> 
  
   
</head>
<body>
     


    <div id="mine">
    
    <div class="sidebar">
    
      <div class="logo-details">
        <img class="logo" src="assets\images\logo.png"/>
        <div class="logo_name">PAWS & CLAWS</div>
          <i class='bx bx-menu' id="btn" ></i>
      </div>
    
    <ul class="nav-list">
        <!-- home button -->        
        <li>
        <a href="home.php">
            <i style="font-size: 20px;" class='bx bx-home-smile'></i>          
            <span style="font-size: 18px;" class="links_name">Home</span>
        </a>
         <span class="tooltip">Home</span>
        </li>

        <!-- notifications button -->
        <li>
        <a href="notification.php">
            <i style="font-size: 20px;" class='bx bx-bell'></i> 
                      
            <span style="font-size: 18px;" class="links_name">Notifications
            <?php if ($notify_count > 0) { ?>
              <i class="notify-count"><?php echo $notify_count; ?></i> 
              <?php } ?>
          </span>
        </a>
        <span class="tooltip">Notifications</span>
        </li>
        
        <!-- profile button -->
        <li>
        <a href="<?php echo BASE_URL . $user->username; ?>">
        <i style="font-size: 20px;" class='bx bx-user'></i>         
        <span style="font-size: 18px;" class="links_name">Profile</span>
        </a>
        <span class="tooltip">Profile</span>
        </li>

          <!-- settings button -->
        <li>
        <a href="<?php echo BASE_URL . "account.php"; ?>">
        <i style="font-size: 30px;" class='bx bx-dots-horizontal-rounded'></i>         
        <span style="font-size: 18px;" class="links_name">Settings</span>
        </a>
        <span class="tooltip">Settings</span>
        </li>

        <!-- logout button -->
        <li>
        <a href="includes/logout.php">
        <i style="font-size: 25px;" class="bx bx-log-out" id="log_out"></i>
        <span style="font-size: 18px;" class="links_name">Logout</span>
        </a>
        <span class="tooltip">Logout</span>
        </li>

        </ul>
        </div> 
          
  

      <div class="grid-posts">
        <div class="border-right">
          <div class="grid-toolbar-center">
            <div class="center-input-search">
              
            </div>
           
          </div>

          <div class="box-fixed" id="box-fixed"></div>
  
          <div class="box-home feed">
               <div class="container">
               <div class="center">
                 
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">    
                  <a class="nav-link active text-center" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Change Email or Username</a>
                  <a class="nav-link text-center" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Change Password</a>
                </div>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <!-- Change EMAIL and USAERNAME Form -->

                    <form method="POST" action="handle/handleAccountSetting.php" class="py-4" >
                      
                    <?php  if (isset($_SESSION['errors_account'] )) {
                        
                        ?>
                              
                        <?php foreach ($_SESSION['errors_account'] as $error) { ?>

                            <div  class="alert alert-danger" role="alert">
                                <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </p>  
                            </div> 
                                    <?php }   ?> 

                        <?php }  unset($_SESSION['errors_account'])  ?>
                  <div class="row">
                    <div class="col-md-12">
                      <div class ="center">
                        <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>             
                        <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>

                      <div class="form-group">
                        <label for="exampleInputPassword1">Username</label>
                        <input type="text" name="username" value="<?php echo $user->username; ?>" class="form-control" id="exampleInputPassword1" placeholder="Username">
                      </div>
                      
                      <div class="text-center">

                        <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                      </div>

                        </div>

                    </form>
                    </div>
                  </div>  
                  </div>
                  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                  
               

                    <!-- Change Password Form -->
                    <form method="POST" action="handle/handleChangePassword.php" class="py-4" >
                    <script src="assets/js/jquery-3.5.1.min.js"></script>
                    <?php  if (isset($_SESSION['errors_password'] )) {
                        
                        ?>
                        

                         <script>  
                                $(document).ready(function(){
                            // Open modal on page load
                            $("#v-pills-profile-tab").click();
                    
                          });
                          </script>

                        <?php foreach ($_SESSION['errors_password'] as $error) { ?>

                            <div  class="alert alert-danger" role="alert">
                                <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </p>  
                            </div> 
                                    <?php }   ?> 

                        <?php }  unset($_SESSION['errors_password'])  ?>
                    <div class="row">
                    <div class="col-md-12">
                      <div class ="center">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Old Password</label>
                        <input type="password" name="old_password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Old Password">
                    
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" name="new_password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputPassword1">Verify Password</label>
                        <input type="password" name="ver_password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
                      </div>
                      
                      <div class="text-center">

                        <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                      </div>

                      </div>

                    </form>
                  </div>
                    </div>
                  </div>
     
                </div>
                   
               </div>
           
          </div>
        </div>
        <div> 

       
            
        <div style="width: 90%;" class="container">

            <div class="input-group py-2 m-auto pr-5 position-relative">

            <i id="icon-search" class="fas fa-search tryy"></i>
            <input type="text" class="form-control search-input"  placeholder="Search Paws & Claws">
            <div class="search-result">

        
            </div>
            </div>
       </div>


  
        </div>
      </div> </div>
      
  <!-- side nav bar script -->

      <script>
      let sidebar = document.querySelector(".sidebar");
      let closeBtn = document.querySelector("#btn");
      let searchBtn = document.querySelector(".bx-search");

      closeBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("open");
        menuBtnChange();//calling the function(optional)
      });

      searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
        sidebar.classList.toggle("open");
        menuBtnChange(); //calling the function(optional)
      });

      // following are the code to change sidebar button(optional)
      function menuBtnChange() {
      if(sidebar.classList.contains("open")){
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
      }else {
        closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
      }
      }


      </script>

      <script src="assets/js/search.js"></script>    
       <script src="assets/js/follow.js"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <!-- <script src="assets/js/jquery-3.4.1.slim.min.js"></script> -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>