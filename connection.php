<?php

function createPDO($environment = 'test') {
    $config = [
        'db_engine' => 'mysql',
        'db_host' => '127.0.0.1',
        'db_user' => 'root',
        'db_password' => '',
        'db_environment' => $environment,
    ];

    if ($config['db_environment'] === 'test') {
        $config['db_name'] = 'test_db';
    } else {
        $config['db_name'] = 'agile_db';
    }

    $db_config = $config['db_engine'] . ":host=".$config['db_host'] . ";dbname=" . $config['db_name'];

    try {
        $pdo = new PDO($db_config, $config['db_user'], $config['db_password'], [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ]);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {
        echo "Impossibile connettersi al database: " . $e->getMessage();
        exit();
    }

    return $pdo;
}
