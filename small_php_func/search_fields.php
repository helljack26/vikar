<?php
session_start();
error_reporting(0);
include('../includes/config.php');
include('../function.php');

// Main header search field
if($_POST['search']=="1"):
    $q = htmlspecialchars($_POST["q"]);
    if(!empty($q)):
    $sql = mysqli_query($con,"SELECT c_code, product_name,characteristic_uuid,product_spec 
                                from products 
                                where organization='Вікар' 
                                and product_name LIKE '%$q%' 
                                LIMIT 5
                                ");

    while($row = mysqli_fetch_array($sql)):
        $productLink = generateProductDetailsUrl($row['product_name'], $row['product_spec']);
    
    ?>
        <p>
            <a href="<?=$productLink?>">
                <?=$row['product_name']?>
            </a>
        </p>
<?endwhile; endif; exit; endif;?>

<!-- Blog search field -->
<?if($_POST['search']=="2"):
$q = htmlspecialchars($_POST["q"]);

?>
<?if(!empty($q)):?>
<?$sql = mysqli_query($con,"SELECT * from blog WHERE title LIKE '%$q%'");
    if(mysqli_num_rows($sql) > 0):
    while($row = mysqli_fetch_array($sql)):
    ?>
        <div class="panel panel-default checkout-step-02">
            <div id="collapseTwo">
                <div class="panel-body">
                    <h2 style="font-size:20px;text-align:center;padding: 5px;">
                        <?=$row['title']?>
                    </h2>
                    <p style="color:#787373;font-style:italic;color:#4D4D4D;">
                        <span style="border-bottom:1px solid #DDDDDD;">
                        Дата: <?=$row['date']?>
                        </span>
                    </p>
                    <div style="word-wrap: break-word;padding:10px;">
                        <?=$row['text']?>
                    </div>
                    <?if($row['image']){?>
                    <p align="center">
                        <img src="admin/productimages/<?echo$row['image'];?>" width="400">
                    </p>
                    <?}?>
                </div>
            </div>
        </div>
<?endwhile;
else:?>
    <p style="padding:5px;">Нічого не знайдено...</p>
<?endif; endif; exit; endif;?>