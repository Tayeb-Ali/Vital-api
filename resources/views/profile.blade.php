<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Cv</h2>
    <form action="update_profile/{{$id}}" method="post" enctype="">

        <div class="form-group">
            <label for="cv">Cv file:</label>
            <input type="file" class="form-control" id="cv" accept=pdf" placeholder="upload .pdf file" name="cv">
        </div>
        {{--        <div class="form-group">--}}
        {{--            <label for="pwd">Password:</label>--}}
        {{--            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">--}}
        {{--        </div>--}}
        {{--        <div class="checkbox">--}}
        {{--            <label><input type="checkbox" name="remember"> Remember me</label>--}}
        {{--        </div>--}}
        {{--        <div class="form-group">--}}
        {{--            <label for="email">Email:</label>--}}
        {{--            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">--}}

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
