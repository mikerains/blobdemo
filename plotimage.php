<?php
 header("Content-type: image/png");
 $img = imagecreatetruecolor(500,500);
 
$ink = imagecolorallocate($img,255,255,255);
 
/*
for($i=0;$i<500;$i++) {
   for($j=0;$j<500;$j++) {
   	$ink = imagecolorallocate($img, mt_rand(1,255), mt_rand(1,255), mt_rand(1,255));
   imagesetpixel($img, mt_rand(1,500), mt_rand(1,500), $ink);
   }
 }
 */

for ($y=0; $y<50; $y++) {
    $plot_y = 250 + $y;
    $plot_x = 250 + 0;
    imagesetpixel($img, $plot_x, $plot_y, $ink);
}
for ($x=0; $x<50; $x++) {
    $plot_x = 250 + $x;
    $plot_y = 250 + 0;
    imagesetpixel($img, $plot_x, $plot_y, $ink);
}
 
for ($x=0; $x<50; $x++) {

  $y = sqrt(2500 - $x * $x);  //based on the formula for a circle, is that r^2 = x^2 + y@ ?
  if ($y>500) die('bad math!!!');

  $plot_x = 250 + $x;
  $plot_x2 = 250 - $x;
  $plot_y = 250 + $y;
  $plot_y2 = 250 - $y;  //the other side of the circle

  imagesetpixel($img, $plot_x, $plot_y, $ink);
  imagesetpixel($img, $plot_x, $plot_y2, $ink);
  imagesetpixel($img, $plot_x2, $plot_y, $ink);
  imagesetpixel($img, $plot_x2, $plot_y2, $ink);
}

imagepng($img);
imagedestroy($img);
 
?>
 