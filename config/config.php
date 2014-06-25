<?php

// RDBMS: mysql|SQLite|PostgreSQL|Oracle
$_ENV['W']['RDBMS'] = "mysql";

// RDBMS host
$_ENV['W']['host'] = "localhost";

// Database name
$_ENV['W']['database'] = "bamboo";

// Database connexion user name
$_ENV['W']['name'] = "root";

// Database connexion password
$_ENV['W']['password'] = "vagrant";

// Base url:
$_ENV['W']['base_url'] = "http://localhost:8181/bamboo-project/app/www/";

// Templating language: haml|smarty|twig|php
$_ENV['W']['templating'] = "twig";

// Environment: development|production
$_ENV['W']['environment'] = "development";

// I18n: default|user-value
$_ENV['W']['language'] = "default";
