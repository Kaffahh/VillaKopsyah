<!-- Modal Edit Villa -->
<div class="modal fade" id="editVillaModal" tabindex="-1" aria-labelledby="editVillaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVillaModalLabel">Edit Villa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editVillaForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama Villa</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_type_id" class="form-label">Tipe Villa</label>
                        <select class="form-select" id="edit_type_id" name="type_id" required>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_price_per_night" class="form-label">Harga per Malam</label>
                        <input type="number" class="form-control" id="edit_price_per_night" name="price_per_night" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_capacity" class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" id="edit_capacity" name="capacity" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_location" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="edit_location" name="location">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Fasilitas</label>
                        <div class="row">
                            @foreach($facilities as $facility)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input facility-checkbox" type="checkbox" 
                                               name="facilities[]" value="{{ $facility->id }}" 
                                               id="facility_{{ $facility->id }}">
                                        <label class="form-check-label" for="facility_{{ $facility->id }}">
                                            {{ $facility->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Thumbnail Utama</label>
                        <input type="file" class="form-control" id="edit_image" name="image">
                        <div class="mt-2">
                            <img id="edit_current_image" src="" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_images" class="form-label">Foto Lainnya (Maksimal 4)</label>
                        <input type="file" class="form-control" id="edit_images" name="images[]" multiple 
                               onchange="previewEditMultipleImages(event)">
                        <div class="mt-2" id="edit_multipleImagesPreview"></div>
                        <div class="mt-2" id="edit_current_images"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan data di modal edit
    document.addEventListener('DOMContentLoaded', function() {
        $('.btn-edit').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const type_id = $(this).data('type_id');
            const price = $(this).data('price');
            const capacity = $(this).data('capacity');
            const description = $(this).data('description');
            const location = $(this).data('location');
            const status = $(this).data('status');
            
            // Set form action
            $('#editVillaForm').attr('action', '/pemilik_villa/villas/' + id);
            
            // Isi form
            $('#edit_name').val(name);
            $('#edit_type_id').val(type_id);
            $('#edit_price_per_night').val(price);
            $('#edit_capacity').val(capacity);
            $('#edit_description').val(description);
            $('#edit_location').val(location);
            $('#edit_status').val(status);
            
            // Reset fasilitas yang dipilih
            $('.facility-checkbox').prop('checked', false);
            
            // Ambil data fasilitas villa via AJAX
            $.get('/pemilik_villa/villas/' + id + '/facilities', function(data) {
                data.forEach(function(facilityId) {
                    $('#facility_' + facilityId).prop('checked', true);
                });
            });
            
            // Ambil dan tampilkan gambar saat ini
            $.get('/pemilik_villa/villas/' + id + '/images', function(data) {
                // Tampilkan thumbnail utama
                $('#edit_current_image').attr('src', '/storage/' + data.main_image);
                
                // Tampilkan gambar lainnya
                let html = '<p>Foto Saat Ini:</p><div class="d-flex flex-wrap">';
                data.other_images.forEach(function(image) {
                    html += `<img src="/storage/${image}" class="img-thumbnail m-1" style="width: 100px;">`;
                });
                html += '</div>';
                $('#edit_current_images').html(html);
            });
        });
    });
    
    // Fungsi preview gambar untuk edit
    function previewEditMultipleImages(event) {
        var input = event.target;
        var previewContainer = document.getElementById('edit_multipleImagesPreview');
        previewContainer.innerHTML = '';

        if (input.files) {
            let count = Math.min(input.files.length, 4);
            for (let i = 0; i < count; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'm-1', 'shadow-sm');
                    img.style.width = '100px';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    }
</script>