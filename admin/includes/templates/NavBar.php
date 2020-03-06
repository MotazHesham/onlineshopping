
<div class="Side_Navbar">
      <div class="img-sidebar" style="background-image: url(../Uploads/profile_image/beach.jpg); background-size: cover">
         <div class="text-center">
           <a class="navbar-brand" href="index.php" style="color:#FFF">
            <span style="color:#9fb0a9">O</span>nline<span style="color:#9fb0a9">S</span>hopping
           </a>   
        </div>               
      </div>
     
      <div class="sidebar-links">
        <a class="nav-link" href="index.php">
          <span class="fa fa-home mr-3"></span>Home
        </a>
        <a class="nav-link" href="Categories.php">
          <span class="fa fa-gift mr-3"></span>Categories
        </a>
        <a class="nav-link" href="Users.php">
          <span class="fa fa-users mr-3"></span>Members
        </a>
        <a class="nav-link" href="items.php">
          <span class="fa fa-tag mr-3"></span>Items
        </a>
        <a class="nav-link" href="comments.php">
          <span class="fa fa-comments mr-3"></span>Comments
        </a>
        <a class="nav-link" href="../index.php" target="_blanc">
          <span class="fa fa-hashtag mr-3"></span>Visit Shop
        </a>
        <div style="color: #95d0e2;margin-top: 20px;margin-bottom: 5px;font-size: x-large;font-family: 'Lobster', cursive;text-align: center;">
           Your Info
        </div>
        <a class="nav-link" href="#">
          <span class="fa fa-user mr-3"></span><?php echo $_SESSION['fullname'];?>
        </a>
        <a class="nav-link" href="Users.php?do=Edit&userid=<?php echo $_SESSION['UserID']?>">
          <span class="fa fa-cog mr-3"></span>EditProfile
        </a>
        
        <a class="nav-link" href="logout.php">
            <span class="fa fa-sign-out-alt mr-3"></span>Logout
        </a>
     </div>
</div>  