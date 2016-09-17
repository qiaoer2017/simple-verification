<?php
header("content-type:image/png");
$img = imagecreatetruecolor(100,40);
$white=imagecolorallocate($img,0xff,0xff,0xff);
$black = imagecolorallocate($img,0x00,0x00,0x00);
$red = imagecolorallocate($img,0xff,0x00,0x00);
$green = imagecolorallocate($img,0x00,0xff,0x00);
$grey = imagecolorallocate($img,0x66,0x66,0x66);
imagefill($img,0,0,$white);

$characters = array("3","4","6","7","8","9","A","B","C","D","E","F","G","H","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","j","k","l","m","n","o","p","q","r","t","u","v","w","x","y");

for($i=0;$i<4;$i++){
    $font = rand(30,50);
    $x = rand(10,15)+$i*25;
    $y = rand(10,20);
    $c = $characters[rand(0,count($characters)-1)];
    // echo $font,$x,$y,$c;
    imagestring($img,$font,$x,$y,$c,$black);
}


for($i=0;$i<100;$i++){
    imagesetpixel($img,rand(0,100),rand(0,40),$black);  
    imagesetpixel($img,rand(0,100),rand(0,40),$red); 
}
for($i=0;$i<2;$i++){
    imageline($img,rand(0,100),rand(0,40),rand(0,100),rand(0,40),$grey);
    imageline($img,rand(0,100),rand(0,40),rand(0,100),rand(0,40),$red);
     imageline($img,rand(0,100),rand(0,40),rand(0,100),rand(0,40),$green);
}

imagepng($img);
imagedestroy($img);
?>
