<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upload Materi
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Judul</label>
                        <input type="text" name="title" class="form-input w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tipe Materi</label>
                        <select name="type" class="form-select w-full" required>
                            <option value="article">Artikel</option>
                            <option value="pdf">PDF</option>
                            <option value="video">Video</option>
                            <option value="audio">Audio</option>
                            <option value="image">Gambar</option>
                        </select>
                    </div>

                    <div class="mb-4" id="artikel-field">
                        <label class="block font-medium text-sm text-gray-700">Konten Artikel</label>
                        <textarea name="content" class="form-textarea w-full"></textarea>
                    </div>

                    <div class="mb-4" id="file-field">
                        <label class="block font-medium text-sm text-gray-700">File (PDF/Video/Audio/Gambar)</label>
                        <input type="file" name="file_path" class="form-input w-full">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Upload
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const typeSelect = document.querySelector('select[name="type"]');
        const artikelField = document.getElementById('artikel-field');
        const fileField = document.getElementById('file-field');

        function toggleFields() {
            if (typeSelect.value === 'article') {
                artikelField.style.display = 'block';
                fileField.style.display = 'none';
            } else {
                artikelField.style.display = 'none';
                fileField.style.display = 'block';
            }
        }

        typeSelect.addEventListener('change', toggleFields);
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
</x-app-layout>
