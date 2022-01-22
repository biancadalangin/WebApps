<?php  
        include 'core/init.php';

        $user_id = $_SESSION['user_id'];
        $user = User::getData($user_id);
        $who_users = Follow::whoToFollow($user_id);

        // update notification count
        User::updateNotifications($user_id);
  
        $notify_count = User::CountNotification($user_id);
        $notofication = User::notification($user_id);
        // var_dump($notofication);
        // die();
            if (User::checkLogIn() === false) 
            header('location: index.php');    

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications | Paws & Claws</title>
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
          
      <div class="grid-posts">
        <div class="border-right">
          
          <div class="box-home feed">
             
                 <div class="container mt-5">

                     <?php foreach($notofication as $notify) { 
                         $user = User::getData($notify->notify_from);
                         $timeAgo = Tweet::getTimeAgo($notify->time);
                         ?>
                     <?php if ($notify->type == 'like') { 
                        $icon = "<i style='color: #C37179; font-size:30px;' class='fa-heart  fas ml-2'></i>";
                        $msg = "Liked your post";
                        } else if ($notify->type == 'retweet') { 
                            $icon = "<i style='color: #A3BFBC; font-size:30px;'  class='fas fa-retweet ml-2'></i>";
                            $msg = "Reposted your post";
                        } else if ($notify->type == 'qoute') { 
                            $icon = "<i style='color: #A3BFBC; font-size:30px;'  class='fas fa-retweet ml-2'></i>";
                            $msg = "Qouted your postt";
                        } else if ($notify->type == 'comment') { 
                            $icon = "<i style='color: #3B3B3B; style='font-size:30px;' class='far fa-comment ml-2'></i>";
                            $msg = "Replied to your post";
                        } else if ($notify->type == 'reply') { 
                            $icon = "<i style='color: #3B3B3B; style='font-size:30px;' class='far fa-comment ml-2'></i>";
                            $msg = "Replied to your comment";
                        } else if ($notify->type == 'follow') { 
                            $icon = "<i style='color: #3B3B3B; font-size:30px;' class='fas fa-user ml-2'></i>";
                            $msg = "Followed you";
                        } else if ($notify->type == 'mention') { 
                          $icon = "<i style='color: #3B3B3B; font-size:30px;' class='fas fa-user ml-2'></i>";
                          $msg = "Mentioned you in a post";
                        }?>
                      
                     <div style="position: relative; border-bottom:1px solid #DADADA;" class="box-tweet py-3 ">
                        <a href="
                        <?php if ($notify->type == 'follow'){ 
                            echo $user->username;
                        } else { ?>
                            status/<?php echo $notify->target; ?>
                        <?php } ?>  ">
                        <span style="position:absolute; width:100%; height:100%; top:0;left: 0; z-index: 1;"></span>
                        </a>
                            <div class="grid-tweet">
                                <div class="icon mt-2">
                                    <?php echo $icon; ?>
                                </div>
                                <div class="notify-user">
                                    <p>
                                    <a style="position: relative; " href="<?php echo $user->username;  ?>">
                                        <img class="img-user" style="height: 35px;" src="assets/images/users/<?php echo $user->img ?>" alt="">
                                    </a> 
                                    
                                    </p>
                                    <p> <a style="font-weight: 700;
                                    font-size:18px;
                                    position: relative;" href="<?php echo $user->username; ?>">
                                    <?php echo $user->name; ?> </a> <?php echo $msg; ?> 
                                    <span style="font-weight: 500;" class="ml-3">
                                      <?php echo $timeAgo; ?>
                                    </span> 
                                  </p>
                                </div>
                            </div>
                        </div> 
                     <?php  } ?> 
                 </div>
                
               
        
        </div>
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
            <script src="assets/js/photo.js"></script>
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