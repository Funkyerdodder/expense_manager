<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Expense;
use App\User;

class ExpenseController extends Controller
{
    public function index() {
        return view('expense.manage');
    }

    public function addExpense(Request $request) {
        $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'category' => 'required'
        ]);

        $expense = new Expense();
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->category_id = $request->category;
        $expense->user_id = Auth::user()->id;
        $expense->save();

        return response()->json([
            'status' => 'success',
            'last_id' => $expense->id,
            'category_name' => $expense->category->name,
            'category_id' => $expense->category->id,
            'created_at' => $expense->created_at
        ]);

    }

    public function getExpense() {
        $user = Auth::user()->id;
        $expense = User::with('expenses.category')->where('id', $user)->first();
        return response()->json($expense);
    }

    public function deleteExpense(Request $request) {
        Expense::destroy($request->id);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function updateExpense(Request $request) {
        $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'category' => 'required'
        ]);

        $expense = Expense::find($request->id);
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->category_id = $request->category;
        $expense->user_id = Auth::user()->id;
        $expense->save();

        return response()->json([
            'status' => 'success',
            'last_id' => $expense->id,
            'category_name' => $expense->category->name,
            'category_id' => $expense->category->id
        ]);

    }

}
