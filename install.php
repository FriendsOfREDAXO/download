<?php

$addon = rex_addon::get('download');
if (!$addon->hasConfig()) {
    $addon->setConfig('send_as_http_file', false);
}
