<?php 
 
  
    include 'core/init.php' ;
    
    if (isset($_SESSION['user_id'])) {
      header('location: home.php');
    }
   
?>

<!DOCTYPE html>
<html>
<head>
    <title>Paws & Claws</title>

    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/index_style.css">
    <link rel="shortcut icon" type="image/png" href="assets/images/logo-main.png" style="width: 10;"> 

</head>
<body> 
<?php

    
?>
    <div class="container">
        <div class="myCard">
            <div class="row">
                <div class="col-md-6">
                    <div class="myLeftCtn"> 
                        <form action="./handle/handlelogin.php" method="post" class="myForm text-center">
                        <h1>LOG IN</h1>
                            <div class="form-group">
                                <i class="fas fa-user"></i>
                                <input class="myInput" name="email" type="email" placeholder="Email" id="email" required> 
                            </div>

                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <input class="myInput" name="password" type="password" id="password" placeholder="Password" required> 
                            </div>

                            <input type="submit" name="login" class="butt" value="LOG IN">
                            
                            <br><br><br>
                           
                            <h2 class="signup">Don't have an account?
                            <a class="signup-link" id="auto" data-toggle="modal" data-target="#exampleModalCenter"> SIGN UP</a>
                            </h2>

                            <div class="con">
                            <?php 
                            
                            if(isset($_SESSION['errors'])) {
                                  foreach ($_SESSION['errors'] as $error) {
                                  echo ' <li class="error-li">
                                  <div class="span-fp-error">'.$error.'</div>
                                  </li>';
                                  
                                  }
                                  unset($_SESSION['errors']);  

                                
                                  
                            } 
                                
                              ?>

                            
                            
                           
                        </form>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="font-weight: 700;" class="modal-title" id="exampleModalLongTitle">Sign Up</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">  
                                    <?php  include 'includes/signup-form.php' ?>
                                </div>
                                
                                </div>
                            </div>
                            </div>
                        
                    </div>
                </div> 
            </div>
            
                <div class="col-md-6">
                    <div class="myRightCtn">
                            <div class="box">
                            <img src="assets/images/logo-large.png" class="img" alt = "bg" width="80%"> 

                            <p>PAWS & CLAWS</p>

                            </div>
                                
                            
                </div>
            </div>
        </div>
</div>
      
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>



