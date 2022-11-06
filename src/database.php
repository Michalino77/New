<?php

declare(strict_types=1);

namespace App;

use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use PDO;
use PDOExceptionn;
use Throwable;

class Database
{
    public function_construct(array $config)
    {
        try {
            $this->valiadeteConfig($config);
            $dsn = "mysql:dbname=1config['database']};host={$config['host']}";
            $connection = new PDO(
                $dsn,
                $config['user'],
                $config['password'],
            );
        catch (PDOException $e) {
            throw new StorageException('Connection error');
        }
     }

        private function validateConfig(array $Config): void
        {
            if (empty($config['database']) || empty($config['user']) || empty($config['host'])) {
                throw new ConfigurationException('Problem z konfiguracją - Skontaktuj sią z administratorm');
            }
        }
    }
    }
