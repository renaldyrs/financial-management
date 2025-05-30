@extends('layouts.app')

@section('title', 'Daftar Pemasukan')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Daftar Pemasukan
    </h2>
@endsection

@section('header-button')
    
@endsection

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex justify-between">
        <div>
<form action="{{ route('incomes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="member" class="block text-sm font-medium text-gray-700">Anggota</label>
                <select name="member_id" id="member" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Anggota</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 h-10">
                    Filter
                </button>
                @if(request()->anyFilled(['member_id', 'start_date', 'end_date']))
                <a href="{{ route('incomes.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 h-10">
                    Reset
                </a>
                @endif
            </div>
        </form>
        </div>
        

        <div>
            <a href="{{ route('incomes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        Tambah Pemasukan
    </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anggota</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sumber</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dicatat Oleh</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($incomes as $income)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $income->date->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $income->member->name }}</div>
                        <div class="text-sm text-gray-500">{{ $income->member->phone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $income->source }}</div>
                        @if($income->description)
                        <div class="text-sm text-gray-500">{{ Str::limit($income->description, 30) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                        +Rp {{ number_format($income->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $income->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('incomes.show', $income->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Lihat</a>
                        <a href="{{ route('incomes.edit', $income->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                        <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus pemasukan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data pemasukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($incomes->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $incomes->withQueryString()->links() }}
    </div>
    @endif

    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-500">
                Total Pemasukan: <span class="font-medium text-green-600">Rp {{ number_format($incomes->sum('amount'), 0, ',', '.') }}</span>
            </div>
            <div class="text-sm text-gray-500">
                Menampilkan {{ $incomes->firstItem() }} - {{ $incomes->lastItem() }} dari {{ $incomes->total() }} data
            </div>
        </div>
    </div>
</div>
@endsection
