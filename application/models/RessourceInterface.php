<?php

interface Application_Model_RessourceInterface
{
    public function getList();

    public function get($id);

    public function add($obj);

    public function update($id, $obj);

    public function delete($id);
}

