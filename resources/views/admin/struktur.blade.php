@extends('layout.admin')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/struktur.css') }}">
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@include('sweetalert::alert')
<!-- Rest of your layout content -->
<br>
<div class="content">
  <div class="page-title">
    <h1><b>Data Pegawai</b></h1>
  </div>
  <div class="box">
    <div class="sub-title">
      <h1>{{ $projectName }}</h1>
    </div><br>
    <div class="row-2">
      <button id="tambahBtn"><i class='bx bx-plus-medical' style="color:#fff;"></i> Tambah Data Pegawai</button>
      <table>
        <thead>
          <tr>
            <th><b>No</b></th>
            <th><b>Username</b></th>
            <th><b>Nama</b></th>
            <th><b>Jabatan</b></th>
            <th><b>Aksi</b></th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($pegawai))
              @php $i = 1; @endphp <!-- Variable to count the rows -->
              @foreach ($pegawai as $p)
                  <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $p->user->email }}</td>
                      <td>{{ $p->user->name }}</td>
                      <td>{{ $p->name }}</td>
                      <td style="width: 270px;">
                            <button type="button" class="btn btn-danger" onclick="handleDelete(event, '{{ route('struktur.destroy', $p->id) }}')">Delete</button>
                          <button type="button" class="btn btn-success editButton" 
                                  data-pegawaid="{{ $p->id }}"
                                  data-username="{{ $p->user->email }}"
                                  data-nama="{{ $p->user->name }}"
                                  data-struktur="{{ $p->name }}">Edit
                          </button>
                      </td>
                  </tr>
              @endforeach
          @else
              <tr>
                  <td colspan="5" style="text-align: center;">belum ada pegawai yang terlibat di project ini</td>
              </tr>
          @endif
        </tbody>
      </table>
    </div><br>
  </div>
</div>

<!-- Pop-up untuk menambahkan data pegawai -->
<div class="popup" id="addPopup">
  <div class="popup-content">
    <span class="close" id="closeAddPopup">&times;</span>
    <h2>Tambah Data Pegawai</h2>
  <form id="editForm" action="{{ route('addStruktur') }}" method="post">
    @csrf
  <label for="editNama">UserName :<br>
    <input type="hidden" id="nama_project" name="nama_project" value="#">
    <input type="text" id="username" name="username" readonly>
    </label><br>
    <input type="hidden" id="id_project" name="id_project" value="{{ $id_project }}">
    <label for="editNama">Nama :<br>
    <select name="id_pegawai" id="id_pegawai" onchange="updateEmployeeId()">
                <option value=""></option>
              @foreach ($user as $company)
                  <option value="<?= $company['id'] ?>" data-username="<?= $company['email'] ?>"><?= $company['name'] ?></option>
              @endforeach
                
            </select>
    </label><br>

    <label for="editStruktur">Jabatan:<br>
    <input type="text" id="jabatan" name="name" required>
    </label><br>
    <button type="submit">tambah</button>
  </form>
  </div>
</div>

<!-- Pop-up untuk mengedit data pegawai -->
<div class="popup" id="editPopup">
  <div class="popup-content">
    <span class="close" id="closeEditPopup">&times;</span>
    <h2>edit Data Pegawai</h2>
  <form id="editForm" action="{{ route('editStruktur') }}" method="post">
    @csrf
  <label for="editNama">UserName :<br>
  <input type="hidden" id="editPegawaiId" name="id">
  <input type="hidden" id="editPegawaiId" name="id_project" value="{{$id_project}}">
    <input type="text" id="editUsername" name="username" disabled>
    <!-- ini username -->
    <input type="text" id="editUssername" name="username"style="float: right; margin-right: -180px;" disabled >
    </label><br>
    <label for="editNama">Nama :<br>
    <select name="id_pegawai" id="editid_pegawai" onchange="updateeEmployeeId()">
      <option value="" disabled selected>Nama yang sebelumnya dipilih</option>
                @foreach ($user as $company)
                  <option value="<?= $company['id'] ?>" data-username="<?= $company['email'] ?>"><?= $company['name'] ?></option>
              @endforeach
            </select>    
            <!-- ini nama -->
            <input type="text" style="float: right; margin-right: -180px;" id="editNama" disabled>
          </label><br>

    <label for="editStruktur">Jabatan:<br>
    <input type="text" id="editStruktur" name="name" required>
    <br>
    <button type="submit">EDIT</button>
  </form>
  </div>
</div>



<!-- JavaScript code for pop-ups -->
<script>
  function handleDelete(event, url) {
        event.stopPropagation();
        
        const title = 'Delete Data!';
        const text = "Are you sure you want to delete?";

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
function updateEmployeeId() {
    var select = document.getElementById("id_pegawai");
    var selectedOption = select.options[select.selectedIndex];
    var employeeId = selectedOption.getAttribute("data-username");
    document.getElementById("username").value = employeeId;
}
function updateeEmployeeId() {
    var select = document.getElementById("editid_pegawai");
    var selectedOption = select.options[select.selectedIndex];
    var employeeId = selectedOption.getAttribute("data-username");
    document.getElementById("editUsername").value = employeeId;
}
  const tambahBtn = document.getElementById("tambahBtn");
  const addPopup = document.getElementById("addPopup");
  const closeAddPopup = document.getElementById("closeAddPopup");
  const editButtons = document.querySelectorAll(".editButton");
  const editPopup = document.getElementById("editPopup");
  const closeEditPopup = document.getElementById("closeEditPopup");
  const editPegawaiIdInput = document.getElementById("editPegawaiId");

  tambahBtn.addEventListener("click", () => {
    addPopup.style.display = "block";
  });

  closeAddPopup.addEventListener("click", () => {
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
      document.getElementById("editUssername").value = username;
      document.getElementById("editNama").value = nama;
      document.getElementById("editStruktur").value = struktur;
    });
  }); 

  closeEditPopup.addEventListener("click", () => {
    editPopup.style.display = "none";
  });
</script>

@endsection
