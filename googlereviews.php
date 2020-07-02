<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.1/assets/owl.carousel.min.css'>
<link rel='stylesheet' href='https://themes.audemedia.com/html/goodgrowth/css/owl.theme.default.min.css'>


<?php
/*

💬 Get Google-Reviews with PHP cURL & without API Key
=====================================================

**This is a dirty but usefull way to grab the first 8 most relevant reviews from Google with cURL and without the use of an API Key**

How to find the needed CID No:
  - use: [https://pleper.com/index.php?do=tools&sdo=cid_converter]
  - and do a search for your business name

Parameter
---------
```PHP
$options = array(
  'google_maps_review_cid' => '17311646584374698221', // Customer Identification (CID)
  'show_only_if_with_text' => false, // true = show only reviews that have text
  'show_only_if_greater_x' => 0,     // (0-4) only show reviews with more than x stars
  'show_rule_after_review' => true,  // false = don't show <hr> Tag after each review
  'show_blank_star_till_5' => true,  // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
  'your_language_for_tran' => 'en',  // give you language for auto translate reviews
);
echo getReviews($options);

```

> HINT: Use .quote in you CSS to style the output

###### Copyright 2019-2020 Igor Gaffling

*/

$options = array(
  'google_maps_review_cid' => '4066429535915557512', // Customer Identification (CID)
  'show_only_if_with_text' => false, // true = show only reviews that have text
  'show_only_if_greater_x' => 0,     // (0-4) only show reviews with more than x stars
  'show_rule_after_review' => true,  // false = don't show <hr> Tag after each review
  'show_blank_star_till_5' => true,  // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
  'your_language_for_tran' => 'Pt-br',  // give you language for auto translate reviews
);
/* ------------------------------------------------------------------------- */
echo getReviews($options);
/* ------------------------------------------------------------------------- */
function getReviews($option) {
  $ch = curl_init('https://www.google.com/maps?cid='.$option['google_maps_review_cid']);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla / 5.0 (Windows; U; Windows NT 5.1; en - US; rv:1.8.1.6) Gecko / 20070725 Firefox / 2.0.0.6");
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Language: '.$option['your_language_for_tran']));
  $result = curl_exec($ch);
  curl_close($ch);
  $pattern = '/window\.APP_INITIALIZATION_STATE(.*);window\.APP_FLAGS=/ms';
  if ( preg_match($pattern, $result, $match) ) {
    $match[1] = trim($match[1], ' =;'); /* fix json */
    $reviews  = json_decode($match[1]);
    $reviews  = ltrim($reviews[3][6], ")]}'"); /* fix json */
    $reviews  = json_decode($reviews);
    $customer = $reviews[6][11]; // NEW IN 2020
    $reviews  = $reviews[6][52][0]; // NEW IN 2020
    
  }
  echo '<section class="testimonials">';

echo '<div class="wrapper">';
echo '<div class="row" style="margin-right: 0 !important;
margin-left: 0 !important;"> ';
echo '<div class="col-sm-12">';
echo '<div id="testimonials-list" class="owl-carousel">';

  $return = '';
  //echo '<pre>';
  if (isset($reviews)) {
    //$return .= ''.$customer.'';
    //if ($option['show_rule_after_review'] == true) $return .= '<hr size="1">';
    $return .= '';
    foreach ($reviews as $review) {
		if($review[4]>2){
			if ($option['show_only_if_with_text'] == true and empty($review[3])) continue;
			$return .= '<div class="item"><div class="shadow-effect"><img class="imgPlaceholder" src='.$review[0][2].'>'; /* Imagem */
			if ($review[4] <= $option['show_only_if_greater_x']) continue;
			for ($i=1; $i <= $review[4]; ++$i) $return .= '⭐'; /* RATING */
			if ($option['show_blank_star_till_5'] == true)
				for ($i=1; $i <= 5-$review[4]; ++$i) $return .= '☆'; /* RATING */
			$return .= '<p>'.substr(trim(strip_tags($review[3])),0,200).'... </p><br>'; /* TEXT */
			//$return .= '<small>'.$review[0][1].'</small></p>'; /* AUTHOR */
			$return .= '<div class="testimonial-name">'.$review[0][1].'</div>'; /* AUTHOR */
			$return .=  '</div>';
			$return .= ' </div>';
			if ($option['show_rule_after_review'] == true) $return .= '';
			
		} // ESTRELAS
    }
	
   
  }


  return $return;

 
 

}







echo '</div>';
echo '</div>';
echo '</div>';
echo '</section>';
 
?>



      
        
          

           
              
               
                
             
              
            
        
           
            
    

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.1/owl.carousel.min.js'></script>
<script  src="function.js"></script>

<style>
/*  Code By Webdevtrick ( https://webdevtrick.com )  */
body{background: none;}
html{overflow: hidden;}
.shadow-effect {
		    background: #fff;
		    padding: 20px;
		    border-radius: 4px;
		    text-align: center;
	border:1px solid #ECECEC;
		    box-shadow: 0 19px 38px rgba(0,0,0,0.10), 0 15px 12px rgba(0,0,0,0.02);
		}
		#testimonials-list .shadow-effect p {
		    font-family: inherit;
		    font-size: 17px;
		    line-height: 1.5;
		    margin: 0 0 17px 0;
		    font-weight: 300;
		}
		.testimonial-name {
		    margin: -17px auto 0;
		    display: table;
		    width: auto;
		    background: #3190E7;
		    padding: 9px 35px;
		    border-radius: 12px;
		    text-align: center;
		    color: #fff;
		    box-shadow: 0 9px 18px rgba(0,0,0,0.12), 0 5px 7px rgba(0,0,0,0.05);
		}
		#testimonials-list .item {
		    text-align: center;
		    padding: 50px;
				margin-bottom:80px;
		    opacity: .2;
		    -webkit-transform: scale3d(0.8, 0.8, 1);
		    transform: scale3d(0.8, 0.8, 1);
		    transition: all 0.3s ease-in-out;
		}
		#testimonials-list .owl-item.active.center .item {
		    opacity: 1;
		    -webkit-transform: scale3d(1.0, 1.0, 1);
		    transform: scale3d(1.0, 1.0, 1);
		}
		.owl-carousel .owl-item img {
		    -webkit-transform-style: preserve-3d;
		            transform-style: preserve-3d;
			max-width: 90px;
			border-radius: 50%;
    		margin: 0 auto 17px;
		}
		#testimonials-list.owl-carousel .owl-dots .owl-dot.active span,
#testimonials-list.owl-carousel .owl-dots .owl-dot:hover span {
		    background: #3190E7;
		    -webkit-transform: translate3d(0px, -50%, 0px) scale(0.7);
		            transform: translate3d(0px, -50%, 0px) scale(0.7);
		}
#testimonials-list.owl-carousel .owl-dots{
	display: inline-block;
	width: 100%;
	text-align: center;
    bottom: 5px;
    position: sticky;
}
#testimonials-list.owl-carousel .owl-dots .owl-dot{
	display: inline-block;
}
		#testimonials-list.owl-carousel .owl-dots .owl-dot span {
		    background: #3190E7;
		    display: inline-block;
		    height: 20px;
		    margin: 0 2px 5px;
		    -webkit-transform: translate3d(0px, -50%, 0px) scale(0.3);
		            transform: translate3d(0px, -50%, 0px) scale(0.3);
		    -webkit-transform-origin: 50% 50% 0;
		            transform-origin: 50% 50% 0;
		    transition: all 250ms ease-out 0s;
		    width: 20px;
		}

</style>

<script>
//  Code By Webdevtrick ( https://webdevtrick.com ) 
jQuery(document).ready(function($) {
        		"use strict";
		        $('#testimonials-list').owlCarousel({
		            loop: true,
		            center: true,
		            items: 3,
		            margin: 0,
		            autoplay: true,
		            dots:true,
		            autoplayTimeout: 8500,
		            smartSpeed: 450,
		            responsive: {
		              0: {
		                items: 1
		              },
		              768: {
		                items: 2
		              },
		              1170: {
		                items: 3
		              }
		            }
		        });
        	});

</script>

</body>
</html>
