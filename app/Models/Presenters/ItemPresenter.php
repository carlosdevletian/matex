<?php

namespace App\Models\Presenters;

class ItemPresenter extends Presenter
{
    public function total_price()
    {
        $total = $this->model->total_price / 100;
        return $this->presentAsDollars($total);
    }

    public function unit_price()
    {
        $unit = $this->model->unit_price / 100;
        return $this->presentAsDollars($unit);
    }
}
