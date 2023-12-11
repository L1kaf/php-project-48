### Hexlet tests and linter status:
[![Actions Status](https://github.com/L1kaf/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/L1kaf/php-project-48/actions)
[![PHP tests and linter](https://github.com/L1kaf/php-project-48/actions/workflows/main.yml/badge.svg)](https://github.com/L1kaf/php-project-48/actions/workflows/main.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/4c02be82f8b17fb4971b/maintainability)](https://codeclimate.com/github/L1kaf/php-project-48/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/4c02be82f8b17fb4971b/test_coverage)](https://codeclimate.com/github/L1kaf/php-project-48/test_coverage)

### Description:
---
This repository contains the realization of the second project of the Hexlet learning portal: Difference Calculator! 

A difference calculator is a program that determines the difference between two data structures. This is a popular task for which there are many online services, for example: http://www.jsondiff.com/. Such a mechanism is used when outputting tests or when automatically tracking changes in configuration files.

Utility features:

* Support for different input formats: yaml and json
* Report generation in plain text, stylish and json formats

Translated with DeepL.com (free version)
### System Requirements:
---
* OS Windows/Linux;
* PHP version 7+.

### Installation and startup:
---
* For installation, a Makefile with the install command is used, executing the composer install command: `make install`.
* To compare files, you must enter the `gendiff` command and then specify two files.
* The --format option allows you to select the format of the report.
* The -h option shows a hint.
* The -v option shows the program version.

### Asciinema recordings:
---
* [Gendiff comparing json files](https://asciinema.org/a/TuYQMb9vEzw1l5tz9VzDp8DWI)
* [Gendiff comparing yaml files](https://asciinema.org/a/GzC4jKF5sE5k1CNkfEXhHOcU8)
* [Gendiff comparing json files, format "stylish"](https://asciinema.org/a/q7FntXeY2rvZNot5OTCscpbTP)
* [Gendiff comparing json files, format "plain"](https://asciinema.org/a/UuGQg3A1g9NTYjc3514QemP62)