<?php

   include 'core/init.php';
  
   $user_id = $_SESSION['user_id'];

   $user = User::getData($user_id);
   
   if (User::checkLogIn() === false) 
   header('location: index.php');


   $tweets = Tweet::tweets($user_id);
   $who_users = Follow::whoToFollow($user_id);
   $notify_count = User::CountNotification($user_id);
 
?>
    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Paws & Claws</title>
    
    <link rel="shortcut icon" type="image/png" href="assets/images/logo-main.png" style="width: 10;"> 
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/all.min.css">
        <link rel="stylesheet" href="assets/css/home_style.css?v=<?php echo time(); ?>">
    
         <!-- Boxicons CDN Link -->
     <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
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
          

      <div class="grid-posts">
        <div class="border-right">
          <div class="grid-toolbar-center">
            <div class="center-input-search">
              <div class="input-group-login" id="whathappen">
                
                <div class="container">
                  <div class="part-1">
                    
                    <div class="text">
                      <form class="" action="handle/handleTweet.php" method="post" enctype="multipart/form-data">
                        <div class="inner">
            
                            <img src="assets/images/users/default.jpg" alt="profile photo">
                        
                          <label>
            
                            <textarea class="text-whathappen" name="status" rows="8" cols="80" placeholder="What's happening?"></textarea>
                        
                        </label>
                        </div> 
                            
                         <!-- tmp image upload place -->
                        <div class="position-relative upload-photo"> 
                          <img class="img-upload-tmp">
                          <div class="icon-bg">
                          <i id="#upload-delete-tmp" class="fas fa-times position-absolute upload-delete"></i>  

                          </div>
                        </div>


                        <div class="bottom"> 
                          
                          <div class="bottom-container">
                              
                            
                              
                           
                            <label for="tweet_img" class="ml-3 mb-2 uni">

                              <i class="fa fa-image item1-pair"></i>
                            </label>
                            <input class="tweet_img" id="tweet_img" type="file" name="tweet_img">    
                                
                          </div>
                          <div class="hash-box">
                        
                              <ul style="margin-bottom: 0;">


                              </ul>
                          
                          </div>
                          <?php if (isset($_SESSION['errors_tweet'])) { 
                            
                            foreach($_SESSION['errors_tweet'] as $t) {?>
                            
                          <div class="alert alert-danger">
                          <span class="item2-pair"> <?php echo $t; ?> </span>
                          </div>
                         
                         <?php } } unset($_SESSION['errors_tweet']); ?>
                          <div>
                         
                            <span class="bioCount" id="count">140</span>
                            <input id="tweet-input" type="submit" name="tweet" value="Post" class="submit">

                          </div>
                      </div>
                      </form>
                    </div>
                  </div>
                  <div class="part-2">
            
                  </div>
            
                </div>
                
                
              </div>
            </div>      
          </div>
          <div class="box-fixed" id="box-fixed"></div>


          <?php include 'includes/tweets.php'; ?>                       

        </div>


        <div class="wrapper-right">
            <div  class="container">

          <div class="input-group py-2 m-auto pr-5 position-relative">

          <i id="icon-search" class="fas fa-search tryy"></i>
          <input type="text" class="form-control search-input"  placeholder="Search Paws & Claws">
          <div class="search-result">


          </div>
          </div>
          </div>
  
  
        </div>
      </div>
      </div> 

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
        <script src="assets/js/photo.js?v=<?php echo time(); ?>"></script>
        <script type="text/javascript" src="assets/js/hashtag.js"></script>
        <script type="text/javascript" src="assets/js/like.js"></script>
        <script type="text/javascript" src="assets/js/comment.js?v=<?php echo time(); ?>"></script>
        <script type="text/javascript" src="assets/js/retweet.js?v=<?php echo time(); ?>"></script>
        <script type="text/javascript" src="assets/js/follow.js?v=<?php echo time(); ?>"></script>
      <script src="https://kit.fontawesome.com/38e12cc51b.js" crossorigin="anonymous"></script>
      <!-- <script src="assets/js/jquery-3.4.1.slim.min.js"></script> -->
      <script src="assets/js/jquery-3.5.1.min.js"></script>

        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
</body>
</html> 