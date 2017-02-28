<?php

/**
 * download Addon.
 *
 * @author Friends Of REDAXO
 *
 * @var rex_addon
 */

if (!rex::isBackend()) {
    if(rex_request('download_utility', 'string', false) && rex_request('file', 'string', false)) {
        DownloadUtility::sendFile(rex_request('file', 'string'));
    }
}
