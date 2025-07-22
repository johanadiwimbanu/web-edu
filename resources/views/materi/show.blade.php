<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $materi->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Tipe Materi: <span class="font-semibold">{{ ucfirst($materi->type) }}</span>
                </p>

                @if($materi->type === 'article')
                    <div class="prose max-w-full">
                        {!! nl2br(e($materi->content)) !!}
                    </div>
                @else
                    <a href="{{ asset('storage/' . $materi->file_path) }}"
                       target="_blank"
                       class="text-blue-600 hover:underline">
                        Lihat / Unduh File
                    </a>
                @endif
            </div>

            <div class="mt-10">
                <h3 class="text-lg font-bold mb-4">Diskusi & Komentar</h3>

                @auth
                    <form action="{{ route('komentar.store', $materi) }}" method="POST" class="mb-6">
                        @csrf
                        <textarea name="body" rows="3" class="w-full p-2 border rounded" placeholder="Tulis komentar..."></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Kirim</button>
                    </form>
                @else
                    <p class="text-gray-600 italic">Login untuk memberikan komentar.</p>
                @endauth

                @foreach ($materi->comments as $comment)
                    <div class="mb-4 border-b pb-2">
                        <p class="text-sm text-gray-700 font-semibold">{{ $comment->user->name }}</p>
                        <p class="text-sm text-gray-800">{{ $comment->body }}</p>
                        <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>

                        {{-- Balasan --}}
                        @foreach ($comment->replies as $reply)
                            <div class="ml-6 mt-2 border-l pl-3">
                                <p class="text-sm font-semibold text-gray-700">{{ $reply->user->name }}</p>
                                <p class="text-sm text-gray-800">{{ $reply->body }}</p>
                                <p class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach

                        {{-- Form Balas --}}
                        @auth
                            <form action="{{ route('komentar.store', $materi) }}" method="POST" class="ml-6 mt-2">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <textarea name="body" rows="2" class="w-full p-1 border rounded" placeholder="Balas komentar..."></textarea>
                                <button type="submit" class="mt-1 px-3 py-1 bg-gray-600 text-white text-sm rounded">Balas</button>
                            </form>
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
