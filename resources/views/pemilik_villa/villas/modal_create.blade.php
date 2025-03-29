<!-- Modal Tambah Villa -->
<div class="modal fade" id="createVillaModal" tabindex="-1" aria-labelledby="createVillaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Villa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{-- <form id="createVillaForm" action="{{ route('pemilik_villa.villas.store') }}" method="POST" enctype="multipart/form-data"> --}}
                <form id="createVillaForm" action="{{ route('pemilik_villa.villas.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Villa:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <!-- Tipe Villa -->
                    <div class="mb-3">
                        <label class="form-label">Tipe Villa:</label>
                        <select name="type_id" class="form-select" required>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label class="form-label">Deskripsi:</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Harga dan Kapasitas -->
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Harga per malam:</label>
                            <input type="number" name="price_per_night" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kapasitas:</label>
                            <input type="number" name="capacity" class="form-control" required>
                        </div>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-3">
                        <label class="form-label">Lokasi:</label>
                        <textarea name="location" class="form-control" rows="2" required></textarea>
                    </div>

                    <!-- Fasilitas -->
                    <div class="mb-3">
                        <label class="form-label">Fasilitas:</label>
                        <div class="row">
                            @foreach ($facilities as $facility)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" class="form-check-input">
                                        <label class="form-check-label">{{ $facility->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label class="form-label">Foto Thumbnail:</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required onchange="previewThumbnail(event)">
                        <img id="thumbnailPreview" src="#" alt="Preview Thumbnail" class="img-thumbnail rounded shadow-sm mt-2" style="display: none; width: 200px;">
                    </div>

                    <!-- Foto Lainnya -->
                    <div class="mb-3">
                        <label class="form-label">Foto Lainnya (Maksimal 4):</label>
                        <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" accept="image/*" multiple required>

                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <small class="text-muted">Pilih hingga 4 foto tambahan</small>
                        <div id="multipleImagesPreview" class="d-flex flex-wrap mt-2"></div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status:</label>
                        <select name="status" class="form-select" required>
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                        </select>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="modal-footer">
                        <button type="submit" id="submitBtn"class="btn btn-primary">Tambah Villa</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Preview Gambar -->
<script>
    function previewThumbnail(event) {
        var input = event.target;
        var preview = document.getElementById('thumbnailPreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    function previewMultipleImages(event) {
        var input = event.target;
        var previewContainer = document.getElementById('multipleImagesPreview');
        previewContainer.innerHTML = '';

        if (input.files.length > 4) {
            alert("Maksimal hanya 4 gambar!");
            input.value = "";
            return;
        }

        Array.from(input.files).forEach(file => {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail', 'm-1', 'shadow-sm');
                img.style.width = '100px';
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    }
</script>
<script>
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('submitBtn').disabled = true; // Mencegah submit ganda
    });
</script>
