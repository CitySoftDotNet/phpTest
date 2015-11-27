<?php

$reviewsPerPage = 10;
$offset = 50;
if(isset($_REQUEST["offset"]) && $_REQUEST["offset"] != "")
{
	$offset = (int)$_REQUEST["offset"];
}

$apiFeed = file_get_contents("http://test.localfeedbackloop.com/api?apiKey=61067f81f8cf7e4a1f673cd230216112&noOfReviews=".$reviewsPerPage."&internal=1&yelp=1&google=1&offset=".$offset."&threshold=1");

$data = json_decode($apiFeed);
$businessInformation = $data->business_info;
$customerReviews = $data->reviews;

$basePageUrl = $_SERVER['PHP_SELF'];

$nextPage = $offset + $reviewsPerPage;

$prevPage = $offset - $reviewsPerPage;

$totalNumberOfReviews = $businessInformation->total_rating->total_no_of_reviews;

$lastRecordCount = $offset + $reviewsPerPage;

if ($lastRecordCount > $totalNumberOfReviews)
{
	$lastRecordCount = $totalNumberOfReviews;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PHP solution</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
</head>

<body>

<div class="container">
  <div class="jumbotron">
    <h2><?php echo $businessInformation->business_name ?></h2>
    <p><?php echo $businessInformation->business_address ?></p> 
    <p>Phone: <?php echo $businessInformation->business_phone ?></p> 
    <p>Average Rating: <?php echo $businessInformation->total_rating->total_avg_rating ?> | 
       <a href="<?php echo $businessInformation->external_url ?>" target="_blank">review my business</a></p>
    <p><a href="<?php echo $businessInformation->external_page_url ?>" target="_blank">business website</a></p> 
  </div>
  <div class="row greyBackground"> 
	<div class="col-md-8">     
		<div class="col-md-2">
<?php
if ($prevPage >= 0)
{
?>        
        	<a href="<?php echo $basePageUrl."?offset=".$prevPage ?>" class="size20">&laquo;</a> 
<?php
}
?>            
        </div>
		<div class="col-md-4 size20">
        	<?php echo ($offset + 1) ?> - <?php echo $lastRecordCount ?> out of <?php echo $totalNumberOfReviews ?> 
        </div>
		<div class="col-md-2">
<?php
if ($totalNumberOfReviews > $nextPage)
{
?>        
        	<a href="<?php echo $basePageUrl."?offset=".$nextPage ?>" class="size20">&raquo;</a> 
<?php
}
?>            
        </div>
    </div>
  </div>
<?php


foreach ($customerReviews as $review)
{
	//echo $review->review_from;
	//echo $review->review_id;
?>

<div class="row"> 
	<div class="col-md-8">     
		<div class="col-md-2">
<?php
	for ($i = 0; $i < $review->rating; $i++)
	{
?>        
        ★
<?php
	}
?>        
        </div>    
		<div class="col-md-2"><a href="<?php echo $review->review_url ?>" target="_blank"><?php echo $review->review_source ?></a></div>
		<div class="col-md-3"><?php echo $review->date_of_submission ?></div>
    </div> 
    <div class="col-md-8"><h4><?php echo $review->customer_name ?> <?php echo $review->customer_last_name ?></h4></div> 
    <div class="col-md-8"><?php echo $review->description ?></div> 
    <div class="col-md-8"><a href="<?php echo $review->customer_url ?>" target="_blank">customer website</a></div> 
</div>
    <hr />

<?php
}
?>
</div>


</body>
</html>
