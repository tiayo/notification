<?php

namespace App\Repositories;

use App\Accounting;
use Illuminate\Support\Facades\Auth;

class AccountRepositeries
{
    protected $account;

    public function __construct(Accounting $accounting)
    {
        $this->account = $accounting;
    }

    public function create($data)
    {
        return $this->account->create($data);
    }

    public function getUserId($page, $num)
    {
        return $this->account
            ->skip(($page-1) * $num)
            ->take($num)
            ->where('user_id', Auth::id())
            ->orderBy('accounting_id', 'desc')
            ->get();
    }

    public function count()
    {
        return $this->account
            ->where('user_id', Auth::id())
            ->count();
    }

    public function destroy($id)
    {
        return $this->account
            ->where('accounting_id', $id)
            ->delete();
    }

    public function findId($id)
    {
        return $this->account->find($id);
    }

    public function findIdSelect($id, $select)
    {
        return $this->account
            ->select($select)
            ->where('accounting_id', $id)
            ->first();
    }

    public function update($id, $data)
    {
        return $this->account
            ->where('accounting_id', $id)
            ->update($data);
    }

    public function findByTimeGetMoney($start_time, $end_time)
    {
        return $this->account
            ->select('money')
            ->where('time', '>=', $start_time)
            ->where('time', '<=', $end_time)
            ->where('status', 1)
            ->get();
    }
}