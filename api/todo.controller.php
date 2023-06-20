<?php
require_once("todo.class.php");

class TodoController {
    private const PATH = __DIR__."/todo.json";
    private array $todos = [];

    public function __construct() {
        $content = file_get_contents(self::PATH);
        if ($content === false) {
            throw new Exception(self::PATH . " does not exist");
        }  
        $dataArray = json_decode($content);
        if (!json_last_error()) {
            foreach($dataArray as $data) {
                if (isset($data->id) && isset($data->title)) {
                    $this->todos[] = new Todo($data->id, $data->title, $data->description, $data->done);
                }
            }
        }
    }

    public function loadAll() : array {
        return $this->todos;
    }

    public function load(string $id) : Todo | bool {
        foreach($this->todos as $todo) {
            if ($todo->id == $id) {
                return $todo;
            }
        }
        return false;
    }

    public function create(Todo $todo): bool {
        $id = $todo->getId();
        $title = $todo->getTitle();
        $description = $todo->getDescription();    
        $done = $todo->isDone();
        $newTodo = new Todo($id, $title, $description, $done);
        $this->todos[] = $newTodo;
        return true;
    }

  public function update(string $id, Todo $todo): bool {
    foreach ($this->todos as $existingTodo) {
        if ($existingTodo->getId() === $id) {
            // Update the properties of the existing Todo with the new values
            $existingTodo->setTitle($todo->getTitle());
            $existingTodo->setDescription($todo->getDescription());
            $existingTodo->setDone($todo->isDone());

            return true;
        }
    }

    return false;
}

    public function delete(string $id): bool {
    foreach ($this->todos as $index => $todo) {
        if ($todo->getId() === $id) {
            unset($this->todos[$index]);
            $this->todos = array_values($this->todos);

            return true;
        }
    }

    return false;
}

    // add any additional functions you need below
}
