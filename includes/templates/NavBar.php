<nav class="navbar navbar-expand-lg fixed-top  ">

  <a class="navbar-brand" href="index.php" style="color:#FFF">
    <span style="color:#9fb0a9">O</span>nline<span style="color:#9fb0a9">S</span>hopping
  </a>

  <!-- for mobile view -->
  <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="index.php">HomePage </a>
      </li>

      <li class="nav-item dropdown categories-menu">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php
            $categories = getrecords("*","categories",'',"Ordering","DESC");
            foreach($categories as $category){
              echo '<a class="dropdown-item" href="items.php?category_id=' . $category["ID"] . '">' . $category['Name'] . '</a>';
            }
          ?>
        </div>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto right-items-nav">
      <?php 

        if(isset($_SESSION['front_username'])){
          $id_user = $_SESSION['front_userid'];
          $user = get_record("*","users","userID=$id_user");
          $fullname_user = explode(" ",$user['FullName']);
          
          echo '<li class="nav-item">';
            echo '<a href="logout.php" class="fa fa-shopping-cart" style="color:white;cursor:pointer;font-size: 30px;margin-top: 10px;margin-right: -20px;"></a>';
          echo '</li>';
          echo '<li class="user-img-nav nav-item dropdown profile-image-menu dropleft">';
            echo '<img src="Uploads/profile_image/' . $user['img'] . '" class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="top: 53px;right: 12px;">';
              echo '<div class="text-center"><i class="fa fa-user" style="color:violet"></i> ' . $fullname_user[0] . '</div>';
              echo '<div class="dropdown-divider"></div>';
              echo '<a class="dropdown-item" href="profile.php">Profile</a>';
              echo '<a class="dropdown-item" href="#">Orders</a>';
              echo '<a class="dropdown-item" href="logout.php">Sign Out</a>';
            echo '</div>';      
          echo '</li>';
        }else{  
          echo '<li class="nav-item">';
            echo '<a class="nav-link navbar-login" style="display: inline;" href="#" data-toggle="modal" data-target=".bd-example-modal-lg">Login</a>';
             echo '|'; 
            echo '<a class="nav-link navbar-register" style="display: inline;" href="#" data-toggle="modal" data-target=".bd-example-modal-lg">Register</a>';
          echo '</li>';
        }  
     ?>
    </ul>
    
  </div>
</nav>

<?php
 if($_SERVER['REQUEST_METHOD'] == 'POST'){


    /* Start login request*/

    if(isset($_POST['login-submit'])){
      $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
      $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
      $hashedpass = sha1($password);

      // Check The USer In Database
      $stmt = $con->prepare("SELECT
                    *
                   FROM 
                      users 
                   Where 
                      UserName = ? 
                   AND  
                      Password = ? ");

      $stmt->execute(array($username,$hashedpass));
      $count = $stmt->rowCount();
      $row = $stmt->fetch();

      //if $count >0 This Mean the DataBase Contain Record about this username 
        if($count > 0){
          $_SESSION['front_username'] = $username;
          $_SESSION['front_userid'] = $row['userID'];
          header("Location:index.php");
          exit();
        }else{
          echo "<div class='container text-center error-window'>";
            echo "<p class='close-error-window'>X</p>";
            echo '<div class="alert alert-danger">Wrong UserName or Password</div>';
          echo "</div>";  
        }


      
    }

    /* End login request*/  

/* ----------------------------------------------------------------*/
/* ----------------------------------------------------------------*/

    /* Start register request*/

    elseif(isset($_POST['register-submit'])){

      $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
      $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
      $email    = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
      $fullname = filter_var($_POST['fullname'],FILTER_SANITIZE_STRING);
      $gender   = $_POST['gender'];
      $age    = filter_var($_POST['age'],FILTER_SANITIZE_NUMBER_INT);
      $hashpass = sha1($password);

      /* ---------- Start Handling Fields validation ------------- */

        $ErrorsArray = array();

        if(strlen($username) < 3 || strlen($username) > 14){
          $ErrorsArray[] = 'UserName Must between 3~14 Charachters';
        }
        if(!is_numeric($age)){
          $ErrorsArray[] = 'Age must be a Number';
        }

        if(empty($username)){ $ErrorsArray[] = "UserName Can't be Empty"; }
        if(empty($password)){ $ErrorsArray[] = "Password Can't be Empty"; }
        if(empty($age)){ $ErrorsArray[] = "Age Can't be Empty"; }
        if(empty($email)){ $ErrorsArray[] = "E-Mail Can't be Empty"; }
        if(empty($fullname)){ $ErrorsArray[] = "FullName Can't be Empty"; }

        //loop to echo the errors 
        echo "<div class='container text-center error-window'>";
        echo "<p class='close-error-window'>X</p>";
        foreach ($ErrorsArray as $error) {
          echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        echo "</div>";

      /* ---------- End Handling Fields validation ------------- */

      if(empty($ErrorsArray)){

        $check = Checkitem('UserName','users',$username);

        if($check == 1 ){
          echo "<div class='container text-center error-window'>";
            echo "<p class='close-error-window'>X</p>";
            echo '<div class="alert alert-danger">Sorry The UserName already exists .. try another one</div>';
          echo "</div>";  
        }else{

          $stmt = $con ->prepare("INSERT INTO 
                        users(UserName,Password,FullName,Email,Age,Gender,Date)
                      VALUES 
                        (?,?,?,?,?,?,now())
                       ");

          $stmt -> execute(
            array(
              $username,$hashpass,$fullname,$email,$age,$gender
            )
          );

          echo "<div class='container text-center error-window'>";
            echo "<p class='close-error-window'>X</p>";
            echo '<div class="alert alert-success">Registered Successfully...</div>';
          echo "</div>";
          header("refresh:3");
        }
      }


    }
    /* End register request*/
   }
?>
  <!-- ^^^^^^^^^^^^^^^^^^^ Start Modal ^^^^^^^^^^^^^^^^^^^^^^ -->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <!-- Modal Content -->
        <div class="container">
        
          <div class="row text-center modal-buttons-switcher">
            <span class="col btn btn-login-switcher">Login</span> 
            <span class="col btn btn-register-switcher">Register</span>
          </div>

          <!-- Start login modal -->
          <form class="login-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

            <div class="fields-form">

              <!-- UserName -->
                <div class="input-group input-group-lg flex-nowrap form-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-lg">
                  <i class="fas fa-user"></i>
                </span>
              </div>
              <input type="text" name="username" class="username-input form-control" placeholder="Username" aria-label="Username" aria-describedby="inputGroup-sizing-lg" required="required">
            </div>

            <!-- Password -->
            <div class="input-group input-group-lg flex-nowrap form-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-lg">
                  <i class="fas fa-unlock-alt"></i>
                </span>
              </div>
              <input type="Password" name="password" class="password-input form-control" placeholder="Password" aria-label="Password" aria-describedby="inputGroup-sizing-lg
              " required="required">
            </div>

          </div>

          <input name="login-submit" class="btn login-submit  btn-block" type="submit" value="Login">

        </form> 
        <!-- End login modal -->


        <!-- Start forget-password modal -->
          <form class="forget-password-form">

            <div class="fields-form row">

              <!-- UserName -->
              <div class="input-group mb-3 col">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                  <i class="fas fa-user"></i>
                </span>
              </div>
              <input name="username" type="text" class="form-control" placeholder="Username" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required="required">
            </div>

              <!-- E-Mail -->
            <div class="input-group mb-3 col">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                  <i class="far fa-envelope"></i>
                </span>
              </div>
              <input name="email" type="email" class="form-control" placeholder="E-Mail" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required="required"> 
            </div>

          </div>

          <input name="forget-password-submit" class="btn forget-password-submit  btn-block" type="submit" value="Reset">
          <p style="font-size: 12px" class="text-center">By Clicking <strong>Rest</strong> we will send you <strong>activation code</strong>.</p>
        </form> 
        <!-- End forget-password modal -->  


        <!-- Start register modal -->
          <form class="register-form" method="POST">

            <div class="fields-form">

              <!-- FullName -->
            <div class="input-group mb-3 ">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                  <i class="fas fa-heading"></i>
                </span>
              </div>
              <input name="fullname" type="text" class="form-control" placeholder="FullName..." aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required="required">
            </div>

            <!--  Gender && Age -->
            <div class="row">

              <!-- Gender -->
              <div class="input-group mb-3 col">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-default">Gender</span>
                </div>
                <select name="gender" class="custom-select" id="inputGroupSelect01" >
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <!-- Age -->
              <div class="input-group mb-3 col">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroup-sizing-default">
                    <i class="fab fa-pagelines"></i>
                  </span>
                </div>
                <input name="age" type="text" class="form-control" placeholder="Age" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"required="required">
              </div>

            </div>


              <!-- UserName -->
              <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                  <i class="fas fa-user"></i>
                </span>
              </div>
              <input name="username" type="text" class="form-control" placeholder="Username" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required="required">
            </div>

            <!-- Password -->
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                  <i class="fas fa-unlock-alt"></i>
                </span>
              </div>
              <input name="password" type="Password" class="form-control" placeholder="Password"aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required="required">
            </div>

            
            <!-- E-Mail -->
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">
                  <i class="far fa-envelope"></i>
                </span>
              </div>
              <input name="email" type="email" class="form-control" placeholder="E-Mail" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required="required"> 
            </div>

            

          </div>

          <!-- terms and condition text -->
          <div class="container text-center terms-condation-text">
            <p style="font-size: 13px">By clicking Register, you agree to our 
              <a href="#" style="color: blue;"> Terms and Conditions</a>
              <!-- link to page contain terms and condations of the website -->
            </p>
          </div>

          <input name="register-submit" class="btn register-submit  btn-block" type="submit" value="Register">

        </form> 
        <!-- End register modal -->

      </div>

      </div>
            
    </div>
        <div class="container text-center forgetpass-text">
        <p style="color: wheat;text-decoration:underline;cursor: pointer;">Forgot your password? / Resend Activation
        </p>
      </div>
  </div>
  <!-- ^^^^^^^^^^^^^^^^^^^ End Modal ^^^^^^^^^^^^^^^^^^^^^^ -->