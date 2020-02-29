#!/bin/sh
#fix to Lang files
if [ -d "resources/lang/" ]; then
    chown luciano:www-data -Rf resources/lang/
    chmod -Rf ug+w resources/lang/
    chmod -Rf o-w resources/lang/

    find resources/lang/ -type f -exec chmod -f ugo-x {} \;
    find resources/lang/ -type d -exec chmod -f ugo+x {} \;

    find resources/lang/ -type f -exec chmod -f g-s {} \;
    find resources/lang/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx resources/lang/
    setfacl -dR -m g::rwx resources/lang/
fi


#fix to Debugbar files
if [ -d "storage/debugbar/" ]; then
    chown luciano:www-data -Rf storage/debugbar/
    chmod -Rf ug+w storage/debugbar/
    chmod -Rf o-w storage/debugbar/

    find storage/debugbar/ -type f -exec chmod -f ugo-x {} \;
    find storage/debugbar/ -type d -exec chmod -f ugo+x {} \;

    find storage/debugbar/ -type f -exec chmod -f g-s {} \;
    find storage/debugbar/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx storage/debugbar/
    setfacl -dR -m g::rwx storage/debugbar/
fi


#fix to Monolog files
if [ -d "storage/logs/" ]; then
    chown luciano:www-data -Rf storage/logs/
    chmod -Rf ug+w storage/logs/
    chmod -Rf o-w storage/logs/

    find storage/logs/ -type f -exec chmod -f ugo-x {} \;
    find storage/logs/ -type d -exec chmod -f ugo+x {} \;

    find storage/logs/ -type f -exec chmod -f g-s {} \;
    find storage/logs/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx storage/logs/
    setfacl -dR -m g::rwx storage/logs/
fi


#fix to Bootstrap cache files
if [ -d "bootstrap/cache/" ]; then
    chgrp www-data -Rf bootstrap/cache/
    chmod -Rf ug+w bootstrap/cache/
    chmod -Rf o-w bootstrap/cache/

    find bootstrap/cache/ -type f -exec chmod -f ugo-x {} \;
    find bootstrap/cache/ -type d -exec chmod -f ugo+x {} \;

    find bootstrap/cache/ -type f -exec chmod -f g-s {} \;
    find bootstrap/cache/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx bootstrap/cache/
    setfacl -dR -m g::rwx bootstrap/cache/
fi

#fix to View cache files
if [ -d "storage/framework/views/" ]; then
    chgrp www-data -Rf storage/framework/views/
    chmod -Rf ug+w storage/framework/views/
    chmod -Rf o-w storage/framework/views/

    find storage/framework/views/ -type f -exec chmod -f ugo-x {} \;
    find storage/framework/views/ -type d -exec chmod -f ugo+x {} \;

    find storage/framework/views/ -type f -exec chmod -f g-s {} \;
    find storage/framework/views/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx storage/framework/views/
    setfacl -dR -m g::rwx storage/framework/views/
fi

#fix to Sessions files
if [ -d "storage/framework/sessions/" ]; then
    # Control will enter here if $DIRECTORY exists.
    chgrp www-data -Rf storage/framework/sessions/
    chmod -Rf ug+w storage/framework/sessions/
    chmod -Rf o-w storage/framework/sessions/

    find storage/framework/sessions/ -type f -exec chmod -f ugo-x {} \;
    find storage/framework/sessions/ -type d -exec chmod -f ugo+x {} \;

    find storage/framework/sessions/ -type f -exec chmod -f g-s {} \;
    find storage/framework/sessions/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx storage/framework/sessions/
    setfacl -dR -m g::rwx storage/framework/sessions/
fi

#fix to Cache files
if [ -d "storage/framework/cache/" ]; then
    # Control will enter here if $DIRECTORY exists.
    chgrp www-data -Rf storage/framework/cache/
    chmod -Rf ug+w storage/framework/cache/
    chmod -Rf o-w storage/framework/cache/

    find storage/framework/cache/ -type f -exec chmod -f ugo-x {} \;
    find storage/framework/cache/ -type d -exec chmod -f ugo+x {} \;

    find storage/framework/cache/ -type f -exec chmod -f g-s {} \;
    find storage/framework/cache/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx storage/framework/cache/
    setfacl -dR -m g::rwx storage/framework/cache/
fi

#fix to Doctrine proxy files
if [ -d "storage/proxies/" ]; then
    # Control will enter here if $DIRECTORY exists.
    chgrp www-data -Rf storage/proxies/
    chmod -Rf ug+w storage/proxies/
    chmod -Rf o-w storage/proxies/

    find storage/proxies/ -type f -exec chmod -f ugo-x {} \;
    find storage/proxies/ -type d -exec chmod -f ugo+x {} \;

    find storage/proxies/ -type f -exec chmod -f g-s {} \;
    find storage/proxies/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx storage/proxies/
    setfacl -dR -m g::rwx storage/proxies/
fi


#fix to unversioned files

if [ -d "resources/views/vendor/erpnetWidgetResource/unversioned/" ]; then
chmod -Rf ugo+w resources/views/vendor/erpnetWidgetResource/unversioned/
fi



#fix to aechitect filemanager files
if [ -d "public/" ]; then
    # Control will enter here if $DIRECTORY exists.
    chgrp www-data -Rf public/
    chmod -Rf ug+w public/
    chmod -Rf o-w public/

    find public/ -type f -exec chmod -f ugo-x {} \;
    find public/ -type d -exec chmod -f ugo+x {} \;

    find public/ -type f -exec chmod -f g-s {} \;
    find public/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx public/
    setfacl -dR -m g::rwx public/
fi

#fix to crudbooster  files
if [ -d "storage/app/" ]; then
    # Control will enter here if $DIRECTORY exists.
    chgrp www-data -Rf storage/app/
    chmod -Rf ug+w storage/app/
    chmod -Rf o-w storage/app/

    find storage/app/ -type f -exec chmod -f ugo-x {} \;
    find storage/app/ -type d -exec chmod -f ugo+x {} \;

    find storage/app/ -type f -exec chmod -f g-s {} \;
    find storage/app/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx storage/app/
    setfacl -dR -m g::rwx storage/app/
fi

#fix to crudbooster  files
if [ -d "app/Http/" ]; then
    # Control will enter here if $DIRECTORY exists.
    chgrp www-data -Rf app/Http/
    chmod -Rf ug+w app/Http/
    chmod -Rf o-w app/Http/

    find app/Http/ -type f -exec chmod -f ugo-x {} \;
    find app/Http/ -type d -exec chmod -f ugo+x {} \;

    find app/Http/ -type f -exec chmod -f g-s {} \;
    find app/Http/ -type d -exec chmod -f g+s {} \;

    setfacl -dR -m u::rwx app/Http/
    setfacl -dR -m g::rwx app/Http/
fi
