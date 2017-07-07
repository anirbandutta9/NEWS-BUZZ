<?php include 'includes/header.php';?>
    <!-- Navigation -->
<?php include 'includes/navbar.php';?>
<?php echo "<script>alert('Make sure you are connected to the internet');</script>"; ?>

<div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

<h1 class="page-header">Trending news around the world</h1>
<?php 
$your_api_key = 'bc86300b61b4414cba38fe44064963c8';
$news_url = file_get_contents('https://newsapi.org/v1/articles?source=the-next-web&sortBy=latest&apiKey='.$your_api_key.'');
$news_url_decode = json_decode($news_url, true);
//print_r($news_url_decode);
$total_results = sizeof($news_url_decode['articles']);
for($n=0; $n < $total_results; $n++)
{
$article_title = $news_url_decode['articles'][$n]['title'];
$author = $news_url_decode['articles'][$n]['author'];
$description = $news_url_decode['articles'][$n]['description'];
$url = $news_url_decode['articles'][$n]['url'];
$image = $news_url_decode['articles'][$n]['urlToImage'];
?>

<p><h2><a href="<?php echo $url; ?>"><?php echo $article_title; ?></a></h2></p>
<p><h3>by <a href="#"><?php echo $author; ?></a></h3></p>
<hr>
<img class="img-responsive img-rounded" src="<?php echo $image;  ?>" alt="900 * 300">
<hr>
<p><?php echo $description; ?></p>
<?php } ?>

 </div>
 <div class="col-md-4">

               <?php include 'includes/sidebar.php';
?>
</div>
</div>
</div>

    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>