<!DOCTYPE html>
<html>
<head>
    <title>Books Excel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
    <h1>Excel in Laravel 5X</h1>
    <p>A project to teach: How to use PHP Excel and Laravel Excel? Read more in <a href="http://longblog.info/serie-thao-tac-voi-excel-trong-laravel-5-x/" target="_blank">http://longblog.info</a> </p>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <h3>Make Excel use PHP Excel</h3>
            <p>Read more about <a href="https://phpexcel.codeplex.com/" target="_blank">PHP Excel</a></p>
            {!! Form::open(['route' => 'books.booksListPhpExcel', 'method' => 'get', 'role' => 'form']) !!}
                <button type="submit" class="btn btn-info btn-block">Press to make Excel file</button>
            {!! Form::close() !!}
        </div>
        <div class="col-sm-6">
            <h3>Make Excel use Laravel Excel</h3>
            <p>Read more about <a href="http://www.maatwebsite.nl/laravel-excel/docs" target="_blank">Laravel Excel</a></p>
            {!! Form::open(['route' => 'books.booksListLaravelExcel', 'method' => 'get', 'role' => 'form']) !!}
                <button type="submit" class="btn btn-success btn-block">Press to make Excel file</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>

</body>
</html>