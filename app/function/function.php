<?php 

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Consts;
// Mở composer.json
// Thêm vào trong "autoload" chuỗi sau
// "files": [
//    "app/function/function.php"
// ]

// Chạy cmd : composer  dumpautoload

function startsWith($haystack, $needle)
	{
	     $length = strlen($needle);
	     return (substr($haystack, 0, $length) === $needle);
	}

function convertStringToNumber($value)
    {
        return $value == 'Yes' ? 1 : 0;
    }

 ?>
