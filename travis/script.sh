#!/usr/bin/env bash

set -e

vendor/bin/phpunit --configuration phpunit.ci.xml --coverage-clover clover.xml
