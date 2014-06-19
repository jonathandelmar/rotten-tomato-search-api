<?php
require 'config.php';
require 'RottenTomatoes.class.php';

$keywords = array(
    'red',
    //'green',
    //'blue',
    //'yellow',
);

$rottenTomatoObj = new RottenTomatoes( $rottenTomatoesConfig );
$searchResults = $rottenTomatoObj->search( implode( ' ', $keywords ) );

echo "<pre>";
var_dump( $searchResults );

// if ( $searchResults === NULL) die('Error parsing json');