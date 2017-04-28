<?php

namespace App\Models\Presenters;

class OrderPresenter extends Presenter
{
    public function total()
    {
        $total = $this->model->total / 100;
        return $this->presentAsDollars($total);
    }

    public function subtotal()
    {
        $subtotal = $this->model->subtotal / 100;
        return $this->presentAsDollars($subtotal);
    }

    public function tax()
    {
        $tax = $this->model->tax / 100;
        return $this->presentAsDollars($tax);
    }

    public function shipping()
    {
        $shipping = $this->model->shipping / 100;
        return $this->presentAsDollars($shipping);
    }
}
