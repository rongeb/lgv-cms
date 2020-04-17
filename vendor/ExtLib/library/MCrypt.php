<?php

namespace ExtLib;

use ExtLib\MCryptConst;

class MCrypt {

    function __construct() {
        
    }

 //   https://stackoverflow.com/questions/41272257/mcrypt-is-deprecated-what-is-the-alternative
    public function encrypt($message)
    {
        $key = MCryptConst::$key;
        if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length(MCryptConst::$METHODAES256);
        $iv = openssl_random_pseudo_bytes($ivsize);

        $ciphertext = openssl_encrypt(
            $message,
            MCryptConst::$METHODAES256,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return $iv . $ciphertext;
    }

    public function decrypt($message)
    {
        $key = MCryptConst::$key;
        if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length(MCryptConst::$METHODAES256);
        $iv = mb_substr($message, 0, $ivsize, '8bit');
        $ciphertext = mb_substr($message, $ivsize, null, '8bit');

        return openssl_decrypt(
            $ciphertext,
            MCryptConst::$METHODAES256,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }

}