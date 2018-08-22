rm -rf storage/testing.db
touch storage/testing.db
php artisan migrate --env=testing
php artisan db:seed --env=testing --class=TestDatabaseSeeder
vendor/bin/phpunit

