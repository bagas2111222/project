@extends('layout.admin')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/pegawai.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')
<!-- Rest of your layout content -->
<br>
<div class="content">
  <div class="row"><h1><b>Data pegawai</b></h1></div><br>
  <div class="box">
    <div class="row-2">
      <button id="showAddPopup"><i class='bx bx-plus-medical' style="color:#fff;"></i> Tambah Data Pegawai</button>
      <table>
        <thead>
          <tr>
            <th><b>No.</b></th>
            <th><b>Username</b></th>
            <th><b>Nama Pegawai</b></th>
            <th><b>Struktur</b></th>
            <th><b>Password</b></th>
            <th><b>Aksi</b></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pegawai as $key => $pegawaiItem)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $pegawaiItem->email }}</td>
              <td>{{ $pegawaiItem->name }}</td>
              <td>{{ $pegawaiItem->struktur }}</td>
              <td>********</td>
              <td>
              <a href="{{ route('user.destroy', $pegawaiItem->id) }}" data-confirm-delete="true">
                <button type="button" class="btn btn-danger">Delete</button>
              </a>

                <button type="button" class="btn btn-success editButton" data-pegawaid="{{ $pegawaiItem->id }}"
                  data-username="{{ $pegawaiItem->email }}"
                  data-nama="{{ $pegawaiItem->name }}"
                  data-struktur="{{ $pegawaiItem->struktur }}">Edit
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pop-up untuk menambahkan data pegawai -->
  <div class="popup" id="addPopup">
    <div class="popup-content">
      <span class="close" id="closePopup">&times;</span>
      <h2>Tambah Data Pegawai</h2>
      <form id="addForm" action="{{ route('addUser') }}" method="post">
        @csrf
        <label for="username">Username:</label> <br>
        <input type="text" id="username" name="username" required><br>

        <label for="nama">Nama Pegawai:</label> <br>
        <input type="text" id="nama" name="nama" required><br>

        <label for="struktur">Struktur: </label><br>
        <select id="struktur" name="struktur">
          <option value=""></option>
          <option value="admin">Admin</option>
          <option value="pegawai">Pegawai</option>
        </select>
        <br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Simpan</button>
      </form>
    </div>
  </div>

  <!-- Pop-up untuk mengedit data pegawai -->
  <div class="popup" id="editPopup">
    <div class="popup-content">
      <span class="close" id="closeEditPopup">&times;</span>
      <h2>Edit Data Pegawai</h2>
      <form id="editForm" action="{{ route('editUser') }}" method="post">
        @csrf
        <input type="hidden" id="editPegawaiId" name="id">
        <label for="editUsername">Username:</label><br>
        <input type="text" id="editUsername" name="username" required><br>

        <label for="editNama">Nama Pegawai:</label><br>
        <input type="text" id="editNama" name="nama" required><br>

        <label for="editStruktur">Struktur: </label><br>
        <select id="editStruktur" name="struktur">
          <option value=""></option>
          <option value="admin">Admin</option>
          <option value="pegawai">Pegawai</option>
        </select>
        <br>
        <label for="editPassword">Password:</label><br>
        <input type="password" id="editPassword" name="password" placeholder="kosongkan jika tidak ingin ganti password"><br>

        <button type="submit">Update</button>
      </form>
    </div>
  </div>

</div>

<script>
  const showAddPopup = document.getElementById("showAddPopup");
  const addPopup = document.getElementById("addPopup");
  const addForm = document.getElementById("addForm");
  const closePopup = document.getElementById("closePopup");

  const editButtons = document.querySelectorAll(".editButton");
  const editPopup = document.getElementById("editPopup");
  const closeEditPopup = document.getElementById("closeEditPopup");
  const editForm = document.getElementById("editForm");
  const editPegawaiIdInput = document.getElementById("editPegawaiId");

  // Tampilkan pop-up tambah data ketika tombol "Tambah Data Pegawai" diklik
  showAddPopup.addEventListener("click", () => {
    addPopup.style.display = "block";
  });

  // Tutup pop-up ketika tombol "Batal" diklik
  closePopup.addEventListener("click", () => {
    addPopup.style.display = "none";
  });

  // Event listener untuk tombol edit
editButtons.forEach(editButton => {
  editButton.addEventListener("click", () => {
    editPopup.style.display = "block";
    const pegawaiId = editButton.getAttribute("data-pegawaid");
    editPegawaiIdInput.value = pegawaiId;

    // Mengambil nilai-nilai dari atribut data
    const username = editButton.getAttribute("data-username");
    const nama = editButton.getAttribute("data-nama");
    const struktur = editButton.getAttribute("data-struktur");

    // Mengisi nilai-nilai ke dalam input di dalam pop-up edit
    document.getElementById("editUsername").value = username;
    document.getElementById("editNama").value = nama;
    document.getElementById("editStruktur").value = struktur;
  });
});


  // Tutup pop-up edit ketika tombol "Batal" diklik
  closeEditPopup.addEventListener("click", () => {
    editPopup.style.display = "none";
  });

</script>

@endsection
