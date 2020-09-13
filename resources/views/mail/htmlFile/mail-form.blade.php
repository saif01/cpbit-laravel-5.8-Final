<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form action="{{ route('send.mail.action') }}" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="text" name="name" placeholder="name" > <br><br>

        <input type="file" name="attachment"> <br><br>
        <input type="submit" value="send Mail"> <br>

    </form>



</body>
</html>
{{-- <input type="file" name="attachment[]" multiple> <br><br> --}}
