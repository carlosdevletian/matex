<?php 

namespace App\Filters;

use App\Models\Category;

class DesignFilters extends Filters
{
    protected $filters = ['category'];

    public function category($categorySlug)
    {
        if(! $category = Category::where('slug_name', $categorySlug)->first()) return $this->query;
        return $this->query->where('category_id', $category->id);
    }
}