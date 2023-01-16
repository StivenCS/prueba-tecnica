<?php

namespace App\Repository\Category;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface {

    public function get(){
        return Category::all();
    }

    public function getCategories()
    {

    }
}
