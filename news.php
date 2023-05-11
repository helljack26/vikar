<?php 
include('includes/config.php');
include('function.php');

if (isset($_GET['name'])) {
  $article_name = $_GET['name'];

  $sql2 = mysqli_query($con,"SELECT * from news WHERE title_en='$article_name' ORDER BY date DESC");   
  $row2 = mysqli_fetch_array($sql2);
  $title = $row2['title'];
  if (!$row2) {
     http_response_code(404);
    include('404.html');
    exit();
  }
} 

?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <base href="<?php echo checkIsHttp() .  $_SERVER['SERVER_NAME']; ?>" />
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta property="og:image" content="assets/no_foto.png" />
    <meta property="og:title" content="<?=$row23['title']?>" />

    <meta property="og:description" content="<? echo($soc_description);?>" />
    <meta name="description" content="<? echo($soc_description);?>">

    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title><?=getGoogleTitle($con,12)?></title>

    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/info_news.css">
</head>

<body>
    <!-- Header -->
    <?php include('includes/main-header.php');?>
    <main>
        <!-- Breadcrumbs -->
        <ul class="news_breadcrumb">
            <li>
                <a href="/">
                    Головна
                </a>
            </li>
            <li>
                <a href="/page/news">Новини</a>
            </li>
            <li>
                <?=$title?>
            </li>
        </ul>
        <!-- News results -->
        <div class="news_row_results wow fadeInUp">
            <? $sql2 = mysqli_query($con,"SELECT * from news  WHERE title_en='$article_name' ORDER BY date DESC");    
					while($row2 = mysqli_fetch_array($sql2)): 
                        $text = $row2['text'];
                        $title = transliterate($row2['title']);
                        $text = str_replace("\t", "", $text); // Remove tabs
                        $text = str_replace("\n", "", $text); // Remove newlines
                   
                ?>
            <div class="news_row">
                <!-- News title -->
                <h1>
                    <?=$row2['title']?>
                </h1>

                <div class="news_row_results_item">
                    <hr class="new1">
                    <?if($row2['image']){?>
                    <div class="news_row_results_item_img">
                        <img src="./information/img/news/<?echo $row2['image'];?>" alt="<?=$row2['title']?>">
                    </div>
                    <?}?>
                    <div class="news_row_results_item_content">
                        <div class="news_row_results_item_content_block">
                            <span>
                                <?=$text?>
                            </span>
                        </div>

                        <!-- News date -->
                        <span class="news_row_results_item_content_date">
                            <?
                                $rawDate = explode(' ', $row2['date']);
                                $explodeDate = explode('-', $rawDate[0]);
                                $reverseDate = array_reverse($explodeDate);
                                $correctData = implode('.',$reverseDate);
                                echo($correctData);
                            ?>
                        </span>
                    </div>
                </div>
                <? endwhile; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include('includes/footer.php');?>
</body>

</html>
<style>
.read-more-btn {
    display: inline-block;
    background-color: #5c6735;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    margin-right: 10px;
    transition: background-color 0.2s ease;
}

.read-more-btn:hover {
    background-color: #ffcd00;
}

img {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 25%;
}

@media screen and (max-width: 450px) {
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
    }
}

hr.new1 {
    border-top: 1px solid gray;
}

.news_row_results_item_img {
    margin-bottom: 20px;
}
</style>