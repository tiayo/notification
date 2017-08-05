<?php

namespace App\Repositories;

use App\Accounting;
use App\AccountingSetup;
use Illuminate\Support\Facades\Auth;

class AccountSetupRepository
{
    protected $account_setup;

    public function __construct(AccountingSetup $account_setup)
    {
        $this->account_setup = $account_setup;
    }

    public function create($data)
    {
        return $this->account_setup->create($data);
    }

    public function getUserId($page, $num)
    {
        return $this->account_setup
            ->skip(($page-1) * $num)
            ->take($num)
            ->where('user_id', Auth::id())
            ->orderBy('accounting_id', 'desc')
            ->get();
    }

    public function count()
    {
        return $this->account_setup
            ->where('user_id', Auth::id())
            ->count();
    }

    public function destroy($id)
    {
        return $this->account_setup
            ->where('accounting_id', $id)
            ->delete();
    }

    public function current()
    {
        return $this->account_setup
            ->where('user_id', Auth::id())
            ->first();
    }

    public function update($id, $data)
    {
        return $this->account_setup
            ->where('user_id', $id)
            ->update($data);
    }
}