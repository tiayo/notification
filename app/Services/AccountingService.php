<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Repositories\AccountSetupRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingService
{
    protected $account;
    protected $client;
    protected $account_setup;
    protected $request;

    public function __construct(AccountRepository $accounting, AccountSetupRepository $account_setup, Request $request)
    {
        $this->account = $accounting;
        $this->account_setup = $account_setup;
        $this->request = $request;
        $this->client = new Client();
    }

    public function createOrUpdate($post, $id, $type)
    {
        //构造数组
        $map['title'] = $post['title'];
        $map['user_id'] = Auth::id();
        $map['type'] = $post['type'];
        $map['money'] = sprintf("%.2f", $post['money']);
        $map['time'] = $post['time'];

        //生成地址
        if (empty($post['location'])) {
            $ak = config('site.baidu_ak');
            $response = $this->client->get('https://api.map.baidu.com/location/ip?ak='.$ak.'&coor=bd09ll&ip='.$this->request->getClientIp().'');
            $location = json_decode($response->getBody()->getContents())->content->address ?? null;
            $map['location'] = $location;
        } else {
            $map['location'] = $post['location'];
        }

        //备注
        if (!empty($post['remark'])) {
            $map['remark'] = $post['remark'];
        }

        if (!empty($id) && $type == 'update') {
            return $this->account->update($id, $map);
        }

        return $this->account->create($map);
    }

    public function show($page, $num)
    {
        return $this->account->getUserId($page, $num);
    }

    public function count()
    {
        return $this->account->count();
    }

    public function destroy($id)
    {
        $this->account->destroy($id);
    }

    public function findId($id)
    {
        return $this->account->findId($id);
    }

    public function getSetup()
    {
        return $this->account_setup->current();
    }

    public function setup($post)
    {
        $status = $post['status'];
        $type = $post['type'];

        $map['budget'] = $post['budget'];
        $map['type'] = $type;

        if ($type == 0) {
            $map['cycle'] = $post['cycle'];
        }

        if ($status == 0) {
            $map['user_id'] = Auth::id();

            return $this->account_setup->create($map);
        }

        return $this->account_setup->update(Auth::id(), $map);

    }

    public function statistics()
    {
        $setup = $this->account_setup->current();

        if (empty($setup)) {
            return ['error_code' => 1];
        }

        //周期为月度
        if ($setup['type'] == 1) {

            $consumption_money = $this->statisticsMonthMoney(date('Y-m-01 00:00:00'), date('Y-m-t 23:59:59'));

            return [
                'remaining_budget' => $setup['budget'] - $consumption_money,
                'remaining_day' => $this->statisticsMonthDay()['remaining_day'],
                'consumption_average_money' => sprintf("%.2f", $consumption_money / $this->statisticsMonthDay()['consumption_day']),
            ];
        }
        //周期为年度
        else if ($setup['type'] == 2) {
            $consumption_money = $this->statisticsMonthMoney(date('Y-01-01 00:00:00'), date('Y-12-31 23:59:59'));

            return [
                'remaining_budget' => $setup['budget'] - $consumption_money,
                'remaining_day' => $this->statisticsYearDay()['remaining_day'],
                'consumption_average_money' => sprintf("%.2f", $consumption_money / $this->statisticsYearDay()['consumption_day']),
            ];
        }
        //周期为单天
        else if ($setup['type'] == 3) {
            $consumption_money = $this->statisticsMonthMoney(date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));

            return [
                'remaining_budget' => $setup['budget'] - $consumption_money,
                'remaining_day' => 1,
                'consumption_average_money' => $consumption_money,
            ];
        }
        //周期为自定义
        else if ($setup['type'] == 0) {
            $cycle = $setup['cycle'];

            $consumption_money = $this->statisticsMonthMoney($setup['updated_at'], date($setup['updated_at'], strtotime("+$cycle day")));

            return [
                'remaining_budget' => $setup['budget'] - $consumption_money,
                'remaining_day' => $this->statisticsCustomizeDay($setup['updated_at'], $cycle)['remaining_day'],
                'consumption_average_money' => sprintf("%.2f", $consumption_money / $this->statisticsCustomizeDay($setup['updated_at'], $cycle)['consumption_day']),
            ];
        }
    }

    public function statisticsMonthMoney($start_time, $end_time)
    {
        $all = $this->account->findByTimeGetMoney($start_time, $end_time);

        $money = 0;

        foreach ($all as $value) {
            $money += $value['money'];
        }

        return $money;
    }

    public function statisticsMonthDay()
    {
        $month = date('t');

        $consumption_day = date('d');

        $remaining_day = $month - $consumption_day;

        return ['consumption_day' => $consumption_day, 'remaining_day' => $remaining_day];
    }

    public function statisticsYearDay()
    {
        $year = date('z' , mktime(23,59,59,12,31, date('Y'))) + 1;

        $consumption_day = getdate()['yday'];

        $remaining_day = $year - $consumption_day;

        return ['consumption_day' => $consumption_day, 'remaining_day' => $remaining_day];
    }

    public function statisticsCustomizeDay($strat_time, $cycle)
    {
        $consumption_day = ceil((time() - strtotime($strat_time)) / (3600*24));

        $remaining_day = $cycle - $consumption_day;

        return ['consumption_day' => $consumption_day, 'remaining_day' => $remaining_day];
    }

    public function status($id)
    {
        $info = $this->account->findIdSelect($id, ['status']);

        if ($info['status'] == 0) {
            $map['status'] = 1;
        } else {
            $map['status'] = 0;
        }

        return $this->account->update($id, $map);
    }

}