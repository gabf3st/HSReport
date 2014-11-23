<?php
    $text = "";

    if (isset($_POST['submit'])) {

        if( empty($_POST['username']) || empty($_POST['password']) ){
            if (empty($_POST['username']) && (empty($_POST['password'])) ) {
                $text = "Please input username and password.";
            } else if (empty($_POST['username'])) {
                $text = "Please input username.";
            } else if (empty($_POST['password'])){
                $text = "Please input password.";
            }
            
        } else {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            
            if (isCorrect($user,$pass)){
                //redirect
                Redirect('register.php', false);
            } else {
                $text= "Username or Password is incorrect."; 
            }
        }
        
        if($text != ""){
            echo "<p class='bg-danger text-center'>". $text ."</p>";
        }
    }

    function isCorrect($user,$pass){
        $USERNAME = "homeservice";
        $PASSWORD = "homeservice";
        
        if($user == $USERNAME && $pass == $PASSWORD){
            return true;
        } else{  
            return false;
        }
    }

    function Redirect($url, $permanent = false)
    {
        if (headers_sent() === false)
        {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }

        exit();
    }

    include "header.php"; 

?>
<!-- jQuery Version 1.11.0 -->

<script src="js/jquery-1.11.0.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<style>
    body {
        background-color:#2b333e; 
        color:#ffffff
    }

    #logo{
        padding-top:100px;
        padding-bottom:10px;
    }
    
    .bg-danger {
        background-color: #FF6D70;
        color: #ffffff;
        padding: 10px;
    }
    
    .form-group {
        padding:15px;
    }
    
</style>

<div class="col-sm-offset-4 col-xs-4">
    <div class="row text-center">
            <div class="sidebar-brand-logo row text-center">
                    <img id="logo" src="images/logo_sansiri.png" width="60px" height="60px">
            </div>
            <div class="logo-desc" class="sidebar-brand-text row text-center">
                HOME SERVICE
            </div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="row" style="padding-top:30px">
            <form class="form-horizontal" role="form">
              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Username</label>
                <div class="col-sm-9">
                    <?php if(!empty($_POST['username'])){ ?>
                        <input class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $_POST['username']; ?>">
                    <?php
                        } else {
                    ?>
                  <input class="form-control" name="username" id="username" placeholder="Username">
                    <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" name="submit" class="btn btn-default">Log In</button>
                </div>
              </div>
            </form>
        </form>
    </div>
</div>


</body>

</html>
