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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Developer Test</title>
    <link href="style.css" rel="stylesheet">
  </head>
  <body>
    <?php if ( $searchResults !== NULL ): ?>
        <?php if ( $searchResults->total > 0 ): ?>

            <div class="datagrid">
                <h1>Rotten Tomato Movie Search</h1>
                <h2>Search results for movies containing any of the following words: red, green, blue or yellow.</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Year</th>
                            <th>Runtime</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <div id="paging">
                                    <ul>
                                        <li><a href="#"><span>Previous</span></a></li>
                                        <li><a href="#" class="active"><span>1</span></a></li>
                                        <li><a href="#"><span>2</span></a></li>
                                        <li><a href="#"><span>3</span></a></li>
                                        <li><a href="#"><span>4</span></a></li>
                                        <li><a href="#"><span>5</span></a></li>
                                        <li><a href="#"><span>Next</span></a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $ctr = 0;
                            foreach( $searchResults->movies as $movie ): ?>
                        <tr <?php if ( $ctr++ % 2 == 1 ): ?>class="alt" <?php endif; ?> >
                            <td><?php echo $movie->title ?></td>
                            <td><?php echo $movie->year ?></td>
                            <td><?php echo $movie->runtime ?> minutes</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No results found</p>
        <?php endif; ?>
    <?php else: ?>
    <p>Error parsing json</p>
    <?php endif; ?>
  </body>
</html>