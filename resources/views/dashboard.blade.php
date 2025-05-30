@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <!-- Total Members Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Anggota</h3>
                <p class="text-2xl font-semibold">{{ $totalMembers }}</p>
            </div>
        </div>
    </div>
    
    <!-- Total Income Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Pemasukan</h3>
                <p class="text-2xl font-semibold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Total Expense Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Total Pengeluaran</h3>
                <p class="text-2xl font-semibold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    
    <!-- Balance Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Saldo</h3>
                <p class="text-2xl font-semibold">Rp {{ number_format($balance, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-medium mb-4">Grafik Pemasukan dan Pengeluaran Tahun Ini</h3>
    <canvas id="financeChart" height="100"></canvas>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Recent Incomes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium">Pemasukan Terakhir</h3>
            <a href="{{ route('incomes.create') }}" class="text-sm text-blue-600 hover:text-blue-800">Tambah Baru</a>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentIncomes as $income)
            <div class="p-6">
                <div class="flex justify-between">
                    <div>
                        <p class="font-medium">{{ $income->member->name }}</p>
                        <p class="text-sm text-gray-500">{{ $income->date->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-green-600">+Rp {{ number_format($income->amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">{{ $income->source }}</p>
                    </div>
                </div>
                @if($income->description)
                <p class="mt-2 text-sm text-gray-600">{{ $income->description }}</p>
                @endif
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Tidak ada data pemasukan
            </div>
            @endforelse
        </div>
        @if($recentIncomes->count() > 0)
        <div class="p-4 border-t border-gray-200 text-center">
            <a href="{{ route('incomes.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        @endif
    </div>
    
    <!-- Recent Expenses -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium">Pengeluaran Terakhir</h3>
            <a href="{{ route('expenses.create') }}" class="text-sm text-blue-600 hover:text-blue-800">Tambah Baru</a>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($recentExpenses as $expense)
            <div class="p-6">
                <div class="flex justify-between">
                    <div>
                        <p class="font-medium">{{ $expense->expenseCategory->name }}</p>
                        <p class="text-sm text-gray-500">{{ $expense->date->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-red-600">-Rp {{ number_format($expense->amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Oleh: {{ $expense->user->name }}</p>
                    </div>
                </div>
                @if($expense->description)
                <p class="mt-2 text-sm text-gray-600">{{ $expense->description }}</p>
                @endif
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Tidak ada data pengeluaran
            </div>
            @endforelse
        </div>
        @if($recentExpenses->count() > 0)
        <div class="p-4 border-t border-gray-200 text-center">
            <a href="{{ route('expenses.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('financeChart').getContext('2d');
        const financeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($incomeData),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($expenseData),
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection