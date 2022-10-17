<?php

date_default_timezone_set( 'UTC' );

$arrContextOptions = array(
	"ssl" => array(
		"verify_peer"      => false,
		"verify_peer_name" => false,
	),
);

$key    = getenv( 'GOOGLEKEY' );
$result = json_decode( file_get_contents( "https://webfonts.googleapis.com/v1/webfonts?sort=ALPHA&fields=items.family,items.variants,items.subsets,items.category&key={$key}", false, stream_context_create( $arrContextOptions ) ) );
$fonts = [];
$gFile = dirname( __FILE__ ) . '/fonts.json';

foreach ( $result->items as $font ) {
    $fonts[ $font->family ] = array(
		"label" => $font->family,
		"variants" => $font->variants,
		"subsets" => $font->subsets,
		"category" => $font->category,
	);
}

$data = json_encode( $fonts );
file_put_contents( $gFile, $data );

echo "Saved new JSON\n\n";
