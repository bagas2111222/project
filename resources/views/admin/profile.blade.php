@extends('layout.admin')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/admin/profile.css') }}">

    <br>
    <div class="content">
        <div class="row-01">
            <h4>Data Diri</h4>
                <form action="{{ route('editProfile') }}" method="post">
                    @csrf <!-- Tambahkan token CSRF untuk keamanan -->
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Username :</label>
                        <div class="col-sm-10">
                            <input type="hidden" id="id" name="id" value="{{ $pegawai->id }}">
                            <input type="text" readonly class="form-control-plaintext" id="username" name="username" value="{{ $pegawai->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" id="nama" name="nama" value="{{ $pegawai->name }}">
                        </div>
                    </div><br>
                    <h4>Change Password</h4><br>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password Baru :</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <i class="bx bx-hide" id="showPassword" style="cursor: pointer;"></i>
                        </div>
                    </div>
                    <button type="submit" name="submit">Submit</button>
                </form>
        </div><br>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#showPassword").click(function () {
                var passwordField = $("#password");

                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");
                    $("#showPassword").removeClass("bx-hide").addClass("bx-show");
                } else {
                    passwordField.attr("type", "password");
                    $("#showPassword").removeClass("bx-show").addClass("bx-hide");
                }
            });
        });
    </script>
@endsection
