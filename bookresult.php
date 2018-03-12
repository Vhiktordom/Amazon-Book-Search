<?php
session_start();
require_once 'vendor/autoload.php';

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;

$conf = new GenericConfiguration();
$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

try {
    $conf
        ->setCountry('com')
        ->setAccessKey('AKIAJNWH7PVBOKIY2UTA')
        ->setSecretKey('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')
        ->setAssociateTag('vhiktordom-20')
        ->setRequest($request)
        ->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToArray());
 }
catch (Exception $e) {
    echo $e->getMessage();
}



if(isset($_POST['name']))
{
		$name = $_POST['name'];
		$_SESSION['name'] = " '"  . $name . "' ";
		
}



$id = $_GET['id'];
if(!isset($id)){
	header("Location: index.php?id=1"); /* Redirect browser */
	exit();
}
$nextId = ++$id;


$apaiIO = new ApaiIO($conf);
$search = new Search();
$search->setCategory('Books');
// $search->setActor('Bruce Willis');
// $search->setKeywords($realName);
$search->setTitle($_SESSION['name']);
$search->setPage($id);
$search->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($search);

   // dd($formattedResponse['Items']['Item']);

?>

<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js" lang=""> <!--<![endif]-->

<!-- Victor Dominic Wrok -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Books Library</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/transitions.css">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/color.css">
	<link rel="stylesheet" href="css/responsive.css">
	<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body class="tg-home tg-homeone">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<!--************************************
			Wrapper Start
	*************************************-->
	<div id="tg-wrapper" class="tg-wrapper tg-haslayout">
		<main id="tg-main" class="tg-main tg-haslayout">
			<section class="tg-sectionspace tg-haslayout">

				<div class="container">
					<div class="row">

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="tg-sectionhead">
								<?php 
									if($id == 10)
									{
										echo "<a class='tg-btnviewall' href='booksearch.php'>Back</a>";
									}
									else
									{
										echo "<a class='tg-btnviewall' href='bookresult.php?id=$nextId'>Next Page</a>";
									}

								?>
								
							</div>
						</div>
						<div id="tg-pickedbyauthorslider" class="tg-pickedbyauthor tg-pickedbyauthorslider owl-carousel">

						<?php 

             				foreach ($formattedResponse['Items']['Item'] as $item) { ?>




							<div class="item">
								<div class="tg-postbook">
									<figure class="tg-featureimg">
										<div class="tg-bookimg">
										<div class="tg-frontcover"><img src="

											<?php

								                if(!isset($item['ImageSets']['ImageSet']['LargeImage']['URL']))
								                 {
								                  echo  'https://www.ampersandbio.com/wp-content/uploads/2016/10/no-image.gif';
								                 }

								                 else
								                 {

								                  echo $item['ImageSets']['ImageSet']['LargeImage']['URL'];

								                 }


								             ?>


											" alt="image description"></div>
										</div>
										<div class="tg-hovercontent">
											<div class="tg-description">
												<p><?php echo $item['ItemAttributes']['Title']; ?> </p>
											</div>
											<strong class="tg-bookpage">
											<a target="_blank" class="tg-btn tg-btnstyletwo" href="<?php echo $item['DetailPageURL']; ?>">
											<i class="fa fa-book"></i>
											<em>Book Reveiw</em>
											</a>
											</strong>
											<!-- <strong class="tg-bookcategory">Category: Adventure, Fun</strong> -->
											<strong class="tg-bookprice">
												
												<?php

							                     if(!isset($item['ItemAttributes']['ListPrice']['FormattedPrice']))
							                         {
							                          echo 'Price: ' . 'Currently not available' . '<br>';
							                         }
							                         else
							                         {
							                           echo 'Price: '.  $item['ItemAttributes']['ListPrice']['FormattedPrice'] . '<br>';
							                         }
                   								 ?> 


											</strong>
											<div class="tg-ratingbox"><span class="tg-stars"><span></span></span></div>
										</div>
									</figure>
									<div class="tg-postbookcontent">
										<div class="tg-booktitle">
											<h3><a href="javascript:void(0);">Title: <?php echo $item['ItemAttributes']['Title']; ?></a></h3>
										</div>
										<span class="tg-bookwriter">By:<a href="javascript:void(0);">

										<?php

				                         if(isset($item['ItemAttributes']['Author']) && $item['ItemAttributes']['Author'] > 1)
				                           {
				                             
				                              foreach($item['ItemAttributes']['Author'] as $arthur)
				                                {
				                                   echo  $arthur . ',' . '&nbsp;';
				                                }
				                              	echo '<br>';
				                            }

			                           elseif (!isset($item['ItemAttributes']['Author']))
			                            {
			                              echo 'Authur: Author not available' . '<br>';
			                            }

			                           else
			                           {
			                              echo  $item['ItemAttributes']['Author'] . '<br>';
			                           }

                       	 			   ?>



										</a></span>
										<a class="tg-btn tg-btnstyletwo" target="_blank" href="<?php echo $item['DetailPageURL']; ?>">
											<i class="fa fa-shopping-basket"></i>
											<em>Buy Now</em>
										</a>
									</div>
								</div>
							</div>


							<?php } ?>



						</div>
					</div>
				</div>
			</section>
			<div class="tg-footerbar">
				<a id="tg-btnbacktotop" class="tg-btnbacktotop" href="javascript:void(0);"><i class="icon-chevron-up"></i></a>
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<span class="tg-paymenttype"><img src="images/paymenticon.png" alt="image description"></span>
							<span class="tg-copyright">2018 All Rights Reserved Developed by <a href="twitter.com/vhiktordom" target="_blank">Victor Dominic</a></span>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>

	<script src="js/vendor/jquery-library.js"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyCR-KEWAVCn52mSdeVeTqZjtqbmVJyfSus&amp;language=en"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.vide.min.js"></script>
	<script src="js/countdown.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/parallax.js"></script>
	<script src="js/countTo.js"></script>
	<script src="js/appear.js"></script>
	<script src="js/gmap3.js"></script>
	<script src="js/main.js"></script>
</body>

<!-- Victor Dominic Wrok -->
</html>