<?php

/**
 *
 */
defined( 'SQLITE_PATH' ) or define ( 'SQLITE_PATH', '/path/to/your/sqlite/db/folder' );

/**
 *
 */
defined( 'DB_NAME' ) or define( 'DB_NAME', 'database_name' );

/**
 * depricated as of 1/16/2010
 */
defined( 'CACHING_FOR' ) or define( 'CACHING_FOR', 604800 ); // setting caching for a week

/**
 *
 */
defined('YII_DEBUG') or define('YII_DEBUG',true);


/**
 *
 */
defined('TMDB_API_KEY') or define( 'TMDB_API_KEY', 'your tmdb API key' );

/**
 *
 */
defined( 'TMDB_LIST_JSON_PATH' ) or define( 'TMDB_LIST_JSON_PATH', 'http://api.themoviedb.org/2.1/Movie.search/en/json/' );

/**
 *
 */
defined( 'TMDB_LIST_XML_PATH' ) or define( 'TMDB_LIST_XML_PATH', 'http://api.themoviedb.org/2.1/Movie.search/en/xml/' );

/**
 *
 */
defined( 'IMDB_XML_PATH' ) or define( 'IMDB_XML_PATH','http://api.themoviedb.org/2.1/Movie.imdbLookup/en/xml/' );

/**
 *
 */
defined( 'IMDB_JSON_PATH' ) or define( 'IMDB_JSON_PATH','http://api.themoviedb.org/2.1/Movie.imdbLookup/en/json/' );

/**
 *
 */
defined( 'TMDB_XML_INFO' ) or define( 'TMDB_XML_INFO', 'http://api.themoviedb.org/2.1/Movie.getInfo/en/xml/' );

/**
 *
 */
defined( 'TMDB_JSON_INFO' ) or define( 'TMDB_JSON_INFO', 'http://api.themoviedb.org/2.1/Movie.getInfo/en/json/' );