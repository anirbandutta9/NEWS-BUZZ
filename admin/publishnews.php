<?php include 'includes/adminheader.php';

?>
    <div id="wrapper">

       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            PUBLISH NEWS 
                        </h1>
<?php
if (isset($_POST['publish'])) {
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
    'title'    => 'required|max_len,120|min_len,15',
    'tags'   => 'required|max_len,100|min_len,3',
    'content' => 'required|max_len,20000|min_len,150',
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
    $post_title = $_POST['title'];
      $post_tag = $_POST['tags'];
      $post_content = $_POST['content'];
}
else {
    $post_title = $validated_data['title'];
      $post_tag = $validated_data['tags'];
      $post_content = $validated_data['content'];
if (isset($_SESSION['firstname'])) {
        $post_author = $_SESSION['firstname'];
    }
    $post_date = date('Y-m-d');
    $post_status = 'draft';
    

    $image = $_FILES['image']['name'];
    $ext = $_FILES['image']['type'];
    $validExt = array ("image/gif",  "image/jpeg",  "image/pjpeg", "image/png");
    if (empty($image)) {
echo "<script>alert('Attach an image');</script>";
    }
    else if ($_FILES['image']['size'] <= 0 || $_FILES['image']['size'] > 1024000 )
    {
echo "<script>alert('Image size is not proper');</script>";
    }
    else if (!in_array($ext, $validExt)){
        echo "<script>alert('Not a valid image');</script>";

    }
    else {
        $folder  = '../allpostpics/';
        $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION) );
        $picture = rand(1000 , 1000000) .'.'.$imgext;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $folder.$picture)) {
            $query = "INSERT INTO posts (title,author,postdate,image,content,status,tag) VALUES ('$post_title' , '$post_author' , '$post_date' , '$picture' , '$post_content' , '$post_status', '$post_tag') ";
            $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
            if (mysqli_affected_rows($conn) > 0) {
                echo "<script> alert('News posted successfully.It will be published after admin approves it');
                window.location.href='posts.php';</script>";
            }
            else {
                "<script> alert('Error while posting..try again');</script>";
            }
        }
    }
}
}
?>

<form role="form" action="" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" name="title" placeholder = "ENTER TITLE " value= "<?php if(isset($_POST['publish'])) { echo $post_title; } ?>"  class="form-control" required>
    </div>

    
    <div class="form-group">
        <label for="post_image">Post Image </label> <font color='brown' > &nbsp;&nbsp;(Allowed image size: 1024 KB) </font> 
        <input type="file" name="image" >
    </div>
    <div class="form-group">
        <label for="post_tag">Post Tags</label>
        <input type="text" name="tags" placeholder = "ENTER SOME TAGS SEPERATED BY COMMA (,)" value= "<?php if(isset($_POST['publish'])) { echo $post_tag; } ?>" class="form-control" >
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="content"  id="" cols="30" rows="15" ><?php if(isset($_POST['publish'])) { echo $post_content; } ?></textarea>
    </div>
<button type="submit" name="publish" class="btn btn-primary" value="Publish Post">Publish Post</button>

</form>

 </div>
                </div>
                
            </div>

        </div>
        
   <?php 'includes/admin_footer.php';?> -->
    </div>
    
    <script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
