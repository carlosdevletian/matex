<?php 

namespace App\Filters;

use App\Models\User;
use App\Models\Status;

class OrderFilters extends Filters
{
    protected $filters = ['status', 'client', 'active'];

    public function status($statusId)
    {
        $status = Status::findOrFail($statusId);
        return $this->query->where('status_id', $statusId);
    }

    public function client($email)
    {
        if(! admin()) return $this->query;
        if($userId = User::where('email', $email)->firstOrFail()->id) {
            return $this->query->where('user_id', $userId);
        }
    }

    public function active()
    {
        return $this->query->with('status')->whereIn('status_id', [1,2,3,4]);
    }
}