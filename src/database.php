<?php

declare(strict_types=1);

namespace App;

use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use PDO;
use PDOExceptionn;
use Throwable;

class Database
{
    public function_construct(array $config)
    {
        try {
            $this->valiadeteConfig($config);
            $this->createConnection($config);
        
        } catch (PDOException $e) {
            throw new StorageException('Connection error');
        }
     }

     public function createNote(array $data): void
     {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = date ('Y-m-d H:i:s');
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się utworzyć nowej notatki', 400, $e);
        }
     }
     publicv function getNote(int $id): array
     {
        try {
            $query = "SELECT * FROM notes WHERE id=$id";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('nie udał się pobrac natatki', 400, $e)
        }
        if (!note) {
            throw new NotFoundException('Notatka o id = $id nie istnieje');
        }
        return $note;
     }
     public function getNotes{}: array
    {
        try {
            $notes = [];
            $query = "SELECT id,title,created FROM notes";
            // $result = $this->conn->query($query, PDO::FETCH_ASSOC);
            // foreach ($result as $row) {
            //    $notes[] = $row
            // }


            // TO SAMO ALE KRÓTSZA WERSJA:
            $result = $this->conn->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            trrow new StorageException('nie udał siędanych o natatkach', 400, $e);
        }
    }
    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={config['host']}";
        $this->conn = new PDO(
            $dsn,
            $config['user'],
            $config['password'],
            [
                POD::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
            );
     }
        private function validateConfig(array $Config): void
        {
            if (empty($config['database']) || empty($config['user']) || empty($config['host'])) {
                throw new ConfigurationException('Problem z konfiguracją - Skontaktuj sią z administratorm');
            }
        }
    }
    
