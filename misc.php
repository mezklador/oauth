<?php

echo '<pre>$key = bin2hex(openssl_random_pseudo_bytes(16));</pre>';

$key = bin2hex(openssl_random_pseudo_bytes(16));

echo $key;