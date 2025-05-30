<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Member;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
{
    $members = Member::all();

    // Base query with eager loading
    $query = Income::with(['member', 'user']);

    // Filtering
    if ($request->filled('member_id')) {
        $query->where('member_id', $request->member_id);
    }

    if ($request->filled('start_date')) {
        $query->whereDate('date', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('date', '<=', $request->end_date);
    }

    // Hitung total pemasukan dari query (terfilter)
    $totalAmount = $query->sum('amount');

    // Ambil data dengan pagination
    $incomes = $query->latest()->paginate(10);

    // Kirim ke view
    return view('incomes.index', compact('incomes', 'members', 'totalAmount'));
}



    public function create()
    {
        $members = Member::all();
        $incomes = Income::with(['member', 'user']);


        return view('incomes.create', compact('members', 'incomes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'source' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Income::create([
            'member_id' => $request->member_id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'date' => $request->date,
            'source' => $request->source,
            'description' => $request->description,
        ]);
        

        return redirect()->route('incomes.index')
            ->with('success', 'Pemasukan berhasil dicatat');
    }

    public function show(Income $income)
    {
        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        $members = Member::all();
        return view('incomes.edit', compact('income', 'members'));
    }

    public function update(Request $request, Income $income)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'source' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $income->update([
            'member_id' => $request->member_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'source' => $request->source,
            'description' => $request->description,
        ]);

        return redirect()->route('incomes.index')
            ->with('success', 'Data pemasukan berhasil diperbarui');
    }

    public function destroy(Income $income)
    {
        $income->delete();
        return redirect()->route('incomes.index')
            ->with('success', 'Pemasukan berhasil dihapus');
    }
}