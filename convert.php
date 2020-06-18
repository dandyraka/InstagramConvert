<?php

function convert($var){
    $alphabet   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
    $url_prefix = 'https://www.instagram.com/p/';
    $url_suffix = '';
    $media_id   = 0;

    if (preg_match('/_/', $var)) {
        $parts      = explode('_', $var);
        $media_id   = $parts[0];
        $user_id    = $parts[1];

        if (is_numeric($media_id) && is_numeric($user_id)) {
            $type   = 'media_id';
        } else {
            $type   = 'shortcode';
        }
    } else {
        $type       = 'shortcode';
    }

    if ($type == 'media_id') {
        while ($media_id > 0) {
            $remainder  = $media_id % 64;
            $media_id   = ($media_id - $remainder) / 64;
            $url_suffix = $alphabet{$remainder} . $url_suffix;
        }
        return $url_prefix . $url_suffix;
    } else {
        foreach (str_split($var) as $letter) {
            $media_id   = ($media_id * 64) + strpos($alphabet, $letter);
        }
        return $media_id;
    }
}

echo convert("zhxXFsMnfn"); //Shortcode
echo "\n";
echo convert("928240089152255975_204353228"); //Media_ID
