#!/usr/bin/env php
<?php
$token          = @file_get_contents('/var/lib/jenkins/AUTH_TOKEN');;
$user           = getenv('U');
$password       = getenv('P');

if(!auth_verify_master($token, $user, $password)){
  exit(1);
}

function auth_verify_master($token, $user, $pass)
{
    $post = http_build_query(
        array(
            'token'     => $token,
            'username'  => $user,
            'password'  => $pass,
        )
    );

    $opts = array(
        'method'        => 'POST',
        'header'        => 'Content-type: application/x-www-form-urlencoded',
        'content'       => $post,
    );

    $ctx = stream_context_create(array('http' => $opts));

    $s = file_get_contents('https://master.php.net/fetch/cvsauth.php', false, $ctx);

    $a = @unserialize($s);
    if (!is_array($a)) {
        return false;
    }
    if (isset($a['errno'])) {
        return false;
    }

    return true;
}

