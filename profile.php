<?php  
   
    if (isset($_GET['username']) === true && empty($_GET['username']) === false ) {
        include 'core/init.php';
        $username = User::checkInput($_GET['username']);
        $profileId = User::getIdByUsername($username);
        $profileData = User::getData($profileId);
        $user_id = $_SESSION['user_id'];
        $user = User::getData($user_id);
        $who_users = Follow::whoToFollow($user_id);
        $tweets = Tweet::tweetsUser($profileData->id);
        $liked_tweets = Tweet::likedTweets($profileData->id);
        $media_tweets = Tweet::mediaTweets($profileData->id);
        $notify_count = User::CountNotification($user_id);
      
        if (!$profileData)
            header('location: index.php');

            if (User::checkLogIn() === false) 
            header('location: index.php');    

    }
 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $profileData->name; ?> (@<?php echo $profileData->username; ?>) | Paws & Claws</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/main_style.css?v=<?php echo time(); ?>">
  
     <!-- Boxicons CDN Link -->
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
     <link rel="shortcut icon" type="image/png" href="assets/images/logo-main.png" style="width: 10;"> 
   
</head>
<body>

<script src="assets/js/jquery-3.5.1.min.js"></script>

   
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

        <div class="wrapper-right">
        <div style="width: 90%;" class="container">

            <div class="input-group py-2 m-auto pr-5 position-relative">

            <i id="icon-search" class="fas fa-search tryy"></i>
            <input type="text" class="form-control search-input"  placeholder="Search Paws & Claws">
            <div class="search-result">

        
            </div>
            </div>
       </div>
      </div>
          
          
      <div class="grid-posts">
        <div class="border-right">
        
            <div class="box-home feed">
            <div class="titlecenter">

            <!-- profile photo -->
            <div class="row justify-content-between">   
            <img class="home-img-user" src="assets/images/users/default.jpg" alt="">
            

                  <?php if ($user->id == $profileData->id) { ?>

                      <!-- Edit profile button -->
                      <button class="home-edit-button" data-toggle="modal" data-target="#edit">Edit Profile</button>
                      
                    <!-- Modal Edit Profile -->
                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">

                        <form method="POST" action="handle/handleUpdateData.php" enctype="multipart/form-data">

                            <div style="width: 235%;" class="d-flex justify-content-between">  
                            <div>              
                            <h5 class="modal-title d-inline" id="exampleModalLongTitle" style="font-weight: 700;">EDIT PROFILE</h5>
                            </div>
                            
                            <!-- btn save form -->   
                            <div>                              
                            <button type="submit" name="update" class="btn btn-primary">Save</button>
                            </div>
                                
                         </div>
                            
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <div class="col-md-12">                        
                            </div>                        
                            <div class="image-upload">
                           </div>
                            </div>

                            <?php  if (isset($_SESSION['errors'] )) { ?>
                            <script>  
                                $(document).ready(function(){
                            // Open modal on page load
                            $("#edit").modal('show');
                    
                          });
                          </script>
                                    <?php foreach ($_SESSION['errors'] as $error) { ?>
                                          <div  class="alert alert-danger" role="alert">
                                            <p style="font-size: 15px;" class="text-center"> <?php echo $error ; ?> </div>  <?php }  }
                                            unset($_SESSION['errors']) ?> </p>  


                        <div class="form-group">
                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="<?php echo $user->name; ?>" aria-describedby="emailHelp" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <input type="text" name="bio" class="form-control" id="exampleInputEmail1" value="<?php if ($user->bio !== null) 
                            echo $user->bio ;?>" aria-describedby="emailHelp" placeholder="Bio">
                        </div>

                        <div class="form-group">                  
                            <input type="text" name="website" class="form-control" id="exampleInputEmail1" value="<?php if ($user->website !== null) 
                            echo $user->website ;?>" aria-describedby="emailHelp" placeholder="Website">                       
                        </div>

                        <div class="form-group">     
                            <input type="text" name="location" class="form-control" value="<?php if ($user->location !== null) 
                            echo $user->location ;?>" id="exampleInputPassword1" placeholder="Location">
                        </div>
                            
                        </form>
                        </div>
                        
                        </div>
                    </div>
                    </div> 
                    <!-- End Edit Modal -->

                    <?php } else { 
                      $user_follow = Follow::isUserFollow($user_id , $profileData->id) ;
                      ?>
                   <button class=" follow-btn 
                   <?= $user_follow ? 'following' : 'follow' ?>" 
                  data-follow="<?php echo $profileData->id; ?>"> 
                    <?php if($user_follow) { ?>
                        Following 
                      <?php } else {  ?>  
                          Follow
                        <?php }  ?>  
                    </button>
                      <?php } ?> 


                 </div>

             
                  <div class="home-title">
                    <h4><?php echo $profileData->name; ?></h4>
                    <p class="user-handle" style="color: gray;">@<?php echo $profileData->username; ?>
                    <?php if (Follow::FollowsYou($profileData->id , $user_id)) { ?>
                  <span class="ml-1 follows-you">Follows You</span></p>
                  <?php } ?>
                    <p class="bio"><?php echo $profileData->bio; ?> </p>
                  </div>

                  <div class="row home-loc-link ml-2">
                      <?php if (!empty($profileData->location)) { ?>
                    <div class="col-md-4">
                      <li class=""> <i class="fas fa-map-marker-alt"></i> <?php echo $profileData->location; ?></li>
                    </div>
                    <?php } ?>
                    <?php if (!empty($profileData->website)) { ?>
                    <div class="col-md-4">
                    <li><i class="fas fa-link"></i> 
                    <a href="<?php echo $profileData->website ;?>" target="_blank">
                    <?php echo parse_url($profileData->website, PHP_URL_HOST);; ?>
                  </a> </li>
                    </div>
                    <?php } ?>
                  </div>

                  <!-- following and follower count -->
                  <div class="row home-follow ml-2 mt-1">
                      <div class="col-md-3">
                          <i class="count-following-i"
                          data-follow = "<?php echo $profileData->id; ?>" >
                           <span class="home-follow-count count-following"><?php echo Follow::countFollowing($profileData->id); ?></span> Followings</i>
                      </div>
                      <div class="col-md-3">
                         <i class="count-followers-i"
                         data-follow = "<?php echo $profileData->id; ?>"> 
                         <span class="home-follow-count count-followers"><?php echo Follow::countFollowers($profileData->id); ?></span> Followers</i>
                      </div>   
                  </div>
                  

                  <div class="popupUsers">            
                  </div>       
                  
                  
                     <ul class="nav nav-tabs justify-content-center mt-4" id="myTab" role="tablist">
                       
                     <!-- user's tweets tab -->
                     <li class="nav-item">
                         <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                           Posts</a>
                       </li>

                       <!-- user's media tab -->
                       <li class="nav-item">
                         <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                           Media</a>
                       </li>

                       <!-- user's likes tab -->
                       <li class="nav-item">
                         <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                           Likes</a>
                       </li>
                     </ul>
                 
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <?php include 'includes/tweets.php'; ?>                       
                  </div>

                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?php
                       $tweets = $media_tweets;
                       include 'includes/tweets.php'; ?>
                  </div>
              
                  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                       <?php
                       $tweets = $liked_tweets;
                       include 'includes/tweets.php'; ?>
                  </div>
                  </div>
            
               </div>
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
          <script src="assets/js/follow.js?v=<?php echo time(); ?>"></script>
          <script src="assets/js/users.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/hashtag.js"></script>
          <script type="text/javascript" src="assets/js/like.js"></script>
          <script type="text/javascript" src="assets/js/comment.js?v=<?php echo time(); ?>"></script>
          <script type="text/javascript" src="assets/js/retweet.js?v=<?php echo time(); ?>"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <!-- <script src="assets/js/jquery-3.4.1.slim.min.js"></script> -->
        <script src="assets/js/jquery-3.5.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>