<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengajuan Akun Pemilik Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
            padding: 1rem;
        }

        .submission-container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .submission-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #007bff;
            margin-bottom: 1.5rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-floating label {
            color: #6c757d;
        }

        .form-control {
            border-radius: 5px;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            width: 100%;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 8px;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .success-message {
            color: green;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .file-upload {
            margin-bottom: 1rem;
        }

        .file-upload label {
            display: block;
            margin-bottom: 0.5rem;
            color: #6c757d;
        }

        .file-upload input[type="file"] {
            display: none;
        }

        .file-upload .custom-file-upload {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 0.75rem;
            display: inline-block;
            cursor: pointer;
            width: 100%;
            text-align: center;
            background-color: #f8f9fa;
        }

        .file-upload .custom-file-upload:hover {
            background-color: #e9ecef;
        }

        .info-message {
            font-size: 0.9rem;
            color: #6c757d;
            text-align: justify;
            margin-bottom: 1.5rem;
        }

        .form-check {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .submission-container {
                padding: 1.5rem;
            }

            .btn-primary {
                margin-top: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
            }

            .submission-container {
                padding: 1.5rem;
            }

            .submission-header {
                font-size: 20px;
            }

            .form-control {
                padding: 0.6rem;
            }

            .btn-primary {
                padding: 0.6rem;
            }
        }

        .img-preview {
            width: 150px;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .img-preview:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <div class="submission-container">
        <h3 class="submission-header">Pengajuan Akun Pemilik Villa</h3>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- @if ($existingRequest && $existingRequest->expired_at) --}}
            @if ($existingRequest && $existingRequest->status === 'pending' && $existingRequest->expired_at)
                <div class="alert alert-danger text-center">
                    <p><strong>Waktu kadaluarsa pengajuan:</strong></p>
                    <p id="countdown" class="fw-bold text-danger"></p>
                </div>
            @endif

            <!-- Upload Foto KTP -->
            <div class="file-upload">
                <label for="ktp_image">Foto Kartu Identitas (KTP)</label>
                @if ($existingRequest)
                    <p><strong>Sudah diunggah:</strong>
                        <a href="{{ asset('storage/' . $existingRequest->ktp_image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $existingRequest->ktp_image) }}" alt="KTP Preview" class="img-preview" width="200px">
                        </a>
                    </p>
                @else
                    <input type="file" name="ktp_image" id="ktp_image" accept="image/*" class="form-control" required onchange="previewImage(event, 'previewKTP')" />
                    <label for="ktp_image" class="custom-file-upload">Unggah Foto KTP</label>
                    <br>
                    <img id="previewKTP" src="#" alt="Preview KTP" class="img-preview d-none" onclick="openImage(this)">
                @endif
            </div>

            <!-- Upload Kartu Keluarga (KK) -->
            <div class="file-upload">
                <label for="kk_image">Kartu Keluarga (KK)</label>
                @if ($existingRequest)
                    <p><strong>Sudah diunggah:</strong>
                        <a href="{{ asset('storage/' . $existingRequest->kk_image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $existingRequest->kk_image) }}" alt="KK Preview" class="img-preview" width="200px">
                        </a>
                    </p>
                @else
                    <input type="file" name="kk_image" id="kk_image" accept="image/*" class="form-control" required onchange="previewImage(event, 'previewKK')" />
                    <label for="kk_image" class="custom-file-upload">Unggah Kartu Keluarga</label>
                    <br>
                    <img id="previewKK" src="#" alt="Preview KK" class="img-preview d-none" onclick="openImage(this)">
                @endif
            </div>

            <!-- Upload Foto Villa -->
            <div class="file-upload">
                <label for="villa_image">Foto Villa</label>
                @if ($existingRequest && $existingRequest->villa_image)
                    <p><strong>Sudah diunggah:</strong>
                        <a href="{{ asset('storage/' . $existingRequest->villa_image) }}" target="_blank">
                            <img src="{{ asset('storage/' . $existingRequest->villa_image) }}" alt="Villa Preview" class="img-preview" width="200px">
                        </a>
                    </p>
                @else
                    <input type="file" name="villa_image" id="villa_image" accept="image/*" class="form-control" required onchange="previewImage(event, 'previewVilla')" />
                    <label for="villa_image" class="custom-file-upload">Unggah Foto Villa</label>
                    <br>
                    <img id="previewVilla" src="#" alt="Preview Villa" class="img-preview d-none" onclick="openImage(this)">
                @endif
            </div>

            <!-- Tombol Submit -->
            @if ($existingRequest)
                <div class="alert alert-warning">
                    Anda sudah mengajukan permintaan, harap tunggu persetujuan dari admin.
                </div>
                <a href="{{ route('customers.dashboard') }}" class="btn btn-primary w-100">Kembali ke Dashboard</a>
            @else
                <!-- Pesan Informasi -->
                <div class="info-message">
                    <p>
                        Untuk memastikan keamanan dan keabsahan informasi, kami memerlukan beberapa dokumen penting sebagai bagian dari proses verifikasi akun pemilik villa. Dokumen yang diminta meliputi:
                    </p>
                    <ul>
                        <li>
                            <strong>Foto KTP</strong>: Untuk memverifikasi identitas pemilik villa dan memastikan bahwa Anda adalah pemilik yang sah.
                        </li>
                        <li>
                            <strong>Kartu Keluarga (KK)</strong>: Untuk memverifikasi alamat villa dan memastikan bahwa villa tersebut terdaftar atas nama Anda atau keluarga Anda. Dokumen ini juga membantu kami memastikan bahwa villa berada di lokasi yang valid.
                        </li>
                        <li>
                            <strong>Foto Villa</strong>: Untuk memverifikasi bahwa villa yang diajukan benar-benar ada dan sesuai dengan deskripsi yang diberikan.
                        </li>
                    </ul>
                    <p>
                        Data yang Anda berikan akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan verifikasi. Terima kasih atas pengertian dan kerjasamanya.
                    </p>
                </div>

                <!-- Checkbox Persetujuan -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agree" required />
                    <label class="form-check-label" for="agree">
                        Saya telah membaca dan memahami syarat dan ketentuan yang berlaku, serta memastikan bahwa semua data yang saya berikan adalah benar dan valid.
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Ajukan Akun</button>
            @endif
            <div class="mt-2 text-center">
                <a href="/" class="btn btn-outline-primary w-100">Kembali ke Beranda</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('input[type="file"]').forEach((input) => {
            input.addEventListener("change", function() {
                const label = this.nextElementSibling;
                if (this.files.length > 0) {
                    label.textContent = this.files[0].name;
                } else {
                    label.textContent = "Unggah File";
                }
            });
        });

        function previewImage(event, previewId) {
            const input = event.target;
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgPreview = document.getElementById(previewId);
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('d-none'); // Tampilkan preview
                };
                reader.readAsDataURL(file);
            }
        }

        function openImage(imgElement) {
            const imageUrl = imgElement.src;
            window.open(imageUrl, '_blank');
        }

        function startCountdown(expiredAt) {
            const countdownElement = document.getElementById("countdown");
            if (!countdownElement) return;

            const expiredTime = new Date(expiredAt).getTime();

            const timer = setInterval(() => {
                const now = new Date().getTime();
                const distance = expiredTime - now;

                if (distance <= 0) {
                    clearInterval(timer);
                    countdownElement.innerHTML = "Waktu telah habis!";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML = `${days} hari ${hours} jam ${minutes} menit ${seconds} detik`;
            }, 1000);
        }

        @if ($existingRequest && $existingRequest->status === 'pending' && $existingRequest->expired_at)
            startCountdown("{{ $existingRequest->expired_at }}");
        @endif
    </script>

</body>

</html>
