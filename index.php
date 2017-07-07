<?php include 'includes/connection.php';
?>
<?php include 'includes/header.php';?>
        
   <?php include 'includes/navbar.php';?>
        

    <div class="container">
        <div class="row">
	        
	        <div class="col-md-8">

<?php
$query = "SELECT * FROM posts WHERE status='published' ORDER BY updated_on DESC";
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0) {
while ($row = mysqli_fetch_assoc($run_query)) {
  $post_title = $row['title'];
  $post_id = $row['id'];
  $post_author = $row['author'];
  $post_date = $row['postdate'];
  $post_image = $row['image'];
  $post_content = $row['content'];
  $post_tags = $row['tag'];
  $post_status = $row['status'];
  if ($post_status !== 'published') {
    echo "NO POST PLS";
  } else {

    ?>
<p><h2><a href="publicposts.php?post=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2></p>
            <p><h3>by <a href="#"><?php echo $post_author; ?></a></h3></p>
            <p><span class="glyphicon glyphicon-time"></span>Posted on <?php echo $post_date; ?></p>
            <hr><a href="publicposts.php?post=<?php echo $post_id; ?>">
            <img class="img-responsive img-rounded" src="allpostpics/<?php echo $post_image; ?>" alt="900 * 300"></a>
            <hr>
            <p><?php echo substr($post_content, 0, 300) . '.........'; ?></p>
            <a href="publicposts.php?post=<?php echo $post_id; ?>"><button type="button" class="btn btn-primary">Read More<span class="glyphicon glyphicon-chevron-right"></span></button></a>
            <hr>
            
            <?php }}}?>

            <hr>
            <ul class="pager">
          <li class="previous"><a href="#"><span class="glyphicon glyphicon-arrow-left"></span> Older</a></li>
          <li class="next"><a href="#">Newer <span class="glyphicon glyphicon-arrow-right"></span></a></li>
        </ul>
          </div>
	        
	        <div class="col-md-4">

               <?php include 'includes/sidebar.php';
?>

	        </div>
	        
        </div>

        
        <?php include 'includes/footer.php';?>
        
    </div>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>