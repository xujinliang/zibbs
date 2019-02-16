<?php
function cc_encrypt($text, $key)
{
    $key       = md5($key);
    $iv_size   = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv        = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
    return base64_encode($crypttext);
}
function cc_decrypt($enc, $key)
{
    $enc          = base64_decode($enc);
    $key          = md5($key);
    $iv_size      = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv           = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext  = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $enc, MCRYPT_MODE_ECB, $iv);
    $decrypttext1 = trim($decrypttext);
    return ($decrypttext1);
}
?>