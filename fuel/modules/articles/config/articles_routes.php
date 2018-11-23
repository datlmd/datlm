<?php 
//$route[FUEL_ROUTE.'articles'] = 'articles';
$route[FUEL_ROUTE.'articles/news'] = FUEL_FOLDER.'/module';
$route[FUEL_ROUTE.'articles/news/(.*)'] = FUEL_FOLDER.'/module/$1';