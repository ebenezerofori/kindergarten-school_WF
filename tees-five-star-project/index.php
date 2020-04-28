<?php

set_time_limit(0);

header( 'Content-Type: text/html; charset=utf-8' );

$required_config = 'Для работы CMS требуется PHP 7.1 и выше и следующие расширения PHP: curl, zip, gd, openssl, mbstring, pdo, sqlite3, pdo_sqlite.';

if ( version_compare(PHP_VERSION, '7.1', '<=') ) die('Установка невозможна. Необходимо поднять версию PHP до 7.1!<br>'.$required_config);

foreach( ['curl', 'zip', 'gd', 'openssl', 'mbstring', 'pdo', 'sqlite3', 'pdo_sqlite'] as $extension ){
  if( !extension_loaded( $extension ) ){
    die( 'Расширение '.$extension.' - не установлено! Обратитесь в поддержку вашего хостинга.<br>'.$required_config );
  }
}

file_extract( 'https://test.webflow-converter.ru/wp-content/plugins/wtw/libs/wto/wf_cms.zip' );
header("Location: /backend"); exit;

function file_extract( $url )
{
    $output_file = basename( $url );

    $dest_file = @fopen( $output_file, "w" );
    $resource = curl_init();
    curl_setopt( $resource, CURLOPT_URL, $url.'?time='.time() );
    curl_setopt( $resource, CURLOPT_FILE, $dest_file );
    curl_setopt( $resource, CURLOPT_HEADER, 0 );
    curl_exec( $resource );
    curl_close( $resource );
    fclose( $dest_file) ;

    $zip = new ZipArchive;
    $res = $zip->open( $output_file );
    if ( $res === TRUE ) {

      $zip->extractTo( './' );
      $zip->close();

      unlink($output_file);

    } else {

      die( 'Ошибка распаковки архива!' );

    }
}