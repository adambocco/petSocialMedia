<html>

<body>

    <form action="pictureUpload.php" method="POST" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">

        <div class="p-3">
            <label class="input-group-text" for="name">Name: </label>
            <input class="form-control" id="name" name="name" type="name">
        </div>

        <div class="p-3">
            <label class="input-group-text" for="description">Description: </label>
            <input class="form-control" id="description" name="description" type="description">
        </div>

    </form>

</body>

</html>