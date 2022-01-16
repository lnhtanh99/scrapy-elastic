<?php
require_once 'app/init.php';

if(!empty($_POST)){
    if(isset($_POST['name'], $_POST['price'], $_POST['link'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $link = $_POST['link'];

        $indexed = $es->index([
            'index' => 'whiskies',
            'type' => 'whisky',
            'body' => [
                'name' => $name,
                'price' => $price,
                'link' => $link
            ]
        ]);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Add </title>
</head>
<body>
    <div class="search-container container">
        <form method="post" action="add.php" autocomplete="off">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control"/>
            </div>
            <div class="form-group">

            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" name="price" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Link</label>
                <input type="text" name="link" class="form-control"/>
            </div>
                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
        </form>
    </div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
