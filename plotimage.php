<?php
 
 $img = imagecreatetruecolor(500,500);
 
$ink = imagecolorallocate($img,255,255,255);
$redink = imagecolorallocate($img,255,0,0);
 
/*
for($i=0;$i<500;$i++) {
   for($j=0;$j<500;$j++) {
   	$ink = imagecolorallocate($img, mt_rand(1,255), mt_rand(1,255), mt_rand(1,255));
   imagesetpixel($img, mt_rand(1,500), mt_rand(1,500), $ink);
   }
 }
  */

//draw the cartesian axis.  First the Y-axis
for ($y=-150; $y<150; $y++) {
    $plot_y = 250 + $y;
    $plot_x = 250 + 0;
    imagesetpixel($img, $plot_x, $plot_y, $ink);
}
//then the X-axis
for ($x=-150; $x<150; $x++) {
    $plot_x = 250 + $x;
    $plot_y = 250 + 0;
    imagesetpixel($img, $plot_x, $plot_y, $ink);
}


//now draw the circle with radius 50 pixels
//increment by 0.05 so that in the severe angles, none of the Y values are skipped.
for ($x=0; $x<50; $x=$x + 0.05) {

  $y = sqrt(2500 - $x * $x);  //based on the formula for a circle, is that r^2 = x^2 + y@ ?
  if ($y>500) die('bad math!!!');

  //translate x and y into screen pixel locations
  $plot_x = 250 + $x;  
  $plot_x2 = 250 - $x;
  $plot_y = 250 - $y;
  $plot_y2 = 250 + $y;  //the other side of the circle

  //set the pixels.
  //$x is incrementing by 0.05, and plot_y is a square root with decimals,
  ////so I guess imagesetpixel is converting plot_x and plot_y 
  //// to integers, truncating off the decimal portion
  imagesetpixel($img, $plot_x, $plot_y, $ink);
  imagesetpixel($img, $plot_x, $plot_y2, $ink);
  imagesetpixel($img, $plot_x2, $plot_y, $ink);
  imagesetpixel($img, $plot_x2, $plot_y2, $ink);
}

//now draw the tic marks for the Y-axis
for ($y=-150; $y<=150; $y= $y+50) {
    $plot_y = 250 + $y;
    for ($x=-10; $x<=10; $x++) {
        $plot_x = 250 + $x;
        imagesetpixel($img, $plot_x, $plot_y, $redink);
    }
}
//tic marks for the X-axis
for ($x=-150; $x<=150; $x= $x+50) {
    $plot_x = 250 + $x;
    for ($y=-10; $y<=10; $y++) {
        $plot_y = 250 + $y;
        imagesetpixel($img, $plot_x, $plot_y, $redink);
    }
}

header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
 
?>
 