# Sainsbury's Technical Test
## Installation
### Clone and install dependencies
```
git clone https://github.com/MichaelKing0/SainsburysScraper
cd SainsburysScraper
composer install
```
## Usage
### Scrape a page
Basic usage
```
php console.php app:scrape [--prettyPrint] url
```
Example:
```
php console.php app:scrape http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html
```
With pretty printed output:
```
php console.php app:scrape --prettyPrint=1 http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html
```
### Run tests
```
./vendor/bin/phpunit
```