@extends('layout.template')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/d-tahapan.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')
<!-- Rest of your layout content -->
<br>
<div class="content">
    <div class="row">
        <h2><b>{{ $projectName }}</b></h2>
        <h5 align="center"><b>{{ $tahapanName }}</b></h5>
    </div>

    <!-- List Project -->
    <div class="project">
        <!-- Projects -->
        <a href='/pegawai/tahapan/{{ $id_project }}'><button><b>back</b></button></a>
        

        @if (empty($detail))
            <p style="text-align: center;">No detail available.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Judul Tugas</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Deadline</th>   
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detail as $tugas)
                        <tr onclick="window.location='{{ url('admin/output/' . $tugas['id']) }}'" style="cursor: pointer;">
                            <td><a href="{{ url('admin/output/' . $tugas['id'] . '/' . $tugas['name'] . '/' . $tugas['id_detail']) }}" style="text-decoration: none;">{{ $tugas['name'] }}</a></td>
                            <td>{{ $tugas['desc'] }}</td>
                            <td class="status">{{ $tugas['status'] }}</td>
                            <td>{{ date('d-F-Y', strtotime($tugas['deadline'])) }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- Pop-up for adding -->
<div class="popup" id="addPopup">
    <div class="popup-content">
        <span class="close" id="closeAddPopup">&times;</span>
        <h2>Tambah Data</h2><br>
        <form action="{{ route('addDetail') }}" method="post">
            @csrf
            <input type="hidden" id="nama" name="id" value="{{ $id_tahapan }}"><br>
            <label for="editNama">Judul Tugas</label><br>
            <input type="text" id="dsa" name="name" required><br>
            <label for="editDeskripsi">Deskripsi:</label><br>
            <input type="text" id="ddas" name="desc"><br>
            <label for="editDeadline">Deadline:</label><br>
            <input type="date" id="das" name="deadline" required >
            <button type="submit">Tambah</button>
        </form>
    </div>
</div>

<!-- Pop-up for editing -->
<div class="popup" id="editPopup">
    <div class="popup-content">
        <span class="close" id="closeEditPopup">&times;</span>
        <h2>Edit Nama Tahapan</h2><br>
        <form action="{{ route('editDetail') }}" method="post">
            @csrf
            <input type="hidden" id="editID" name="id">
            <label for="editNama">Judul Tugas</label><br>
            <input type="text" id="editNama" name="name" required><br>
            <label for="editDeskripsi">Deskripsi:</label><br>
            <input type="text" id="editDesc" name="desc" placeholder="con: dalam pengerjaan"><br>
            <label for="editDeadline">Deadline:</label><br>
            <input type="date" id="editdate" name="deadline" required>
            <button type="submit">Update</button>
        </form>
    </div>
</div>

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
    function goBack() {
        window.history.back();
    }

    // Function to open the Add popup
    const addTaskBtn = document.getElementById("addTaskBtn");
    const addPopup = document.getElementById("addPopup");
    const closeAddPopup = document.getElementById("closeAddPopup");

    addTaskBtn.addEventListener("click", () => {
        addPopup.style.display = "block";
    });

    closeAddPopup.addEventListener("click", () => {
        addPopup.style.display = "none";
    });

    // Function to open the Edit popup
    const editButtons = document.querySelectorAll(".editTaskBtn");
    const editPopup = document.getElementById("editPopup");
    const closeEditPopup = document.getElementById("closeEditPopup");

    editButtons.forEach(editButton => {
        editButton.addEventListener("click", (event) => {
            editPopup.style.display = "block";
            event.stopPropagation();

            // You can add logic here to populate the edit form with data.
            const pegawaiId = editButton.getAttribute("data-id");
            // Mengambil nilai-nilai dari atribut data
            const desc = editButton.getAttribute("data-desc");
            const nama = editButton.getAttribute("data-nama");
            const deadline = editButton.getAttribute("data-deadline");

            // Mengisi nilai-nilai ke dalam input di dalam pop-up edit
            document.getElementById("editID").value = pegawaiId;
            document.getElementById("editDesc").value = desc;
            document.getElementById("editNama").value = nama;
            document.getElementById("editdate").value = deadline;
        });
    });

    closeEditPopup.addEventListener("click", () => {
        editPopup.style.display = "none";
    });
</script>

@endsection
