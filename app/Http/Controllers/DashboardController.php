<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Expense;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.index');
    }

    public function getExpense() {
        $expenses = new Expense();
        $data = $expenses->summary(Auth::user()->id);
        return response()->json($data);
    }

}
