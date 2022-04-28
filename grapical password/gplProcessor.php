<?php

include_once 'include/dbinstall.php';
//$fg = "#ff0080";
define("GPL_PRIMITIVE_WIDTH", 75);
define("GPL_PRIMITIVE_HEIGHT", 75);
define("GPL_PRIMITIVE_BORDER", 5);
define("GPL_PRIMITIVE_BORDER_COLOR", 0x000000);
define("GPL_PRIMITIVE_COUNT", 3); //amount of combos on one pictures
define("GPL_FILL_COLOR", 0xFFFFFF);
define("GPL_DIGIT_FONT", __DIR__ . "/include/arialbd.ttf"); //for linux use "/" instead of "\"
define("GPL_DIGIT_FONT_SIZE", 18);

define("GPL_DIGIT_0", 0x01);
define("GPL_DIGIT_1", 0x02);
define("GPL_DIGIT_2", 0x03);
define("GPL_DIGIT_3", 0x04);
define("GPL_DIGIT_4", 0x05);
define("GPL_DIGIT_5", 0x06);
define("GPL_DIGIT_6", 0x07);
define("GPL_DIGIT_7", 0x08);
define("GPL_DIGIT_8", 0x09);
define("GPL_DIGIT_9", 0x0A); //10

define("GPL_COLOR_RED", 0x0B);
define("GPL_COLOR_BLUE", 0x0C);
define("GPL_COLOR_GREEN", 0x0D);
define("GPL_COLOR_YELLOW", 0x0E);
define("GPL_COLOR_VIOLET", 0x0F); //15
define("GPL_COLOR_WHITE", 0x10);
define("GPL_COLOR_PINK", 0x11);

define("GPL_SHAPE_CIRCLE", 0x12);
define("GPL_SHAPE_SQUARE", 0x13);
define("GPL_SHAPE_TRIANGLE", 0x14);//20
define("GPL_SHAPE_TRAPEZE", 0x15);
define("GPL_SHAPE_PENTAGON", 0x16);
define("GPL_SHAPE_CROSS", 0x17);
define("GPL_SHAPE_DIAMOND", 0x18);

$gpl_shape_types = array(GPL_SHAPE_CIRCLE, GPL_SHAPE_SQUARE, GPL_SHAPE_TRIANGLE, GPL_SHAPE_TRAPEZE, GPL_SHAPE_PENTAGON, GPL_SHAPE_CROSS, GPL_SHAPE_DIAMOND);
$gpl_color_types = array(GPL_COLOR_RED, GPL_COLOR_BLUE, GPL_COLOR_GREEN, GPL_COLOR_YELLOW, GPL_COLOR_VIOLET, GPL_COLOR_WHITE, GPL_COLOR_PINK);
$gpl_digit_types = array(GPL_DIGIT_0, GPL_DIGIT_1, GPL_DIGIT_2, GPL_DIGIT_3, GPL_DIGIT_4, GPL_DIGIT_5, GPL_DIGIT_6, GPL_DIGIT_7, GPL_DIGIT_8, GPL_DIGIT_9);


//*** This function randomize the order of the elements in the array

function gpl_make_array($inArr)
{
    $sourceArr = $inArr;
    shuffle($sourceArr);
    $aRet = array();
    foreach (array_rand($sourceArr, GPL_PRIMITIVE_COUNT) as $idx) {
        $aRet[] = $inArr[$idx];
    }
    return $aRet;
}

function invert_color($c)
{
    return $c ^ 0xFFFFFF | 0x1000000;
}

function gpl_getDigitChar($type)
{
    switch ($type) {
        case GPL_DIGIT_0:
            return "0";
            break;
        case GPL_DIGIT_1:
            return "1";
            break;
        case GPL_DIGIT_2:
            return "2";
            break;
        case GPL_DIGIT_3:
            return "3";
            break;
        case GPL_DIGIT_4:
            return "4";
            break;
        case GPL_DIGIT_5:
            return "5";
            break;
        case GPL_DIGIT_6:
            return "6";
            break;
        case GPL_DIGIT_7:
            return "7";
            break;
        case GPL_DIGIT_8:
            return "8";
            break;
        case GPL_DIGIT_9:
            return "9";
            break;
        default:
            return "0";
    }
}

function gpl_getColorCode($type)
{
    switch ($type) {
        case GPL_COLOR_BLUE:
            return 0x0000FF;
            break;
        case GPL_COLOR_RED:
            return 0xFF0000;
            break;
        case GPL_COLOR_GREEN:
            return 0x32CD32;
            break;
        case GPL_COLOR_YELLOW:
            return 0xFFFF00;
            break;
        case GPL_COLOR_PINK:
            return 0xFFC0CB;
            break;
        case GPL_COLOR_VIOLET:
            return 0xEE82EE;
            break;
        case GPL_COLOR_WHITE:
            return 0xFFFFFF;
            break;
        default:
            return 0;
    }
}

function gpl_create_primitive_draw($digit, $color, $shape)
{

    $canvas = imagecreatetruecolor(GPL_PRIMITIVE_WIDTH, GPL_PRIMITIVE_HEIGHT);
    $real_color = $color;
    $left = 0;
    $top = 0;
    $right = GPL_PRIMITIVE_WIDTH - 1;
    $bot = GPL_PRIMITIVE_HEIGHT - 1;
    $centerX = round(($right - $left) / 2);
    $centerY = round(($bot - $top) / 2);

    if (!empty($color) && empty($shape) && empty($digit)) {
        imagefilledrectangle($canvas, $left, $top, $right, $bot, gpl_getColorCode($color));
    } else {
        if (empty($color)) $color = GPL_COLOR_WHITE;
        imagefill($canvas, 0, 0, GPL_FILL_COLOR);
    }
    if (!empty($shape)) {
        switch ($shape) {
            case GPL_SHAPE_CIRCLE:
                imagefilledellipse($canvas, $centerX, $centerY, $right - $left, $bot - $top, gpl_getColorCode($color));
                imageellipse($canvas, $centerX, $centerY, $right - $left, $bot - $top, GPL_PRIMITIVE_BORDER_COLOR);
                imageellipse($canvas, $centerX, $centerY, $right - $left - 1, $bot - $top - 1, GPL_PRIMITIVE_BORDER_COLOR);
                break;
            case GPL_SHAPE_CROSS:
                imagefilledpolygon($canvas, array(
                    $centerX - 10, $top,
                    $centerX + 10, $top,
                    $centerX + 10, $centerY - 10,
                    $right, $centerY - 10,
                    $right, $centerY + 10,
                    $centerX + 10, $centerY + 10,
                    $centerX + 10, $bot,
                    $centerX - 10, $bot,
                    $centerX - 10, $centerY + 10,
                    $left, $centerY + 10,
                    $left, $centerY - 10,
                    $centerX - 10, $centerY - 10), 12, gpl_getColorCode($color));
                imagepolygon($canvas, array(
                    $centerX - 10, $top,
                    $centerX + 10, $top,
                    $centerX + 10, $centerY - 10,
                    $right, $centerY - 10,
                    $right, $centerY + 10,
                    $centerX + 10, $centerY + 10,
                    $centerX + 10, $bot,
                    $centerX - 10, $bot,
                    $centerX - 10, $centerY + 10,
                    $left, $centerY + 10,
                    $left, $centerY - 10,
                    $centerX - 10, $centerY - 10), 12, GPL_PRIMITIVE_BORDER_COLOR);
                imagepolygon($canvas, array(
                    $centerX - 10 + 1, $top + 1,
                    $centerX + 10 - 1, $top + 1,
                    $centerX + 10 - 1, $centerY - 10 - 1,
                    $right - 1, $centerY - 10 - 1,
                    $right - 1, $centerY + 10 - 1,
                    $centerX + 10 - 1, $centerY + 10 - 1,
                    $centerX + 10 - 1, $bot - 1,
                    $centerX - 10 + 1, $bot - 1,
                    $centerX - 10 + 1, $centerY + 10 - 1,
                    $left + 1, $centerY + 10 - 1,
                    $left + 1, $centerY - 10 + 1,
                    $centerX - 10 + 1, $centerY - 10 + 1), 12, GPL_PRIMITIVE_BORDER_COLOR);
                break;
            case GPL_SHAPE_DIAMOND:
                imagefilledpolygon($canvas, array($centerX, $top, $right, $centerY, $centerX, $bot, $left, $centerY), 4, gpl_getColorCode($color));
                imagepolygon($canvas, array($centerX, $top, $right, $centerY, $centerX, $bot, $left, $centerY), 4, GPL_PRIMITIVE_BORDER_COLOR);
                imagepolygon($canvas, array($centerX, $top + 1, $right - 1, $centerY, $centerX, $bot - 1, $left + 1, $centerY), 4, GPL_PRIMITIVE_BORDER_COLOR);
                break;
            case GPL_SHAPE_PENTAGON:
                imagefilledpolygon($canvas, array($centerX, $top, $right, $centerY, $centerX + 15, $bot, $centerX - 15, $bot, $left, $centerY), 5, gpl_getColorCode($color));
                imagepolygon($canvas, array($centerX, $top, $right, $centerY, $centerX + 15, $bot, $centerX - 15, $bot, $left, $centerY), 5, GPL_PRIMITIVE_BORDER_COLOR);
                imagepolygon($canvas, array($centerX, $top + 1, $right - 1, $centerY, $centerX + 15, $bot - 1, $centerX - 15, $bot - 1, $left + 1, $centerY), 5, GPL_PRIMITIVE_BORDER_COLOR);
                break;
            case GPL_SHAPE_SQUARE:
                imagefilledrectangle($canvas, $left, $top, $right, $bot, gpl_getColorCode($color));
                imagerectangle($canvas, $left, $top, $right, $bot, GPL_PRIMITIVE_BORDER_COLOR);
                imagerectangle($canvas, $left + 1, $top + 1, $right - 1, $bot - 1, GPL_PRIMITIVE_BORDER_COLOR);
                break;
            case GPL_SHAPE_TRAPEZE:
                imagefilledpolygon($canvas, array($centerX - 10, $top, $centerX + 10, $top, $right, $bot, $left, $bot), 4, gpl_getColorCode($color));
                imagepolygon($canvas, array($centerX - 10, $top, $centerX + 10, $top, $right, $bot, $left, $bot), 4, GPL_PRIMITIVE_BORDER_COLOR);
                imagepolygon($canvas, array($centerX - 10, $top - 1, $centerX + 10, $top - 1, $right - 1, $bot + 1, $left - 1, $bot + 1), 4, GPL_PRIMITIVE_BORDER_COLOR);
                break;
            case GPL_SHAPE_TRIANGLE:
                imagefilledpolygon($canvas, array($centerX, $top, $right, $bot, $left, $bot), 3, gpl_getColorCode($color));
                imagepolygon($canvas, array($centerX, $top, $right, $bot, $left, $bot), 3, GPL_PRIMITIVE_BORDER_COLOR);
                imagepolygon($canvas, array($centerX, $top - 1, $right - 1, $bot - 1, $left + 1, $bot - 1), 3, GPL_PRIMITIVE_BORDER_COLOR);
                break;
        }
    }
    $digX = $centerX - 5;
    $digY = $centerY + round(GPL_DIGIT_FONT_SIZE / 2);
    if (!empty($digit)) {
        imagettftext($canvas, GPL_DIGIT_FONT_SIZE, 0, $digX, $digY, invert_color(gpl_getColorCode($color)), GPL_DIGIT_FONT, gpl_getDigitChar($digit));
    }
    if (empty($real_color)) {
        imagecolortransparent($canvas, gpl_getColorCode($color));
    }
    return $canvas;
}

function my_close_ses()
{
    //session_start();
    session_unset();

    session_destroy();
}

function my_start_ses()
{

    session_start();
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    }
}

//******  END OF CONSTANTS  *********


try {
    my_start_ses();
    if (!isset($_REQUEST["t"])) throw new Exception("Error. No type");
    switch ($_REQUEST["t"]) {

        case "y": // refresh images for password and write them to $_SESSION as primitives
            $arr = array();
            foreach ($gpl_digit_types as $val) {
                $arr[] = array("type" => 1, "code" => $val);                
            }
            foreach ($gpl_color_types as $val) {
                $arr[] = array("type" => 2, "code" => $val);
            }
            foreach ($gpl_shape_types as $val) {
                $arr[] = array("type" => 3, "code" => $val);
            }
            shuffle($arr);
            $_SESSION["PRIMITIVES"] = $arr;
            break;

        case "p": // get single primitive image when user choosing the password
            if (!isset($_GET["n"])) throw new Exception("Error. No number");
            if (!isset($_SESSION["PRIMITIVES"])) throw new Exception("Error. Primitives.");
            $elem = $_SESSION["PRIMITIVES"][$_GET["n"] - 1];

            if (empty($elem)) throw new Exception("Error. No element");
            $dig = "";
            $col = "";
            $shp = "";
            if ($elem["type"] == 1) $dig = $elem["code"];
            if ($elem["type"] == 2) $col = $elem["code"];
            if ($elem["type"] == 3) $shp = $elem["code"];
            $dest = gpl_create_primitive_draw($dig, $col, $shp);
            header('Content-type: image/png');
            imagepng($dest);
            imagedestroy($dest);
            break;

        case "g": // get image with primitives for the password input
            if (!isset($_GET["u"]) || !isset($_GET["s"]) || !isset($_GET["p"])) throw new Exception("Error g 1");
            $aPrim = array();
            $aPrim[] = gpl_make_array($gpl_digit_types); //three digits
            $aPrim[] = gpl_make_array($gpl_color_types); //three colours
            $aPrim[] = gpl_make_array($gpl_shape_types); //three shapes           
            $imgPos = $_GET["p"];
            if (!empty($_SESSION["USER"])) {
                $arr = array();
                foreach ($aPrim as $value) {
                    $arr = array_merge($value, $arr);
                }
                $_SESSION["IMAGE_VALUES"]["img" . $imgPos] = $arr;
            }
            $totWidth = (GPL_PRIMITIVE_BORDER + GPL_PRIMITIVE_WIDTH) * 3 + GPL_PRIMITIVE_BORDER;
            $totHeight = GPL_PRIMITIVE_BORDER * 2 + GPL_PRIMITIVE_HEIGHT;
            $dest = imagecreatetruecolor($totWidth, $totHeight);   // Create empty image $x by $y
            imagefill($dest, 0, 0, GPL_FILL_COLOR);
            for ($ind = 0; $ind < GPL_PRIMITIVE_COUNT; ++$ind) {
                $prim = gpl_create_primitive_draw($aPrim[0][$ind], $aPrim[1][$ind], $aPrim[2][$ind]); //take every element in the array and get its value
                $xShift = GPL_PRIMITIVE_BORDER + (GPL_PRIMITIVE_WIDTH + GPL_PRIMITIVE_BORDER) * $ind;
                imagecopy($dest, $prim, $xShift, GPL_PRIMITIVE_BORDER, 0, 0, imagesx($prim), imagesy($prim));   //
                imagedestroy($prim);
            }
            //Add noise on picture to avoid its hashing by troyan horse
            for ($maxNoise = ($totHeight * $totWidth) / 10; $maxNoise > 0; $maxNoise--) {
                imagesetpixel($dest, rand(0, $totWidth), rand(0, $totHeight), rand(0, 0xffffff));
            }
            for ($maxLines = 5; $maxLines > 0; $maxLines--) {
                imageline($dest, rand(0, $totWidth), rand(0, $totHeight), rand(0, $totWidth), rand(0, $totHeight), 0);
            }

            header('Content-type: image/png');
            imagepng($dest);
            imagedestroy($dest);
            break;

        case "c": // check password
            $imgFn = "images/bad.jpg";
            
            if (isset($_SESSION["CURRENT_STAGE"]) && isset($_SESSION["PASS_BY_POS"]) && count($_SESSION["PASS_BY_POS"]) == $_SESSION["CURRENT_STAGE"] - 1) 
            {
                $imgFn = "images/ok.jpg";
				
				
              
            }
        
            
               
            
            my_close_ses();
            header('Content-type: image/jpeg');
            $img = imagecreatefromjpeg($imgFn);
            imagejpeg($img);
            imagedestroy($img);
            break;

        case "i": // request password and Initialize user's session
            my_close_ses();
            session_start();
            $db = getBase();
            $res = $db->query("select * from user where user ='" . $_POST["u"] . "' limit 1");
            $user = $res ? $res->fetch_object() : "";
            $isUser = !empty($user);
            if ($isUser) {
                $_SESSION["USER"] = $user;
                $_SESSION["CURRENT_STAGE"] = 1;
                $tmp = array();
                //Split password
                foreach (preg_split("/,/", $user->pass, NULL, PREG_SPLIT_NO_EMPTY) as $val) {
                    $tmp[] = array("code" => $val, "primPos" => rand(0, GPL_PRIMITIVE_COUNT), "imagePos" => rand(1, 4));
                }
                if (!empty($tmp)) $_SESSION["PASS_BY_POS"] = $tmp; //SAVE USER'S PASSWORD into COOKIE!
            }
            break;

        case "a": // final add/edit user password.
            if (!isset($_SESSION["PRIMITIVES"])) throw new Exception("Error. Session. Primitives not set.");
            if (empty($_REQUEST["u"])) throw new Exception("Error. Request. Username not set.");
            if (empty($_REQUEST["p"])) throw new Exception("Error. Request. Password not set.");
            $db = getBase();
            $res = $db->query("select * from user where user ='" . $_REQUEST["u"] . "' limit 1");
			/* $req = $db->prepare("select * from user where user = ? limit 1");
			$req->bind_param('s', $_REQUEST["u"]);
			$req->execute(); */
			
            $user = $res ? $res->fetch_object() : "";
            $pass = "";
            //preg_split ( string $pattern , string $subject [, int $limit = -1 [, int $flags = 0 ]] )
            foreach (preg_split("/,/", $_REQUEST["p"], NULL, PREG_SPLIT_NO_EMPTY) as $val) {
                $elem = $_SESSION["PRIMITIVES"][$val - 1];
                if (!empty($pass)) $pass .= ",";
                $pass .= $elem["code"];
            }
            //Add new user and password
            if (empty($user)) {               
				$req = $db->prepare("INSERT INTO user (user , pass) VALUES (?,?)");
				$req->bind_param('ss', $_REQUEST["u"], $pass);
				$req->execute();				
                if ($db->errno) throw new Exception($db->error);
                echo "User '" . $_REQUEST["u"] . "' added.";
				
            //Update existing user's password
            } else {
                $req = $db->prepare("UPDATE user SET pass=? WHERE user=?");
				$req->bind_param('ss', $pass, $_REQUEST["u"]);
				$req->execute();			
                if ($db->errno) throw new Exception($db->error);
                echo "User '" . $_REQUEST["u"] . "' updated.";
            }
            my_close_ses();
            break;

        case "r": // reg primitive as password
            if (empty($_SESSION["USER"]) || empty($_SESSION["CURRENT_STAGE"]) || empty($_SESSION["PASS_BY_POS"])) break;
            if ($_SESSION["USER"]->user != $_POST["u"]) {
                session_unset();
                break;
            }
            if ($_SESSION["CURRENT_STAGE"] != $_POST["s"]) {
                session_unset();
                break;
            }

            if (!in_array($_SESSION["PASS_BY_POS"][$_POST["s"] - 1]["code"], $_SESSION["IMAGE_VALUES"]["img" . $_POST["p"]])) {
                session_unset();
                break;
            }
            unset($_SESSION["IMAGE_VALUES"]);
            $_SESSION["CURRENT_STAGE"] += 1;
            break;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
if (!empty($res)) $res->close();
if (!empty($db)) $db->close();
?>
