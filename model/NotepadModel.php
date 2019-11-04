<?php

class NotepadModel {
    private $note = '';

    function __construct() {
        
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }
}