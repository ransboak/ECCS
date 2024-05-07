<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_ORA_TNS', ''),
        'host'           => env('DB_ORA_HOST', ''),
        'port'           => env('DB_ORA_PORT', '1521'),
        'database'       => env('DB_ORA_DATABASE', ''),
        'service_name'   => env('DB_ORA_SERVICE_NAME', ''),
        'username'       => env('DB_ORA_USERNAME', ''),
        'password'       => env('DB_ORA_PASSWORD', ''),
        'charset'        => env('DB_ORA_CHARSET', 'AL32UTF8'),
      //  'charset'        => env('DB_CHARSET', 'utf8mb4'),
       // 'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
        'prefix'         => env('DB_ORA_PREFIX', ''),
        'prefix_schema'  => env('DB_ORA_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_ORA_EDITION', 'ora$base'),
        'server_version' => env('DB_ORA_SERVER_VERSION', '11g'),
        'load_balance'   => env('DB_ORA_LOAD_BALANCE', 'yes'),
        'dynamic'        => [],
        'grammar' => [
            'query' =>  Yajra\Oci8\Query\Grammars\OracleGrammar::class,
            'schema' => Yajra\Oci8\Schema\Grammars\OracleGrammar::class,
        ],
    ],
    'sessionVars' => [
        'NLS_TIME_FORMAT'         => 'HH24:MI:SS',
        'NLS_DATE_FORMAT'         => 'YYYY-MM-DD HH24:MI:SS',
        'NLS_TIMESTAMP_FORMAT'    => 'YYYY-MM-DD HH24:MI:SS',
        'NLS_TIMESTAMP_TZ_FORMAT' => 'YYYY-MM-DD HH24:MI:SS TZH:TZM',
        'NLS_NUMERIC_CHARACTERS'  => '.,',
    ],





    'oracle_db' => [
        'driver'         => 'oracle_db',
        'tns'            => env('DB_ORA_TNS', ''),
        'host'           => env('DB_ORA_HOST', ''),
        'port'           => env('DB_ORA_PORT', '1521'),
        'database'       => env('DB_ORA_DATABASE', ''),
        'service_name'   => env('DB_ORA_SERVICE_NAME', ''),
        'username'       => env('DB_ORA_USERNAME', ''),
        'password'       => env('DB_ORA_PASSWORD', ''),
        'charset'        => env('DB_ORA_CHARSET', 'AL32UTF8'),
      //  'charset'        => env('DB_CHARSET', 'utf8mb4'),
       // 'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
        'prefix'         => env('DB_ORA_PREFIX', ''),
        'prefix_schema'  => env('DB_ORA_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_ORA_EDITION', 'ora$base'),
        'server_version' => env('DB_ORA_SERVER_VERSION', '11g'),
        'load_balance'   => env('DB_ORA_LOAD_BALANCE', 'yes'),
        'dynamic'        => [],
        'grammar' => [
            'query' =>  Yajra\Oci8\Query\Grammars\OracleGrammar::class,
            'schema' => Yajra\Oci8\Schema\Grammars\OracleGrammar::class,
        ],
    ],
    'sessionVars' => [
        'NLS_TIME_FORMAT'         => 'HH24:MI:SS',
        'NLS_DATE_FORMAT'         => 'YYYY-MM-DD HH24:MI:SS',
        'NLS_TIMESTAMP_FORMAT'    => 'YYYY-MM-DD HH24:MI:SS',
        'NLS_TIMESTAMP_TZ_FORMAT' => 'YYYY-MM-DD HH24:MI:SS TZH:TZM',
        'NLS_NUMERIC_CHARACTERS'  => '.,',
    ],

];
