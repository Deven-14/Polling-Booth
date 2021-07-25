<?php

define('AES_256_CBC', 'aes-256-cbc');
$encryption_key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';
$iv = 'eaiYYkYTysia21nH';

function encrypt($email) {
    $encrypted = openssl_encrypt($email, AES_256_CBC, $GLOBALS['encryption_key'], 0, $GLOBALS['iv']);
    $encrypted = $encrypted . ':' . base64_encode($GLOBALS['iv']);
    return $encrypted;
}

function decrypt($encrypted) {
    $parts = explode(':', $encrypted);
    $decrypted = openssl_decrypt($parts[0], AES_256_CBC, $GLOBALS['encryption_key'], 0, base64_decode($parts[1]));
    return $decrypted;
}