<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Expense extends Model
{
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function summary($id) {
        $expense = DB::table('expenses')
            ->select(DB::raw('SUM(expenses.amount) AS total'), 'categories.name AS category_name')
            ->join('users', 'expenses.user_id', '=', 'users.id')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('expenses.user_id', $id)
            ->groupBy('expenses.category_id')
            ->get();
        return $expense;
    }

}
