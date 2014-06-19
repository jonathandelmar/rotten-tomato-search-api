<?php
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