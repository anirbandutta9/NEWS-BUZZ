<?php include 'includes/adminheader.php';
?>

    <div id="wrapper">
       
       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">

            <div class="container-fluid">

                
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to NEWS-BUZZ  
                            <small><?php echo $_SESSION['firstname']; ?></small>
                        </h1>

                    </div>
                </div>
                
<div class="row">
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9">
                                    <?php
$query = "SELECT * FROM posts";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$post_num = mysqli_num_rows($result);
echo "<div class='text-right huge'>{$post_num}</div>";
?>

                                        <div class="text-right">Posts</div>

                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View All Posts</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9">
                                                                   <?php
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$user_num = mysqli_num_rows($result);
echo "<div class='text-right huge'>{$user_num}</div>";
?>


                                        <div class="text-right">Users</div>

                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View All Users</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                   
            </div>
            
        </div>
        
   <?php 'includes/adminfooter.php';?>
    </div>
    <script src="js/jquery.js"></script>

  
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
