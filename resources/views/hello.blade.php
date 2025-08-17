<!DOCTYPE html>
<html>
<head>
    <title>My First Laravel</title>
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            box-shadow: 2px 2px 8px #eee;
        }
    </style>
</head>
<body>
    <h1>Hello I did my first Laravel!</h1>
    <h2>Hello I did my Second Laravel!</h2>
    <h3>Hello I did my Third Laravel!</h3>

    @if(isset($accessDenied) && $accessDenied)
        <p>access denied</p>
    @else
        <div>
            @foreach($cars as $car)
                <div class="card">
                    <h4>{{ $car['name'] }}</h4>
                    <p>Model: {{ $car['model'] }}</p>
                    <p>Year: {{ $car['year'] }}</p>
                </div>
            @endforeach
        </div>
        <div>
            <p>Age: {{ $age }}</p>
            <p>hello</p>
        </div>
    @endif
</body>
</html>
</html>
