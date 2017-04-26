<?php 

namespace App\Filters;

use App\Models\Category;

class DesignFilters extends Filters
{
    protected $filters = ['category', 'date'];

    public function category($categorySlug)
    {
        if(! $category = Category::where('slug_name', $categorySlug)->first()) return $this->query;
        return $this->query->where('category_id', $category->id);
    }

    public function date($order = 'desc')
    {
        $this->query->getQuery()->orders = [];
        return $this->query->orderBy('created_at', $order);
    }
}