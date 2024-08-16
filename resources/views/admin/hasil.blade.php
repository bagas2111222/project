@extends('layout.admin')
@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/output.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<br><br><br>

<div class="content">
    <div class="row">
    <h1><b>{{ $detail['name'] }}</b></h1>
    </div>
    <div hidden>
    ID Detail: id detail
    </div>  


    <div class="project">
        <!-- Projects -->
        <button onclick="history.back()"><a>back</a></button>

        <!-- Display File Name -->
        @if (!empty($detail))
                    <div class="object">
                        <div class="col-head">{{ $detail['name'] }}</div>
                        <div class="col">{{ $detail['desc'] }}</div>
                        <div class="col" hidden>{{ $detail['id'] }}</div>
                        <div class="col"> status: {{ $detail['status'] }}</div>
                        
                        <div class="col">
                            <form action="#" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_detail" value="#">
                                <div class="col"> Upload File : <input type="file" name="file" id="file"></div>
                                <button type="submit">submit</button>
                            </form>

                            @if (!empty($file_name) && trim($file_name) !== '{"result":null}')
                                <a href="{{ route('admin.download', ['file_name' => $file_name]) }}" download>
                                    <button>Download File</button>
                                </a>
                            @endif
                        </div>
                    </div>
        @else
            <p style="text-align: center;">No projects available.</p>
        @endif
    </div>
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>
@endsection
