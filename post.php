<?php 
include('includes/config.php');
include('function.php');

if (isset($_GET['name'])) {
  $article_name = $_GET['name'];

  $sql2 = mysqli_query($con,"SELECT * from blog WHERE title_en='$article_name' ORDER BY date DESC");   
  $row2 = mysqli_fetch_array($sql2);
  $title = $row2['title'];
  $text= $row2['text'];
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
    <meta property="og:title" content="<?=$row23['soc_info_title']?>" />

    <meta property="og:description" content="<? echo($soc_description);?>" />
    <meta name="description" content="<? echo($soc_description);?>">

    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title><?=getGoogleTitle($con,14)?></title>

    <?php include('includes/links.php');?>
    <link rel="stylesheet" href="assets/css/blog.css">

    <style>
        .btn {
            background: #a8a8a8 none repeat scroll 0 0;
            border: medium none;
            color: #fff;
            font-size: 13px;
            line-height: 22px;
            transition: all 0.2s linear 0s;
        }

        .search_blog {
            border: 1px solid #E2E2E2;
            padding: 5px;
            border-radius: 5px;
            background: url(img/search_icon.png) no-repeat center right;
        }

        #search-result_blog {
            display: none;
        }
    </style>

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
                <a href="/page/blog">Блог</a>
            </li>
            <li>
                <?=$title?>
            </li>
        </ul>
        <!-- News results -->
        <div class="news_row">
            <!-- News title -->
            <h1>
                <?=$row23['title']?>
            </h1>

            <!-- News results -->
            <div class="news_row_results_item">

                <div class="news_row_results_item_content">
                    <div class="news_row_results_item_content_block">
                        <h1><?=$row2['title']?></h1>
                        <?if($row2['image']){?>
                        <div class="news_row_results_item_img">
                            <img src=" ./information/img/<?echo $row2['image'];?>" alt="<?=$row2['title']?>">
                        </div>
                        <?}?>

                        <span id="news_row_results_item_content_block_text">

                            <?
                                    $text= html_decoding($text);
                                    $text= trim($text);
                                    echo $text;
                                ?>
                        </span>
                    </div>

                    <div class="news_row_results_item_content_footer">
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
            </div>
        </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include('includes/footer.php');?>
    <script>
        $(document).ready(function () {
            $('.search_blog').on('keyup input', function () {
                var search = $(this).val();

                if (search.length === 0) {
                    $("#search-result_blog").html("").hide();
                    $("#blog_cont").show();
                    return
                }
                $.ajax({
                    type: "POST",
                    url: "../small_php_func/search_fields.php",
                    data: {
                        'q': search,
                        'search': '2'
                    },
                    success: function (data) {
                        if (data.length > 10) {
                            $("#search-result_blog").html(data).show();
                            $("#blog_cont").hide();
                        } else {
                            $("#search-result_blog").html("").hide();
                            $("#blog_cont").show();
                        }
                        return false;
                    }
                });
            });
        });
    </script>

</body>

</html>