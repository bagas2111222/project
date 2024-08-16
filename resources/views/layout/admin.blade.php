<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/admin/t-admin.css') }}">
    <link rel="icon"  type="images/x-icon" href="{{ asset('img/logo.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Project Management</title>
</head>
<body>
    <div class="sidebar">
        <h1>bright</h1>
        <a href="{{ url('/admin/Profile') }}"><i class='bx bx-user-circle' style='color:#ffffff'></i> Profile</a>
        <a href="{{ url('/admin') }}"><i class='bx bx-home-alt-2' style='color:#ffffff'></i> Dashboard</a>
        <a href="{{ url('/admin/projects') }}"><i class='bx bx-folder' style='color:#ffffff'></i> Project</a>
        <a href="{{ url('/admin/pegawai') }}"><i class='bx bx-bookmark'></i>&nbsp Employees</a>
        <a href="{{ url('/admin/perusahaan') }}"><i class='bx bxs-buildings'></i>&nbsp Companies</a>
    </div>
    <a href="/logout"><i class='bx bx-log-in' style='color:#ffffff' id="out"> Logout</i></a>

    @yield('content')

    <!--
    <footer class="jumbotron jumbotron-fluid mt-5 mb-0">
        <div class="container text-center">Copyright &copy {{ date('Y') }} giftallafaidza & Bagaskoro</div>
    </footer>
    -->
</body>
</html>
