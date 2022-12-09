@extends('layouts.app')

@section('content')

        <section style="padding-top: 60px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
        </section>
        <div class="container col-12 text-center p-3">
            <a href="{{url('albums/create')}}" class="btn btn-primary">Add New Album</a>
        </div>

    {!! $dataTable->scripts() !!}

        <canvas id="myChart" height="100px"></canvas>
        <script type="text/javascript">

            var labels =  {{ Js::from($labelArray) }};
            var users =  {{ Js::from($dataArray) }};

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Images Charts',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: users,
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {}
            };

            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );

        </script>

@endsection
