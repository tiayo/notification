<?php

namespace  App\Http\Controllers\Accounting;

use App\Facades\Verfication;
use App\Http\Controllers\Controller;
use App\Service\AccountingService;
use App\Service\IndexService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $account;
    protected $request;

    public function __construct(AccountingService $accounting, Request $request)
    {
        $this->account = $accounting;
        $this->request = $request;
    }

    public function view($page)
    {
        //所有任务
        $lists = $this->account->show($page, Config('site.page'));

        //任务数量
        $count = $this->account->count();

        // 最多页数
        $max_page = ceil($count/Config('site.page'));

        //判断管理员
        $admin = can('admin');

        return view('home.accounting_list',[
            'lists' => $lists,
            'count' => ($count <= 5) ? $count : 5,
            'page' => $page,
            'max_page' => $max_page,
            'admin' => $admin,
            'controller' => 'App\Http\Controllers\Controller',
        ]);
    }

    public function setupView()
    {
        $old_input = $this->account->getSetup();

        if (empty($old_input)) {
            $old_input = $this->request->session()->get('_old_input');
            $ststus = 0;
        }

        return view("home.accounting_setup", [
            'old_input' => $old_input,
            'uri' => Route('accounting_setup'),
            'controller' => 'App\Http\Controllers\Controller',
            'status' => $ststus ?? 1,
        ]);
    }

    public function setupPost()
    {
        $this->validate($this->request, [
            'budget' => 'required',
            'type' => 'required|integer|min:0|max:3',
            'cycle' => 'numeric',
        ]);

        try {
            $this->account->setup($this->request->all());
        } catch (\Exception $e) {
            $errors = $e->getMessage();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->back();
    }

    public function createView()
    {
        return view("home.accounting_add", [
            'old_input' => $this->request->session()->get('_old_input'),
            'uri' => Route('accounting_add'),
            'type' => '添加消费记录',
            'controller' => 'App\Http\Controllers\Controller',
        ]);
    }

    public function updateView($id)
    {
        //验证权限
        if (!$this->verfication($id)) {
            return response('没有权限！');
        }

        return view("home.accounting_add", [
            'old_input' => $this->account->findId($id),
            'uri' => Route('accounting_update', ['id' => $id, 'type' => 'update']),
            'type' => '更新消费记录',
            'controller' => 'App\Http\Controllers\Controller',
        ]);
    }

    public function createOrUpdate($id = null, $type = null)
    {
        //验证权限
        if (!empty($id) && !$this->verfication($id)) {
            return response('没有权限！');
        }

        $this->validate($this->request, [
            'title' => 'required',
            'type' => 'required|integer|min:0|max:7',
            'money' => 'required|numeric',
            'time' => 'required|date',
        ]);

        try {
            $this->account->createOrUpdate($this->request->all(), $id, $type);
        } catch (\Exception $e) {
            $errors = $e->getMessage();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return redirect()->route('accounting_view_simple');
    }

    public function destroy($account_id)
    {
        $this->account->destroy($account_id);

        return redirect()->route('accounting_view_simple');
    }

    public function statistics()
    {
        $data = $this->account->statistics();

        if (isset($data['error_code']) && $data['error_code'] == 1) {
            echo '还未配置规则';
            return redirect()->route('accounting_setup');
        }

        return view('home.accounting_statistics', [
            'remaining_budget' => $data['remaining_budget'],
            'remaining_day' => $data['remaining_day'],
            'average_money' => sprintf("%.2f", $data['remaining_budget'] / $data['remaining_day']),
            'consumption_average_money' => $data['consumption_average_money']
        ]);
    }

    public function status($id)
    {
        //验证权限
        if (!empty($id) && !$this->verfication($id)) {
            return response('没有权限！');
        }

        try {
            $this->account->status($id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->back();
    }

    /**
     * 验证用户是否可以操作本条任务
     * 验证失败抛错误
     *
     * @param $task_id
     * @return mixed
     */
    public function verfication($id)
    {
        return can('update', $this->account->findId($id));
    }
}