<?php
require "config.php";

$select = $conn->query('SELECT * FROM urls');
$select->execute();
$rows = $select->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['submit'])){
    if($_POST['url'] == ''){
        echo "the input is empty";
    } else {
        $url = $_POST['url'];
        $insert = $conn->prepare("INSERT INTO urls (url) VALUES (:url)");
        $insert->execute([
           ':url' => $url
        ]);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" xintegrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            body {overflow: hidden;}
            
            .margin {
                margin-top: 200px
            }
        </style>
    </head>
    <body>
        
        <div class="container">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <form class="card p-2 margin" method ="POST" action="index.php">
                        <div class="input-group">
                        <input type="text" name="url" class="form-control" placeholder="your url">
                        <div class="input-group-append">
                            <button type="submit" name="submit" class="btn btn-success">Shorten</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container" id ="refresh">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <table class="table mt-4">
                        <thead>
                            <tr>
                            <th scope="col">long url</th>
                            <th scope="col">short url</th>
                            <th scope="col">clicks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rows as $row) : ?>
                            <tr>
                            <td><?php echo $row->url; ?></td>
                            <td><a href="http://localhost/short-urls/u?id=<?php echo $row->id; ?>" target="_blank">http://localhost/short-urls/<?php echo $row->id; ?><a></td>
                            <td><?php echo $row->clicks; ?></td>
                            <td></td>
                            </tr>
                           <?php endforeach; ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
        <script>
            $(document).ready(function() {
                $("#refresh").click(function(){
                    setInterval(function(){
                        $("body").load('index.php')
                    }, 5000);
                });
            });
        </script>
    </body>
</html>