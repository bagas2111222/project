@extends('layout.template')
@section('content')
<link rel="stylesheet" href="{{ asset('css/data-pegawai.css') }}">

<!-- Rest of your layout content -->
<br>
<div class="content">
  <div class="row">
    <h1><b>Projects</b></h1>
  </div><br>
  <div class="box">
    <div class="row-2">
      <table>
        <thead>
          <tr>
            <th><b>No.</b></th>
            <th><b>Nama Project</b></th>
            <th><b>nama client</b></th>
            <th><b>Alamat client</b></th>
            <th><b>Contact Person client</b></th>
            <th><b>Nama Vendor</b></th>
            <th><b>Alamat Vendor</b></th>
            <th><b>Contact Person Vendor</b></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
              <tr>
                <td>1</td>
                <td>{{ $project->name }}</td>
                <td>
                  {{ $project->perusahaan->name }}                
                </td>
                <td>
                  {{ $project->perusahaan->alamat }}                
                </td>
                <td>
                  {{ $project->perusahaan->kontak }}                
                </td>
                <td>
                  {{ $project->vendor->name }}                
                </td>
                <td>
                  {{ $project->vendor->alamat }}                
                </td>
                <td>
                  {{ $project->vendor->kontak }}                
                </td>
              </tr>
                    @endforeach
          </tbody>
      </table>
    </div><br>
    <!-- <p style="text-align: center;">No projects available.</p>  -->
  </div>
</div>

@endsection
