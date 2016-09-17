<?php
/**
 * @param int $type 想得到的字符串的类型:1代表数字字符串,2代表字母字符串,3代表数字字母字符串
 * @param int $length 想得到的字符串的长度
 * @return string 返回一个指定长度的随机字符串
 */
function buildRandomString($type = 1, $length = 4)
{
    switch ($type) {
        case 1:
            $chars = join("", range(0, 9));
            break;
        case 2:
            $chars = join("", array_merge(range("a", "z"), range("A", "Z")));
            break;
        case 3:
            $chars = join("", array_merge(range("a", "z"), range("A", "Z"), range(0, 9)));
            break;
        default:
            $chars = join("", range(0, 9));
            break;
    }

    if ($length > strlen($chars)) {
        exit("字符串长度不够");
    }
    $chars = str_shuffle($chars);
    return substr($chars, 0, $length);

}

/**
 * @param int $width 图像宽,默认80px
 * @param int $height 图像高,默认30px
 * @param int $type 验证码类型:1代表数字字符串,2代表字母字符串,3代表数字字母字符串,默认为3
 * @param int $length 验证码长度,默认为4
 * @param string $sess_name SESSION键名,默认为verify
 * @param bool $haspixel 是否需要噪点,默认需要
 * @param bool $hasline 是否需要干扰线段,默认需要
 */
function verifyImage($width = 80, $height = 30, $type = 3, $length = 4, $sess_name = "verify", $haspixel = true, $hasline = true)
{
    $img = imagecreatetruecolor($width, $height);
    $grey = imagecolorallocate($img, 0xcc, 0xcc, 0xcc);
    $white = imagecolorallocate($img, 0xff, 0xff, 0xff);
    imagefill($img, 0, 0, $grey);
    imagefilledrectangle($img, 1, 1, $width - 2, $height - 2, $white);


    $chars = buildRandomString($type, $length);

    $_SESSION[$sess_name] = $chars;

    $fonts = array("AppleMyungjo.ttf", "Chalkduster.ttf", "DIN Condensed Bold.ttf", "Gungseouche.ttf", "Luminari.ttf", "Silom.ttf");
    for ($i = 0; $i < $length; $i++) {
        $size = rand(14, 18);
        $angle = rand(-18, 18);
        $x = 5 + $size * $i;
        $y = rand(20, 26);
        $color = imagecolorallocate($img, rand(10, 160), rand(50, 190), rand(100, 210));
        $fontfile = "./fonts/" . $fonts[rand(0, count($fonts) - 1)];
        $text = $chars[$i];
        imagettftext($img, $size, $angle, $x, $y, $color, $fontfile, $text);
    }

    if ($haspixel) {
        $point_count = rand(40, 60);
        for ($i = 0; $i < $point_count; $i++) {
            $x = rand(1, $width - 2);
            $y = rand(1, $height - 2);
            $color = imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($img, $x, $y, $color);
        }
    }

    if ($hasline) {
        $line_count = rand(2, 5);
        for ($i = 0; $i < $line_count; $i++) {
            $x1 = rand(1, $width - 2);
            $y1 = rand(1, $height - 2);
            $x2 = rand(1, $width - 2);
            $y2 = rand(1, $height - 2);
            $color = imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
            imageline($img, $x1, $y1, $x2, $y2, $color);
        }
    }

    header("content-type:image/gif");
    imagegif($img);
    imagedestroy($img);
}

verifyImage();