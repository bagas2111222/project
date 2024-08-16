@extends('layout.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/home.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<br>
<div class="content">
    <div class="col-1">
        <div class="row-0">Hi, Selamat Datang <b>{{ auth()->user()->name }}</b></div><br>
        <div class="row-01">
            <h4>Total Projects</h4>
        </div><br>
        <div class="row-05">
            <h1><b>{{ count($projects) }}</b>&nbsp Projects</h1>
        </div>
    </div>
    <div class="box">
        @if($projects->isNotEmpty())
            <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
            <script>
                const xValues = [<?= '"' . implode('", "', $projects->pluck('name')->toArray()) . '"' ?>];
                const yValues = [<?= implode(', ', $projects->pluck('averagePercentage')->toArray()) ?>];
                const barColors = generateRandomColors(yValues.length);

                function generateRandomColors(numColors) {
                    const colors = [];
                    for (let i = 0; i < numColors; i++) {
                        const color = `rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`;
                        colors.push(color);
                    }
                    return colors;
                }

                new Chart("myChart", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                    options: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: "Presentase Pengerjaan Project"
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    max: 100
                                }
                            }]
                        }
                    }
                });
            </script>
        @else
            <p>No projects available.</p>
        @endif
    </div>
</div>
@endsection
