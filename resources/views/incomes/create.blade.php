@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Filter & Button Header -->
    <div class="p-4 border-b border-gray-200 flex flex-col md:flex-row md:justify-between md:items-center gap-4 bg-gray-50">
        <!-- Filter Form -->
        <form action="{{ route('incomes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 w-full">
            <div>
                <label for="member" class="block text-sm font-medium text-gray-700">Anggota</label>
                <select name="member_id" id="member" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Semua Anggota</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    Filter
                </button>
                @if(request()->anyFilled(['member_id', 'start_date', 'end_date']))
                <a href="{{ route('incomes.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition">
                    Reset
                </a>
                @endif
            </div>
        </form>

        <!-- Tambah Button -->
        <div class="md:ml-4">
            <a href="{{ route('incomes.create') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                + Tambah Pemasukan
            </a>
        </div>
    </div>

    <!-- Tabel Pemasukan -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Anggota</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Sumber</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Jumlah</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Dicatat Oleh</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($incomes as $income)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $income->date->format('d M Y') }}</td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ $income->member->name ?? '-' }}</div>
                        <div class="text-gray-500">{{ $income->member->phone ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-gray-900">{{ $income->source }}</div>
                        @if($income->description)
                        <div class="text-gray-500 text-xs truncate w-40" title="{{ $income->description }}">
                            {{ Str::limit($income->description, 30) }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-green-700 font-semibold whitespace-nowrap">
                        +Rp {{ number_format($income->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                        {{ $income->user->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                        <a href="{{ route('incomes.show', $income->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                        <a href="{{ route('incomes.edit', $income->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('incomes.destroy', $income->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemasukan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data pemasukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination & Total -->
    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 flex flex-col md:flex-row md:items-center justify-between text-sm text-gray-600 gap-2">
        <div>
            Total Pemasukan: <span class="text-green-700 font-semibold">Rp {{ number_format($incomes->sum('amount'), 0, ',', '.') }}</span>
        </div>
        <div>
            Menampilkan {{ $incomes->firstItem() }} - {{ $incomes->lastItem() }} dari {{ $incomes->total() }} data
        </div>
        @if($incomes->hasPages())
        <div class="mt-2 md:mt-0">
            {{ $incomes->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
