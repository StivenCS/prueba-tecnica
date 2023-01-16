<?php

namespace App\Http\Controllers;

use App\Repository\Category\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories(){
        return $this->categoryRepository->get();
    }
}
