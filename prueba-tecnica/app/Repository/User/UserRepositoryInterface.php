<?php

namespace App\Repository\User;

interface UserRepositoryInterface
{
    public function all();
    public function store($data);
    public function update($id,$data);
    public function delete($id);
    public function get($id);
    public function getReport();
}
