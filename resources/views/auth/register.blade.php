<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
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

        .register-container {
            width: 100%;
            max-width: 500px;
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

        .register-header {
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

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
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

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 8px;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
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

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .step-message {
            font-size: 1rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .register-container {
                padding: 1.5rem;
            }

            .row .col {
                padding: 0;
                margin-bottom: 1rem;
            }

            .row {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                margin-top: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
            }

            .register-container {
                padding: 1.5rem;
            }

            .register-header {
                font-size: 20px;
            }

            .form-control {
                padding: 0.6rem;
            }

            .btn-primary,
            .btn-secondary {
                padding: 0.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h3 class="register-header">Register</h3>

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="hidden" name="province_code" id="province_code" />
            <input type="hidden" name="city_code" id="city_code" />
            <input type="hidden" name="district_code" id="district_code" />
            <input type="hidden" name="village_code" id="village_code" />
            <input type="hidden" name="role_request" id="role_request" />
            <input type="hidden" name="request_message" id="request_message" />

            <!-- Step 1: Pendaftaran akun -->
            <div class="step active" id="step1">
                <div class="step-message">Pendaftaran akun</div>

                <!-- Pesan error validasi -->
                <div id="step1-error" class="error-message" style="display: none">Harap isi semua field yang diperlukan.
                </div>

                <!-- Nama -->
                <div class="form-floating">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama"
                        required />
                    <label for="name">Nama</label>
                </div>

                <!-- Nama Lengkap -->
                <div class="form-floating">
                    <input type="text" name="fullname" class="form-control" id="fullname"
                        placeholder="Masukkan Nama Lengkap" required />
                    <label for="fullname">Nama Lengkap</label>
                </div>

                <!-- Email -->
                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="email"
                        placeholder="Masukkan Email" required value="{{ old('email') }}">
                    <label for="email">Email</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="row">
                    <div class="col">
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Masukkan Password" required />
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="password" name="password_confirmation" class="form-control"
                                id="confirmPassword" placeholder="Konfirmasi Password" required />
                            <label for="confirmPassword">Confirm Password</label>
                        </div>
                    </div>
                </div>

                <!-- Gender -->
                <div class="form-floating">
                    <select name="gender" class="form-control" id="gender" required>
                        <option value="">-- Pilih Gender --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <label for="gender">Gender</label>
                </div>

                <button type="button" class="btn btn-primary" onclick="validateStep1()">Next</button>
            </div>

            <!-- Step 2: Alamat lengkap -->
            <div class="step" id="step2">
                <div class="step-message">Alamat lengkap</div>

                <!-- Provinsi -->
                <div class="form-floating">
                    <select id="province" name="province_code" class="form-control" required>
                        <option value="">Pilih Provinsi</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->code }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <label for="province">Provinsi</label>
                </div>

                <!-- Kota/Kabupaten -->
                <div class="form-floating">
                    <select id="city" name="city_code" class="form-control" required>
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                    <label for="city">Kota/Kabupaten</label>
                </div>

                <!-- Kecamatan -->
                <div class="form-floating">
                    <select id="district" name="district_code" class="form-control" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <label for="district">Kecamatan</label>
                </div>

                <!-- Kelurahan -->
                <div class="form-floating">
                    <select id="village" name="village_code" class="form-control" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    <label for="village">Kelurahan</label>
                </div>

                <!-- Birthdate -->
                <div class="form-floating">
                    <input type="date" name="birthdate" class="form-control" id="birthdate" required />
                    <label for="birthdate">Birthdate</label>
                </div>

                <!-- RT/RW -->
                <div class="form-floating">
                    <input type="text" name="rtrw" class="form-control" id="rtrw"
                        placeholder="Masukkan RT/RW" required />
                    <label for="rtrw">RT/RW</label>
                </div>

                <!-- Kode Pos -->
                <div class="form-floating">
                    <input type="text" name="kode_pos" class="form-control" id="kode_pos"
                        placeholder="Masukkan Kode Pos" required />
                    <label for="kode_pos">Kode Pos</label>
                </div>

                <!-- Nomor Rumah -->
                <div class="form-floating">
                    <input type="text" name="nomor_rumah" class="form-control" id="nomor_rumah"
                        placeholder="Masukkan Nomor Rumah" required />
                    <label for="nomor_rumah">Nomor Rumah</label>
                </div>

                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
            <div class="mt-2 text-center">
                <a href="/" class="btn btn-outline-primary w-100">Kembali ke Beranda</a>
            </div>
        </form>
        <div class="mt-3 text-center">
            Sudah memiliki akun? <a href="/login" class="text-decoration-none">Login di sini</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
            });
        @endif

        function validateStep1() {
            let isValid = true;
            const step1Fields = document.querySelectorAll("#step1 input[required], #step1 select[required]");
            const errorMessage = document.getElementById("step1-error");

            // Reset pesan error
            errorMessage.style.display = "none";

            // Cek setiap field
            step1Fields.forEach((field) => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add("is-invalid"); // Tambahkan class untuk indikasi error
                } else {
                    field.classList.remove("is-invalid"); // Hapus class error jika field terisi
                }
            });

            // Jika semua field terisi, lanjut ke step 2
            if (isValid) {
                nextStep();
            } else {
                errorMessage.style.display = "block"; // Tampilkan pesan error
            }
        }

        // Fungsi untuk berpindah ke step 2
        function nextStep() {
            document.getElementById("step1").classList.remove("active");
            document.getElementById("step2").classList.add("active");
        }

        // Fungsi untuk kembali ke step 1
        function prevStep() {
            document.getElementById("step2").classList.remove("active");
            document.getElementById("step1").classList.add("active");
        }

        $(document).ready(function() {
            $("#province").change(function() {
                let province_id = $(this).val();
                $("#province_code").val(province_id);
                $.get("/cities/" + province_id, function(data) {
                    $("#city").html('<option value="">Pilih Kota/Kabupaten</option>');
                    data.forEach((city) => {
                        $("#city").append('<option value="' + city.code + '">' + city.name +
                            "</option>");
                    });
                });
            });

            $("#city").change(function() {
                let city_id = $(this).val();
                $("#city_code").val(city_id);
                $.get("/districts/" + city_id, function(data) {
                    $("#district").html('<option value="">Pilih Kecamatan</option>');
                    data.forEach((district) => {
                        $("#district").append('<option value="' + district.code + '">' +
                            district.name + "</option>");
                    });
                });
            });

            $("#district").change(function() {
                let district_id = $(this).val();
                $("#district_code").val(district_id);
                $.get("/villages/" + district_id, function(data) {
                    $("#village").html('<option value="">Pilih Kelurahan</option>');
                    data.forEach((village) => {
                        $("#village").append('<option value="' + village.code + '">' +
                            village.name + "</option>");
                    });
                });
            });

            $("#village").change(function() {
                let village_id = $(this).val();
                $("#village_code").val(village_id);
            });
        });
    </script>
</body>

</html>