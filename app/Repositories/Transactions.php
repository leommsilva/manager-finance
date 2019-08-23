<?php namespace App\Repositories;

use DB;
use App\Repositories\Repository;
use App\Persistence\Eloquent\Transaction;

class Transactions extends Repository
{
    public $months = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro',
    ];

    public function getAll($where = [])
    {
        $transactions = Transaction::select('transactions.*')
            ->where('transactions.user_id', $this->user->id)
            ->orderBy('title', 'ASC');
        if (!empty($where['month'])) {
            $transactions->where('transactions.month', $where['month']);
        }
        if (!empty($where['year'])) {
            $transactions->where('transactions.year', $where['year']);
        }

        if (!empty($where['is_verified']) || $where['is_verified'] == "0") {
            $transactions->where('transactions.is_verified', $where['is_verified']);
        }
        
        if (!empty($where['category_id'])) {
            $transactions->where('transactions.category_id', $where['category_id']);
        }

        if (!empty($where['type'])) {
            $transactions->join('categories', 'categories.id', 'transactions.category_id');
            $transactions->where('categories.type', $where['type']);
        }
        return $transactions->get();
    }

    public function chartYear($year = null, $verified = null)
    {
        if (is_null($year)) {
            $year = date('Y');
        }
        $queryCredit = $this->getChartQuery('c', $year, $verified);
        $queryDebit = $this->getChartQuery('d', $year, $verified);
        $defaultData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $data = [
            'debit' => $defaultData,
            'credit' => $defaultData
        ];

        foreach ($queryCredit->get() as $credit) {
            $index = $credit->month - 1;
            $data['credit'][$index] = (float) $credit->total;
        }

        foreach ($queryDebit->get() as $debit) {
            $index = $debit->month - 1;
            $data['debit'][$index] = (float) $debit->total;
        }
        return $data;
    }

    private function getChartQuery($type, $year, $verified = null)
    {
        $query = DB::table('categories as c')
            ->select(DB::raw('t.`month`, SUM(t.value) as total'))
            ->join('transactions as t', 't.category_id', '=', 'c.id')
            ->where('t.user_id', $this->user->id)
            ->where('c.type', $type)
            ->where('t.year', $year)
            ->where('t.deleted_at', null)
            ->where('c.deleted_at', null)
            ->groupBy('t.month')
            ->orderBy('t.month');

        if (!is_null($verified)) {
            $query->where('t.is_verified', $verified);
        }
        return $query;
    }

    public function save($params)
    {
        if (isset($params['is_recurrent'])) {
            $transactions = [];
            $month = (int) $params['month'];
            $year = (int) $params['year'];
            $period = !empty($params['period']) ? $params['period'] : 12;
            for ($i=1; $i <= $period; $i++) {
                $transactions[] = [
                    'category_id' => $params['category_id'],
                    'user_id' => $this->user->id,
                    'title' => $params['title'],
                    'value' => $params['value'],
                    'is_recurrent' => true,
                    'month' => $month,
                    'year' => $year,
                ];

                if ($month === 12) {
                    $month = 1;
                    $year++;
                } else {
                    $month++;
                }
            }
            Transaction::insert($transactions);
        } else {
            $transaction = new Transaction();
            $transaction->category_id = $params['category_id'];
            $transaction->user_id = $this->user->id;
            $transaction->title = $params['title'];
            $transaction->value = $params['value'];
            $transaction->is_recurrent = isset($params['is_recurrent']);
            $transaction->month = $params['month'];
            $transaction->year = $params['year'];
            $transaction->save();
        }
        return true;
    }

    public function getToList($where = [])
    {
        $list = [];
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($this->getAll($where) as $transaction) {
            if ($transaction->category->type === 'c') {
                $totalCredit+= $transaction->value;
            } else {
                $totalDebit+= $transaction->value;
            }
            $value = ($transaction->category->type === 'c')
                ? '<span class="text-green"> + '.$transaction->value.'</span>'
                : '<span class="text-red"> - '.$transaction->value.'</span>';
            $list[] = [
                'id' => $transaction->id,
                'Title' => $transaction->title,
                'Category' => $transaction->category->title,
                'Value' => $value,
                'Month/Year' => $this->months[$transaction->month]. '/'. $transaction->year,
                'is_verified' => $transaction->is_verified,
            ];
        }
        return [
                'list' => $list,
                'totals' => [
                    'debit' => (float) $totalDebit,
                    'credit' => (float) $totalCredit,
                    'total' => (float) ($totalCredit-$totalDebit)
                ]
            ];
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id);
        return $transaction->delete();
    }

    public function verify($id)
    {
        $transaction = Transaction::find($id);
        $verify = ($transaction->is_verified) ? false : true;
        $transaction->is_verified = $verify;
        $transaction->save();
        return $transaction;
    }
}
