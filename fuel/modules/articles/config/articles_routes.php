<?php 
$route[FUEL_ROUTE.'article_curl'] = 'articles/articles_module/curl';
$route[FUEL_ROUTE.'article_curl/(.*)'] = 'articles/articles_module/$1';

$route[FUEL_ROUTE.'articles/news'] = FUEL_FOLDER.'/module';
$route[FUEL_ROUTE.'articles/news/(.*)'] = FUEL_FOLDER.'/module/$1';