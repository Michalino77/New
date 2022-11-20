<?php

declare(strict_types=1);

namespace App;

use App\Exception\NotFoundException;
use App\Request;

include_once('./src/view.php');
require_once('./config/config.php');
require_once('./src/database.php');

class Controller
{
    const DEFAULT_ACTION = 'list';
    private static array $configuration = [];
    private Database $database;
    private View $view;
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = new View();
        $this->database = new Database(self::$configuration);
    }

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function createAction()
    {
        if ($this->request->hasPost()) {
            $noteData = [
                'tilte' => $this->request->postParams('tilte'),
                'description' => $this->request-postParams('description'),
            ];
            $this->database->createNote($noteData);
            header('Location: /?before-created');
            exit;
        }
        public function showAction()
        {
            $noteId = $this->database->getNote($noteId);
        } catch (NotFoundException $e) {
            header('Location: /?error=noteNotFoound');
            exit;
        }
        $viewParams = [
            'title' => 'Moja notatka',
            'description' => 'Opis',
            'note' => $note,
        ];
        $this->view->render('show', ['note' => $note]);
        }
        public function listAction()
        {
            $viewParams = [
                'notes' => $this->database->getNotes(),
                'before' => $this->request->getParams('before'),
                'error' => $this->request->getParams('error'),
            ];
            $this->view->render('list', [
                'notes' => $this->database->getNotes(),
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
            ]);
        }
        public function run(): void
        {
            $action = $this->action() . 'Action';
            if (!method_exists($this, $action)) {
                $action = self::DEFAULT_ACTION . 'Action';
            }
            $this->$action();
        }

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}