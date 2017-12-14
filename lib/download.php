<?php

/**
 * download Addon.
 *
 * @author Friends Of REDAXO
 *
 * @var rex_addon
 */
class DownloadUtility
{
    public static function getDownloadFile($filename = '', $rewrite = true)
    {
        // prevent path traversal
        $filename = basename($filename);
        
        if ($rewrite) {
            $link = rex_url::base() . download/'.$filename;
        } else {
            $link = 'index.php?download_utility=download&file='.$filename;
        }

        return $link;
    }

    public static function sendFile($filename)
    {

        // prevent errors
        error_reporting(0);
        @ini_set('display_errors', 0);

        $addon = rex_addon::get('download'); // fix until yrewrite includs subpags correctly

        if ($filename) {
            $file = strtolower(preg_replace("/[^a-zA-Z0-9.\-\$\+]/", '_', $filename));
            $file = urlencode(basename($filename));
            $fileWithPath = realpath(rex_path::media($file));

            if (file_exists($fileWithPath)) {

                // if activated, files will be send as X-Sendfile / X-Accel-Redirect
                if ($addon->getConfig('send_as_http_file')) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename='.$file);
                    header('Content-Length: '.filesize($fileWithPathRelative));

                    header('X-Sendfile: '.$fileWithPath); //  Apache webserver
                    header('X-Accel-Redirect: '.$fileWithPath); // Nginx webserver
                } else {
                    rex_response::sendFile($fileWithPath, $contenttype = 'application/octet-stream', $contentDisposition = 'attachment');
                }
                exit;
            }
        }
    }
}
