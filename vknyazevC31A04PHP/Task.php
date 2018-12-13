<?php
class Task
{
    private $id;
    private $title;
    private $description;
    private $status;
    private $dateCreated;
    private $dateUpdated;
    private $saved = false;
    function __construct(int $id)
    {
        if ($id < 0) {
            $currId = file_get_contents("List/counter.txt");
            $this->id = $currId;
            file_put_contents("List/counter.txt", $currId + 1);
            $this->dateCreated = date_timestamp_get(date_create());
            $this->dateUpdated = $this->dateCreated;
        } else {
            foreach (json_decode(file_get_contents("./List/Tasks.json")) as $task) {
               if ($task->id == $id) {
                $this->id = $id;
                $this->title = $task->title;
                $this->description = $task->description;
                $this->status = $task->status;
                $this->dateCreated = $task->dateCreated;
                $this->dateUpdated = $task->dateUpdated; 
                $this->saved = true;
               }
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getDateCreated()
    {
        return $dateCreated;
    }
    public function setDateCreated(int $dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    public function getDateUpdated()
    {
        return $dateUpdated;
    }
    public function setDateUpdated(int $dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription(string $description)
    {
        if ($description != $this->description)
            $this->dateUpdated = date_timestamp_get(date_create());
            
        $this->description = $description;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle(string $title)
    {
        if ($title != $this->title)
            $this->dateUpdated = date_timestamp_get(date_create());
        $this->title = $title;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus(int $status)
    {
        if ($status != $this->status)
            $this->dateUpdated = date_timestamp_get(date_create());
        $this->status = $status;
    }

    public function getAll() {
        return array(
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "status" => $this->status,
            "dateCreated" => $this->dateCreated, 
            "dateUpdated" => $this->dateUpdated 
        );
    }
    public function save() {
        $tasks = array_filter(json_decode(file_get_contents("./List/Tasks.json"), false), function ($el) {
            return $el->id != $this->id;
        });
        array_unshift($tasks, $this->getAll());
        file_put_contents("List/Tasks.json", json_encode(array_values($tasks)));
        $this->saved = true;
    }
}

?>