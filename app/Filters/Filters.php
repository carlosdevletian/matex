<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request, $query;

    protected $filters = [];

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        $this->query = $query;
        
        foreach ($this->getFilters() as $filter => $value) {
            if(method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->query;
    }

    public function getFilters()
    {
        return $this->request->intersect($this->filters);
    }
}