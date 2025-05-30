@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <a href="{{ route('members.index') }}" class="text-blue-600 hover:text-blue-800">Anggota</a> / Detail Anggota
    </h2>
@endsection

@section('header-button')
    <div class="flex space-x-2">
        <a href="{{ route('members.edit', $member->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
            Edit
        </a>
        <form action="{{ route('members.destroy', $member->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')" 
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Hapus
            </button>
        </form>
    </div>
@endsection

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Informasi Pribadi</h3>
                <div class="mt-4 space-y-2">
                    <div>
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $member->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $member->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $member->phone }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-900">Alamat</h3>
                <div class="mt-4">
                    <p class="text-sm text-gray-900">{{ $member->address }}</p>
                </div>
                
                <h3 class="mt-6 text-lg font-medium text-gray-900">Total Pemasukan</h3>
                <!-- <div class="mt-2">
                    <p class="text-2xl font-semibold text-green-600">Rp {{ number_format($member->incomes->sum('amount'), 0, ',', '.') }}</p>
                </div> -->
            </div>
        </div>
    </div>
    
    <div class="border-t border-gray-200 px-6 py-4">
        <h3 class="text-lg font-medium text-gray-900">Riwayat Pemasukan</h3>
    </div>
    
    <!-- <div class="divide-y divide-gray-200">
        @forelse($incomes as $income)
        <div class="p-6">
            <div class="flex justify-between">
                <div>
                    <p class="font-medium">{{ $income->date->format('d M Y') }}</p>
                    <p class="text-sm text-gray-500">{{ $income->source }}</p>
                </div>
                <div class="text-right">
                    <p class="font-medium text-green-600">+Rp {{ number_format($income->amount, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">Dicatat oleh: {{ $income->user->name }}</p>
                </div>
            </div>
            @if($income->description)
            <p class="mt-2 text-sm text-gray-600">{{ $income->description }}</p>
            @endif
        </div>
        @empty
        <div class="p-6 text-center text-gray-500">
            Tidak ada riwayat pemasukan
        </div>
        @endforelse
    </div> -->
    
    @if($incomes->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $incomes->links() }}
    </div>
    @endif
</div>
@endsection