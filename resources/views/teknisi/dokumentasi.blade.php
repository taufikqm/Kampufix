@extends('layouts.teknisi')

@section('page_title', 'Dokumentasi Perbaikan')

@section('content')
<a href="{{ route('teknisi.pengaduan.detail', $pengaduan->id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-800 mb-6">
    <span class="material-symbols-outlined text-base">arrow_back</span>
    Kembali ke Detail Pengaduan
</a>
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">Dokumentasi Perbaikan</h1>
    <p class="text-lg text-gray-600 mb-8">Lengkapi catatan perbaikan dan unggah bukti foto atau dokumen untuk menyelesaikan laporan ini.</p>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
        <form action="{{ route('teknisi.pengaduan.dokumentasi.store', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Catatan Perbaikan -->
            <div>
                <label for="catatan_perbaikan" class="block text-sm font-semibold text-gray-700 mb-2">
                    Catatan Perbaikan
                </label>
                <textarea 
                    id="catatan_perbaikan"
                    name="catatan_perbaikan" 
                    rows="8"
                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 px-4 py-3 resize-y"
                    placeholder="Jelaskan secara detail tindakan perbaikan yang telah dilakukan..."
                    required
                >{{ old('catatan_perbaikan') }}</textarea>
                @error('catatan_perbaikan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Bukti -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Unggah Bukti (Foto/Dokumen)
                </label>
                
                <!-- Upload Area -->
                <div 
                    id="uploadArea"
                    class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-red-400 transition-colors cursor-pointer bg-gray-50 hover:bg-gray-100"
                    onclick="document.getElementById('foto_perbaikan').click()"
                >
                    <input 
                        type="file" 
                        id="foto_perbaikan"
                        name="foto_perbaikan" 
                        accept="image/png,image/jpeg,image/jpg,image/gif"
                        class="hidden"
                        onchange="handleFileSelect(this)"
                    >
                    
                    <div id="uploadPlaceholder" class="space-y-4">
                        <div class="flex justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-red-600 font-medium">Klik untuk mengunggah atau seret dan lepas file</p>
                            <p class="text-sm text-gray-500 mt-2">PNG, JPG, GIF hingga 10MB</p>
                        </div>
                    </div>

                    <!-- Preview Image -->
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" src="" alt="Preview" class="max-h-64 mx-auto rounded-lg mb-4">
                        <p id="fileName" class="text-sm font-medium text-gray-700"></p>
                        <button 
                            type="button" 
                            onclick="removeImage()" 
                            class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium"
                        >
                            Hapus gambar
                        </button>
                    </div>
                </div>

                @error('foto_perbaikan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Pengaduan -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">Pengaduan:</span> {{ $pengaduan->kode }} - {{ $pengaduan->subjek }}
                </p>
            </div>

            <!-- Submit Button -->
            <div>
                <button 
                    type="submit" 
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition"
                >
                    Kirim Dokumentasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Floating Action Button -->
<button class="fixed bottom-8 right-8 w-14 h-14 bg-gray-800 hover:bg-gray-900 text-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110">
    <span class="material-symbols-outlined text-white">auto_awesome</span>
</button>

@push('scripts')
<script>
    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            // Validasi ukuran file (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file maksimal 10MB');
                input.value = '';
                return;
            }

            // Validasi tipe file
            const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Format file harus PNG, JPG, atau GIF');
                input.value = '';
                return;
            }

            reader.onload = function(e) {
                document.getElementById('uploadPlaceholder').classList.add('hidden');
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('fileName').textContent = file.name;
            };

            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        document.getElementById('foto_perbaikan').value = '';
        document.getElementById('uploadPlaceholder').classList.remove('hidden');
        document.getElementById('imagePreview').classList.add('hidden');
        document.getElementById('previewImg').src = '';
        document.getElementById('fileName').textContent = '';
    }

    // Drag and drop functionality
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('foto_perbaikan');

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-red-400', 'bg-red-50');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('border-red-400', 'bg-red-50');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-red-400', 'bg-red-50');
        
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect(fileInput);
        }
    });
</script>
@endpush
@endsection

