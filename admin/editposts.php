<?php include 'includes/connection.php';?>
<?php include 'includes/adminheader.php';?>
<?php
if (isset($_GET['id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['id']);  
}
else {
	header('location:posts.php');
}
$currentuser = $_SESSION['firstname'];
if ($_SESSION['role'] == 'superadmin') {
$query = "SELECT * FROM posts WHERE id='$id'";
}
else {
    $query = "SELECT * FROM posts WHERE id='$id' AND author = '$currentuser'" ;
}
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0 ) {
while ($row = mysqli_fetch_array($run_query)) {
	$post_title = $row['title'];
	$post_id = $row['id'];
	$post_author = $row['author'];
	$post_date = $row['postdate'];
	$post_image = $row['image'];
	$post_content = $row['content'];
	$post_tags = $row['tag'];
	$post_status = $row['status'];

if (isset($_POST['update'])) {
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
    'title'    => 'required|max_len,120|min_len,15',
    'tags'   => 'required|max_len,100|min_len,3',
    'content' => 'required|max_len,10000|min_len,150',
));
$gump->filter_rules(array(
    'title' => 'trim|sanitize_string',
    'tags' => 'trim|sanitize_string',
    ));
$validated_data = $gump->run($_POST);

if($validated_data === false) {
    ?>
    <center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
    <?php 
}
else {
    $post_title = $validated_data['title'];
      $post_tag = $validated_data['tags'];
      $post_content = $validated_data['content'];
    $post_date = date('Y-m-d');
    if ($_SESSION['role'] == 'user') {
    	$post_status = 'draft';
    } else {
    $post_status = $_POST['status'];
}

    

    $image = $_FILES['image']['name'];
    $ext = $_FILES['image']['type'];
    $validExt = array ("image/gif",  "image/jpeg",  "image/pjpeg", "image/png");
    if (empty($image)) {
    	$picture = $post_image;
    }
    else if ($_FILES['image']['size'] <= 0 || $_FILES['image']['size'] > 1024000 )
    {
echo "<script>alert('Image size is not proper');
window.location.href = 'editposts.php?id=$id';</script>";
    
    }
    else if (!in_array($ext, $validExt)){
        echo "<script>alert('Not a valid image');
        window.location.href = 'editposts.php?id=$id';</script>";
    exit();
    }
    else {
        $folder  = '../allpostpics/';
        $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION) );
        $picture = rand(1000 , 1000000) .'.'.$imgext;
        move_uploaded_file($_FILES['image']['tmp_name'], $folder.$picture);
    }
  
        $queryupdate = "UPDATE posts SET title = '$post_title' , tag = '$post_tag' , content='$post_content' , 	status = '$post_status' , image = '$picture' , postdate = '$post_date' WHERE id= '$post_id' " ;
        $result = mysqli_query($conn , $queryupdate) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
        	echo "<script>alert('POST SUCCESSFULLY UPDATED');
        	window.location.href= 'posts.php';</script>";
        }
        else {
        	echo "<script>alert('Error! ..try again');</script>";
}
}
}
}
}
?>

<div id="wrapper">

       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            UPDATE NEWS 
                        </h1>
                        <form role="form" action="" method="POST" enctype="multipart/form-data">


	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input type="text" name="title" class="form-control" value="<?php echo $post_title;  ?>">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" name="tags" class="form-control" value="<?php echo  $post_tags; ?>">
	</div>

	<div class="input-group">
		<label for="post_status">Post Status</label>
			<select name="status" class="form-control">
			<?php if($_SESSION['role'] == 'user') { echo "<option value='draft' >draft</option>"; } else { ?> 
        <option value="<?php  echo $post_status; ?>"><?php  echo  $post_status;  ?></option>>
			<?php
if ($post_status == 'published') {
	echo "<option value='draft'>Draft</option>";
} else {
	echo "<option value='published'>Publish</option>";
}
?>
<?php
}
?>


</select>
	</div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
		<img class="img-responsive" width="200" src="../allpostpics/<?php echo $post_image; ?>" alt="Photo">
		<input type="file" name="image"> 
    </div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea  class="form-control" name="content" id="" cols="30" rows="10"><?php  echo $post_content;  ?>
		</textarea>
	</div>

	<button type="submit" name="update" class="btn btn-primary" value="Update Post">Update Post</button>
</form>
</div>
</div>
</div>
</div>
</div>

<script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

