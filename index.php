<?php
/**
 * Class RottenTomatoes
 *
 * Use for Rotten Tomato API transactions
 */
class RottenTomatoes
{
    var $apiKey = null;
    var $url = array();

    public function __construct( array $config )
    {
        $this->apiKey = $config['apikey'];
        $this->url = $config['url'];
    }

    public function search( $query )
    {
        $searchUrl = $this->url['search'] . '?apikey=' . $this->apiKey . '&q=' . urlencode( $query );
        return $this->call( $searchUrl );
    }

    protected function call( $url )
    {
        $session = curl_init( $url );
        curl_setopt( $session, CURLOPT_RETURNTRANSFER, true );
        $data = curl_exec( $session );
        curl_close( $session );

        return json_decode( $data );
    }
}

// Rotten Tomato configurations
$rottenTomatoesConfig = array(
    'apikey' => 'yfxz59zsaq3a5h3y85ej7mj6',
    'url' => array(
        'search' => 'http://api.rottentomatoes.com/api/public/v1.0/movies.json'
    )
);

// predefined search keywords
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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Developer Test</title>
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <h1>Hello, world!</h1>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>