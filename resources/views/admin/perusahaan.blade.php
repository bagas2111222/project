@extends('layout.admin')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/perusahaan.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')

<br>
<div class="content">
  <div class="row"><h1><b>Perusahaan Client</b></h1></div><br>
  <div class="box">
    <div class="menu">
      <ul>
        <li><a href="/admin/perusahaan"><i class='bx bxs-buildings'></i>&nbsp Client</a></li>
        <li><a href="/admin/vendor"><i class='bx bxs-buildings'></i>&nbsp vendor</a></li>
      </ul>
    </div><br>
    <div class="row-2">
      <button id="showAddPopup"><i class='bx bx-plus-medical' style="color:#fff;"></i> Tambah Data Perusahaan</button>
      <table>
        <thead>
          <tr>
            <th><b>No.</b></th>
            <th><b>Nama Perusahaan</b></th>
            <th><b>Jenis Perusahaan</b></th>
            <th><b>Alamat Perusahaan</b></th>
            <th><b>Contact Person</b></th>
            <th><b>Aksi</b></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($perusahaan as $key => $perusahaanItem)
            <tr>
              <td>{{ $key + 1 }}</td>
              <td>{{ $perusahaanItem->name }}</td>
              <td>{{ $perusahaanItem->jenis }}</td>
              <td>{{ $perusahaanItem->alamat }}</td>
              <td>{{ $perusahaanItem->kontak }}</td>
              <td>
                <a href="{{ route('perusahaan.destroy', $perusahaanItem->id) }}" data-confirm-delete="true"><button type="button" class="btn btn-danger">Delete</button></a>
                <button type="button" class="btn btn-success editButton" 
                  data-perusahaanid="{{ $perusahaanItem->id }}"
                  data-nama="{{ $perusahaanItem->name }}"
                  data-jenis="{{ $perusahaanItem->jenis }}"
                  data-alamat="{{ $perusahaanItem->alamat }}"
                  data-contact="{{ $perusahaanItem->kontak }}">Edit</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Pop-up untuk menambahkan data perusahaan -->
<div class="popup" id="addPopup">
  <div class="popup-content">
    <span class="close" id="closePopup">&times;</span>
    <h2>Tambah Data Perusahaan</h2>
    <form id="addForm" action="{{ route('addPerusahaan') }}" method="POST">
      @csrf
      <label for="namaPerusahaan">Nama Perusahaan:</label>
      <input type="text" id="nama" name="nama" required>

      <label for="jenisPerusahaan">Jenis Perusahaan:</label>
      <input type="text" id="jenis" name="jenis" required>

      <label for="alamatPerusahaan">Alamat Perusahaan:</label>
      <textarea id="alamat" name="alamat" required cols="23" rows="1"></textarea>

      <label for="contactPerson">Contact Person:</label>
      <input type="number" id="phone" name="phone" required>

      <button type="submit" name="save">Daftar</button>
    </form>
  </div>
</div>

<!-- Pop-up untuk mengedit data perusahaan -->
<div class="popup" id="editPopup">
  <div class="popup-content">
    <span class="close" id="closeEditPopup">&times;</span>
    <h2>Edit Data Perusahaan</h2>
    <form id="editForm" action="{{ route('editPerusahaan') }}" method="post">
      @csrf
      <input type="hidden" id="editCompanyId" name="id">
      <label for="editNama">Nama Perusahaan:</label>
      <input type="text" id="editNama" name="nama" required>

      <label for="editJenis">Jenis Perusahaan:</label>
      <input type="text" id="editJenis" name="jenis" required>

      <label for="editAlamat">Alamat Perusahaan:</label>
      <textarea id="editAlamat" name="alamat" required cols="23" rows="1"></textarea>

      <label for="editPhone">Contact Person:</label>
      <input type="number" id="editContact" name="phone" required>

      <button type="submit" name="update">Update</button>
    </form>
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
  const editCompanyIdInput = document.getElementById("editCompanyId");

  // Tampilkan pop-up tambah data ketika tombol "Tambah Data Perusahaan" diklik
  showAddPopup.addEventListener("click", () => {
    addPopup.style.display = "block";
  });

  // Tutup pop-up tambah data ketika tombol "Batal" diklik
  closePopup.addEventListener("click", () => {
    addPopup.style.display = "none";
  });

  // Event listener untuk tombol edit
  editButtons.forEach(editButton => {
    editButton.addEventListener("click", () => {
      editPopup.style.display = "block";
      const companyId = editButton.getAttribute("data-perusahaanid");
      editCompanyIdInput.value = companyId;
      // Mengambil nilai-nilai dari atribut data
    const jenis = editButton.getAttribute("data-jenis");
    const nama = editButton.getAttribute("data-nama");
    const alamat = editButton.getAttribute("data-alamat");
    const contact = editButton.getAttribute("data-contact");


    // Mengisi nilai-nilai ke dalam input di dalam pop-up edit
    document.getElementById("editJenis").value = jenis;
    document.getElementById("editNama").value = nama;
    document.getElementById("editAlamat").value = alamat;
    document.getElementById("editContact").value = contact;

    });
  });

  // Tutup pop-up edit ketika tombol "Batal" diklik
  closeEditPopup.addEventListener("click", () => {
    editPopup.style.display = "none";
  });

</script>
@endsection
