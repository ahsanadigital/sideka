<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
</head>
<body>
    <h1>Image Upload</h1>

    <form action="{{ route('sample.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*">
        <br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
