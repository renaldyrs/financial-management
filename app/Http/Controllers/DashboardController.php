<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Member;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total data
        $totalMembers = Member::count();
        $totalIncome = Income::sum('amount');
        $totalExpense = Expense::sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        // Recent transactions
        $recentIncomes = Income::with(['member', 'user'])->latest()->take(5)->get();
        $recentExpenses = Expense::with(['expenseCategory', 'user'])->latest()->take(5)->get();
        
        // Monthly data for chart
        $monthlyIncome = Income::selectRaw('SUM(amount) as total, MONTH(date) as month')
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        $monthlyExpense = Expense::selectRaw('SUM(amount) as total, MONTH(date) as month')
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Prepare chart data
        $incomeData = array_fill(0, 12, 0);
        $expenseData = array_fill(0, 12, 0);
        
        foreach ($monthlyIncome as $income) {
            $incomeData[$income->month - 1] = $income->total;
        }
        
        foreach ($monthlyExpense as $expense) {
            $expenseData[$expense->month - 1] = $expense->total;
        }

        return view('dashboard', compact(
            'totalMembers',
            'totalIncome',
            'totalExpense',
            'balance',
            'recentIncomes',
            'recentExpenses',
            'incomeData',
            'expenseData'
        ));
    }
}