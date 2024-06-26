<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weekly Developer Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Weekly Developer Report</h5>
                        <p class="card-text">Active Tasks Count: {{$data['all_tasks']}}</p>
                        <table class="table mt-4">
                            <thead>
                            <tr>
                                <th scope="col">Developer</th>
                                <th scope="col">Developer Hour</th>
                                <th scope="col">Developer Level</th>
                                <th scope="col">Total Duration Time</th>
                                <th scope="col">Tasks Count</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data['all_tasks']))
                                    @foreach($data['tasks'] as $developer)
                                        <tr>
                                            <td>{{$developer['developer']['name']}}</td>
                                            <td>{{$developer['developer']['hours']}}</td>
                                            <td>{{$developer['developer']['difficulty']}}</td>
                                            <td>{{$developer['total_time']}}</td>
                                            <td>{{count($developer['tasks'])}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No data found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-body-secondary">
                        Min completion time {{$data['min_week']}} week
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
