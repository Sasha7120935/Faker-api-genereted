<?php
function processArray( $data, $level = 0 ) {
    $level++;
    $arr = [];
    if ( ! is_array( $data ) ) {
        $arr[] = $data;
    }
    foreach ( $data as $arrayItem ) {
        $arr = array_merge( $arr, processArray( $arrayItem, $level ) );
    }
    return  $arr;
}
function get_file_name(){
   return 'data';
}
function link_file( $filename ){
    return '<br>' . '<a href='.$filename.' download="data">Download File</a>';
}
function generator_file ( $type, $language, $number, $format, $data ) {
    if ( $type || $language || $number ) {
        if ( $format === 'txt' ) {
            $data = json_decode( $data, true );
            $filename = get_file_name() . '.' . $format;
            $processArray = processArray( $data );
            echo '<pre>';
            print_r( $processArray );
            echo '</pre>';
            $file = file_put_contents( $filename, $processArray );
        } elseif ( $format === 'csv' ) {
            $filename = get_file_name() . '.' . $format;
            $data = json_decode( $data, true );
            $processArray = processArray( $data );
            echo '<pre>';
            print_r( $processArray );
            echo '</pre>';
            $file = file_put_contents( $filename, $processArray );

        } else {
            $filename = get_file_name() . '.' . $format;
            $json = preg_replace('/[[:cntrl:]]/', '', $data);
            file_put_contents( $filename, json_encode( $json ) );
            $file = file_get_contents( $filename );
            echo $file;
        }
        echo link_file( $filename );
        unset( $file );
    }
}
function get_file(){
    $type = $_POST['type'];
    $language = $_POST['language'];
    $number = $_POST['number'];
    $format = $_POST['format'];
    $data = file_get_contents('https://fakerapi.it/api/v1/' . $type . '?_locale=' . $language . '&_quantity=' . $number );
    generator_file( $type, $language, $number, $format, $data );
}