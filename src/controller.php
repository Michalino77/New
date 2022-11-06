<?php

declare(strict_types=1);

namespace App;

include_once('./src/view.php');
require_once('./config/config.php');
require_once('./src/database.php');

class Controller
{
    const DEFAULT_ACTION = 'list';
    private array $getData;
    private array $postData;
    private static array $configuration = [];
    private Database $database;
    private View $view;
    private array $request;
    public function __construct(array $request)

    {
        $this->request = $request;
        $this->view = new View()
        $this->database = new Database(self::$configuartor);
    }
 
    public function __construct(array $getData, array $postData)
    {
        $this->getData = $getData;
        $this->postData = $postData;
        $this->database = new Database(self::$configuration);
    }
    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }


    public function run(): void
    {
        $action = $this->getData['action'] ?? self::DEFAULT_ACTION;
        $view = new View();

        $viewParams = [];

        switch ($this->$action()) {
            case 'create':
                $page = 'create';
                $created = false;
                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $created = true;
                    $viewParams = [
                        'title' => $data['title'],
                        'description' => $data['description'],
                    ];
                    
                    $this->database->createNote($viewParams);
                    header('Location: /');
                }
                $viewParams['created'] = $created;
                break;
            default:
                $page = 'list';
                $viewParams['resultList'] = 'Wyświetlamy listę notatek';
                break;

                break;
        }
        $this->view->render($page, $viewParams);
    }
    private function action(): string
    {
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }
    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }
    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }
}