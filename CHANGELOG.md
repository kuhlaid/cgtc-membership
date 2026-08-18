# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-08-18

- [x] removing Facebook PHP SDK since it is deprecated and not longer working
- [x] it does not look as though we are using the `google-api-javascript` code so removing that
- [x] installing composer locally using `sudo apt install composer` and then running `composer require vlucas/phpdotenv` to install the Dotenv package within the application since it is needed to read environment variables from a `.env` file 
- [x] updating .htaccess file to hide the .env file
- [x] removing hard-coded references to domain and subdirectory so it is more portable
- [x] need to convert hard-coded text for membership renewal notices, etc. to a template (`text-templates.php`)
- [x] remove other hard-coded text that should be more portable

## [0.0.1] - 2026-08-17

- [x] testing this repository on the host to understand the versioning process
