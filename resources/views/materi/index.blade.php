<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Materi
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($materi as $item)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">Tipe: {{ ucfirst($item->type) }}</p>

                        @auth
                            <a href="{{ route('materi.show', $item) }}" class="text-blue-600 hover:underline">
                                Buka Materi
                            </a>
                        @else
                            <p class="text-gray-400 italic">Silakan login untuk melihat isi materi.</p>
                        @endauth
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $materi->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
