Download Utility
----------------

Dieses AddOn schickt eine beliebige Datei aus dem Medienpool als Force-Download in den Browser.
Damit das AddOn funktioniert, muss folgende Zeile in die .htaccess:
<br>
```htaccess
# REWRITE RULE FOR SEO FRIENDLY DOWNLOAD URLS
RewriteRule ^download[s]?/([^/]*) index.php?download_utility=download&file=$1 [NC,L]
```

Platzier es bitte über oder unter (die Zeile gibt es nur, wenn du die YRewrite .htaccess nutzt)
```
# REWRITE RULE FOR SEO FRIENDLY IMAGE MANAGER URLS
```


Falls du `nginx` nutzt, musst du folgendes in deine Config packen:<br>
```htaccess
rewrite ^/download[s]?/([^/]*) /index.php?download_utility=download&file=$1 last;
```

Wie komm ich an die Downloadlinks?
---------------------------------------

```php
<?php
    echo DownloadUtility::getDownloadFile($filename = '', $rewrite = true);

    // Ausgabe: /download/dateiname.jpg
    // Falls rewrite auf false steht: index.php?download_utility=download&file=dateiname.jpg
?>
```

X-Send was???
---------------

Wenn dir

* X-SendFile
* X-Accel-Redirect

keine Begriffe sind, solltest du die Einstellung nicht aktivieren, denn der Download wird höchstwahrscheinlich nicht funktionieren. X-Send ist ein Apache / nginx / Lighttpd Mod, um (große) Dateien direkt über den Server abzuwickeln. Dieses Modul ist normalerweise nirgendswo per Default aktiv und nur für spezielle Umgebungen gedacht. Falls du dich damit auskennst und sicher bist, dass die Module aktiv sind, kannst du die Checkbox aktivieren, ansonsten lass sie bitte deaktiviert. Im deaktivierten Zustand werden die Dateien wie gewohnt über PHP ausgeliefert.


Falls die Mods installiert sind, muss folgendes in deine .htaccess (oder Apache/Nginx Conf):

```
XSendFile On
XSendFilePath /absoluter/pfad/bis/media
```

Settingspage
------------
Die Settingspage integriert sich als Tab-Reiter innerhalb des AddOns `Media Manager` mit dem Titel "Download".

Installation
------------
Hinweis: dies ist kein Plugin!

* Release herunterladen und entpacken.
* Ordner umbenennen in `download`.
* In den Addons-Ordner legen: `/redaxo/src/addons`.

Oder den REDAXO-Installer / ZIP-Upload AddOn nutzen!

Voraussetzungen
------------

* media_manager AddOn
* mod_rewrite, falls die htaccess Lösung genutzt werden soll
