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
    
    public function create (Todo $newTodo): bool {
        $this->todos[] = $newTodo;
        file_put_contents( filename: self: :PATH, json_encode($this-›todos));
        return true;
    }

    public function update (string $id, Todo $todo): bool {
        foreach ($this->todos as $existingTodo) {
            if ($existingTodo->id == $id) {
                // Update the properties of the existing Todo with the new values
                $existingTodo-›title = $todo-›title;
                $existingTodo->description = $todo->description;
                $existingTodo->done = $todo->done;
                file_put_contents( filename: self: :PATH, json_encode($this->todos));
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
