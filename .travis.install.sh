set -x

composer self-update
composer clear-cache
composer update --ignore-platform-reqs

if [ "$DEPENDENCIES" = 'low' ] ; then
    composer update --prefer-lowest --prefer-stable
fi
