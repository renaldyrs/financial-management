@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Daftar Anggota
    </h2>
@endsection

@section('header-button')
    
@endsection

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="p-4 border-b border-gray-200 flex justify-between">
        <div class="flex items-center">
            <form action="{{ route('members.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" placeholder="Cari anggota..." 
                   value="{{ request('search') }}" 
                   class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('members.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                Reset
            </a>
            @endif
        </form>
        </div>
        

        <div class="flex flex-col">
            <a href="{{ route('members.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        Tambah Anggota
    </a>
        </div>

        
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($members as $member)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-medium">{{ substr($member->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $member->name }}</div>
                                <div class="text-sm text-gray-500">{{ $member->address }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $member->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $member->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('members.show', $member->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Lihat</a>
                        <a href="{{ route('members.edit', $member->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data anggota
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($members->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $members->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection