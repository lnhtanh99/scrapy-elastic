<?php
require_once 'app/init.php';

$drinks = json_decode(file_get_contents('../test.json'));

$params = ['index' => 'whiskies'];
$bool = $es->indices()->exists($params);

if(!empty($_POST)){
    if(isset($_POST['button'])) {
        if($bool) {
            $deleteParams = [
                'index' => 'whiskies'
            ];
            $response = $es->indices()->delete($deleteParams);
        } 
        foreach ($drinks as $drink) {
            $indexed = $es->index([
                'index' => 'whiskies',
                'type' => 'whisky',
                'body' => [
                    'name' => $drink->name,
                    'price' => $drink->price,
                    'link' => $drink->link,
                ],
            ]); 
        }  
    } 
}


if (isset($_GET['q'])) {

    $q = $_GET['q'];

    $query = $es->search([
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        ['match' => ['name' => $q]],
                        ['match' => ['price' => $q]],
                    ],
                ],
            ],
        ],
    ]);

    if ($query['hits']['total']['value'] >= 1) {
        $results = $query['hits']['hits'];
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
    <title>Search</title>
</head>
<body>
    <form method="post" action="#" autocomplete="off">
        <button type="submit" name="button" class="btn btn-secondary submit-btn">Refresh Data</button>
    </form>
    <div class="search-container container">
        <form action="index.php" method="get" autocomplete="off">
            <div class="form-group">
                <label class="h2 title">Search for whiskies</label>
                <input type="text" name="q" class="form-control"/>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <p class="count">Tìm thấy 
                <?php 
                if(isset($results)) {
                    echo count($results);
                } else {
                    echo 0;
                }
                ?> kết quả</p>
        </form>
    </div>
    <div class="container">
        <div class="row">
                <?php
                    if (isset($results)) {
                        foreach ($results as $r) {
                            ?>
                                <div class="col-lg-4">
                                    <div class="result">
                                        <div class="result-name"><?php echo $r['_source']['name']; ?></div>
                                        <div class="result-price"><?php echo $r['_source']['price']; ?></div>
                                        <a href="<?php echo $r['_source']['link']; ?>"><?php echo $r['_source']['link']; ?></a>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                ?>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>