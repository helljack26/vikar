<?

function filter_db_query_from_url($url) {
	$parsed_url = parse_url($url);
	
	$path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
	
	$path_parts = explode(';', $path);
	
	$filters_object = array();
	
	foreach ($path_parts as $part) {
		if (strpos($part, '=') !== false) {
			list($key, $value) = explode('=', $part);
			
			$value = urldecode($value);
			
			$value = explode(',', $value);
	
			$filters_object[$key] = $value;
		}
	}
	
	$filterConditions = array();
	foreach ($filters_object as $name => $values) {
	
		foreach ($values as $value) {
			array_push($filterConditions,"AND JSON_EXTRACT(attributes, '$.*.name')
			LIKE '%$name%' AND JSON_EXTRACT(attributes, '$.*.value') LIKE '%$value%'");
		}
	}
	
	$filter_clause = implode(' ', $filterConditions);
	
	
	$result = [];
	$result['filter_object'] = $filters_object;
	$result['filter_db_query'] = $filter_clause;

	return $result;
}
function html_decoding($rawHtml) {
	return html_entity_decode(htmlspecialchars_decode($rawHtml));
}
function generateProductDetailsUrl($product_name , $product_spec) {
	$transName = transliterate($product_name); 
	
	$isProductSpec = strlen($product_spec) > 0 ?  '/'. transliterate($product_spec) : ''; 
	$url = "product-details/$transName$isProductSpec";
	return $url;

}

function show404() {
    include '404.html';
    exit;
}

function replaceDoubleQuote($string) {
	$string = str_replace('"', "'", $string);
	return $string;
}
function quotesToCode($textWithQuotes){
	$textWithoutDoubleQuotes = str_replace('"', "&quot;", $textWithQuotes);
	$textWithoutSingleQuotes = str_replace("'", "&apos;", $textWithoutDoubleQuotes);
	return $textWithoutSingleQuotes;
}

function codeToQuote($textWithQuotes){
	$textWithDoubleQuotes = str_replace('&quot;', '"', $textWithQuotes);
	$textWithSingleQuotes = str_replace("&apos;", "'", $textWithDoubleQuotes);
	return $textWithSingleQuotes;
}

function getGoogleTitle ($con,$id){
	$get_g_title = mysqli_query($con,"SELECT page_title FROM title_google WHERE id='$id'");
	$row_g_title = mysqli_fetch_array($get_g_title);
	
	 return codeToQuote($row_g_title['page_title']);
}

function CategoryName($con,$page,$params){
	
	$catId = intval($params[0]);
	$scid = intval($params[1]);
	$prod = intval($params[2]);

	if($page == 'category'){
		$sql=mysqli_query($con,"SELECT categoryName  from category where id=$catId");
		$row=mysqli_fetch_array($sql);
		return $row['categoryName'];
	}

	if($page == 'subcategory'){		
		$sql=mysqli_query($con,"SELECT subcategory  from subcategory where subcategory_id='$scid' and categoryid='$catId'");
		$row=mysqli_fetch_array($sql);		
		return $row['subcategory'];
	}
	
	if($page == 'product'){
		$sql=mysqli_query($con,"SELECT productcategoryname  from product_category where product_category_id='$prod' and category_id='$catId' and subcategoryid='$scid'");
		$row=mysqli_fetch_array($sql);		
		return $row['productcategoryname'];
		
	}
}

function getBreadcrumbs($con,$params){
	$catId = intval($params[0]);
	$scid = intval($params[1]);
	$prod = intval($params[2]);
	$specprod = intval($params[3]);

	$breadcrumbsResult = '<li><a href="/">Головна</a></li>';
	// 1
	if($catId > 0){
		$getCat=mysqli_query($con,"SELECT categoryName  
									from category 	
									where id=$catId");
		$row=mysqli_fetch_array($getCat);
		$categoryName = $row['categoryName'];
		$linkCatName = transliterate($row['categoryName']);

		if ($scid == 0 && $prod == 0) {
			$breadcrumbsResult .= "<li>$categoryName</li>";
		} else {
			$breadcrumbsResult .= "<li><a href='category/$linkCatName'>$categoryName</a></li>";
		}
	}
	
	// 2
	if($scid > 0){		
		$sql=mysqli_query($con,"SELECT subcategory  
									from subcategory 	
									where subcategory_id='$scid' 
									and categoryid='$catId'
									");
		$row=mysqli_fetch_array($sql);		
		$subcategoryName = $row['subcategory'];
		$linkSubName = transliterate($row['subcategory']);
	
		if ($prod == 0 && $specprod ==0) {
			$breadcrumbsResult .= "<li>$subcategoryName</li>";
		} else {
			$breadcrumbsResult .= "<li><a href='sub-category/$linkSubName'>$subcategoryName</a></li>";
		}
	}

	// 3
	if($prod > 0){
		$sql=mysqli_query($con,"SELECT productcategoryname 
									from product_category 	
									where product_category_id='$prod' 
									and category_id='$catId' 
									and subcategoryid='$scid'
									");
		$row=mysqli_fetch_array($sql);		
		$productcategoryName = $row['productcategoryname'];
		$linkProdName = transliterate($row['productcategoryname']);
		
		if ($specprod ==0) {
			$breadcrumbsResult .= "<li>$productcategoryName</li>";
		} else {
			$breadcrumbsResult .= "<li><a href='product-category/$linkProdName'>$productcategoryName</a></li>";
		}
	}

	// 4
	if($specprod > 0){
		$sql=mysqli_query($con,"SELECT subspecname 
								from product_subspec 
								where category_id='$catId'
								and subcategoryid='$scid' 
								and product_category_id='$prod'
								and product_subspec_id='$specprod'
                                ");
		$row=mysqli_fetch_array($sql);		
		$subspecname = $row['subspecname'];

		$breadcrumbsResult .= "<li>$subspecname</li>";
	}

	return $breadcrumbsResult;
}

function check_mobile_device() { 
    $mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);    
    // var_dump($agent);exit;
    foreach ($mobile_agent_array as $value) {    
        if (strpos($agent, $value) !== false) return true;   
    }       
    return false; 
}

 function translit_sef($value){
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i', 'i' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
	);

	$value = mb_strtolower($value);
	$value = strtr($value, $converter);
	$value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
	$value = mb_ereg_replace('[-]+', '-', $value);
	$value = trim($value, '-');	

	return $value;
}

function transliterate($string) {
    $translit = "Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();";
    $string = transliterator_transliterate($translit, $string);
	$string = preg_replace('/[-\s]+/', '-', $string);
	$string = preg_replace ('/[^\p{L}\p{N}]/u', '-', $string);
	$string = str_replace("ʹ", "", $string);
	$string = str_replace('"', "", $string);
	$string = str_replace("Ø", "", $string);
	$string = str_replace("ø", "", $string);
	$string = str_replace("№", "", $string);
	$string = str_replace("°", "", $string);
	$string = str_replace("²", "", $string);
	$string = str_replace("¼", "", $string);
    return trim($string, '-');
}


function removeRootDir(){
	$old = $_GET['dir'];
	$getParamTransName = explode('/',$old);
	return $getParamTransName[count($getParamTransName)-1];
}
function removeRootFilter(){
	$url = $_SERVER['REQUEST_URI']; 
	$parts = explode('/', $url); 
	$filter = end($parts); 
	$filter = urldecode($filter);
	$filter_values = explode('&', $filter); 
	return $filter_values;
}

function checkIsHttp(){
	if($_SERVER['SERVER_NAME'] == 'vikar.local' || $_SERVER['SERVER_NAME'] == 'otaman.local'){
    $protocol = 'http://';
	}else{
    $protocol = 'https://';
	} 
	return $protocol;
}

function deTranslit_sef($value){
	$converter = array(
		'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
		'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
		'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
		'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
		'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
		'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
		'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
	);
 
	$value = mb_strtolower($value);
	$value = strtr($value, $converter);
 
	return $value;
}


function info_name($con,$id){
	$inf = mysqli_query($con,"SELECT info_name from info_title where id = $id");
	$row = mysqli_fetch_array($inf);
	
	return $row['info_name'];
}
function footer_name($con,$name){
	$sql = mysqli_query($con,"SELECT $name from footer");
	$row=  mysqli_fetch_array($sql);
	return $row[$name];
}

function download($filename) {
    if (file_exists($filename)) {
      	/* Если файл существует */
		header("Content-Disposition: attachment; filename=" . basename($filename) . ";"); 
	  	// Указываем имя при сохранении в браузере
        echo file_get_contents($filename); 
		// Отдаём файл пользователю на скачивание
    }
    else echo "Not Found"; // Если файла не существует
}

function isExistInBasket ($isExistThisCode, $isCharCode) {
	if (isset($_SESSION['cart'])) {

		$isExistInBasket = false;
		foreach($_SESSION['cart'] as $id => $value):
			if($value['pid'] == $isExistThisCode && $isCharCode == $value['char_hash']){
				$isExistInBasket = true;  
			}
		endforeach; 
		
		if($isExistInBasket == true){
			return 'Оформити';
		} else {
			return 'Купити';
		}
		
	} else {
		echo('Купити');
	}
}

function getAverageRating($con,$c_code){
	$getReviews=mysqli_query($con,"SELECT * from productreviews where productId='$c_code'");
	$num=mysqli_num_rows($getReviews);
	$averageRating = 0;
	while($rowRating = mysqli_fetch_array($getReviews)){
		$averageRating += intval($rowRating['value']);
	};
	if($averageRating > 5){
		$averageRating = round($averageRating / $num);
	}
	$result = [];
    $result['averageRating'] = $averageRating;
    $result['num'] = $num;

	return $result;
}

function getAverageRatingStars($averageRating){
    $result = '';

    for ($i = 1; $i < 6 ; $i++) {
        if ($i <= $averageRating) {
            $result .= '<div class="reviews_item_rate_star reviews_item_rate_star_checked"></div>';
        } else {
            $result .='<div class="reviews_item_rate_star"></div>';
        } 
    }

	echo $result;
}

function cleanName($dirtyName) {
    $cleanTempName = preg_replace('/\((.+?)\)/i', '', $dirtyName);
    $cleanTempName = preg_replace("/[^ a-яа-яё\d,]/ui", '', $cleanTempName);
    return $cleanTempName; 
}
?>