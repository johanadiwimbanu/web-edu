<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Materi Saya
            </h2>

            <a href="{{ route('materi.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                + Upload Materi
            </a>
        </div>

    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($materi as $item)
                <div class="bg-white shadow-sm rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-semibold">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-500">Status: 
                        <span class="{{ $item->status === 'approved' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-500">Tipe: {{ ucfirst($item->type) }}</p>

                    <a href="{{ route('materi.show', $item) }}" class="text-blue-600 hover:underline">Lihat Materi</a>
                </div>
            @empty
                <p class="text-gray-500">Kamu belum mengunggah materi apapun.</p>
            @endforelse

            <div class="mt-4">
                {{ $materi->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
