<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/icon.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js" integrity="sha384-7aThvCh9TypR7fIc2HV4O/nFMVCBwyIUKL8XCtKE+8xgCgl/PQGuFsvShjr74PBp" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<script>
    $(document).ready(function(){
        $("#num").click(function(){
            $(".global").slideToggle("slow");
        });
    });
</script>
<?php
include ('server.php');
include ('proces.php');

if(empty($_SESSION['username'])){
    header('location:index.php');
}

if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
    header('location:index.php');
}
?>

<div class="header">
    <div class="btn-group float-right mr-5 mt-5">
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
            echo $_SESSION['username'];
            ?>
        </button>
        <div class="dropdown-menu">
            <a href="admin.php?logout='1'">გამოსვლა</a>
        </div>
    </div>
    <h1>
        სია
        <?php
        $sql = "SELECT COUNT(id) AS list FROM motamasheebi";
        $res = mysqli_query($con,$sql);
        if(mysqli_num_rows($res)){
            $row = mysqli_fetch_assoc($res);
            echo 'რაოდენობა: ( '.$row['list'] .' )';
        }
        ?>
    </h1>
    <i id="num" class="material-icons">
        arrow_downward
    </i>
</div>
<div class="global">
<div class="gamarjvebulebi">
    <h1>გამარჯვებულები</h1>
    <?php
    $sql = "SELECT * FROM motamasheebi WHERE ricxvi < 6";
    $res = mysqli_query($con,$sql);
    if(mysqli_num_rows($res)){
        while($row = mysqli_fetch_assoc($res)){
            echo '<ul>'.'<li>'.'მომხმარებელი '.$row['username'].'</li>'.'<li>'.'მობილური '.$row['mobiluri'].'<li>'.'რიცხვი:  ( '.$row['ricxvi'].' )</li>'.'</ul>';
        }
    }
    ?>
</div>
<div class="wagebulebi">
    <h1>წაგებულები</h1>
    <?php
    $sql = "SELECT * FROM motamasheebi WHERE ricxvi > 5";
    $res = mysqli_query($con,$sql);
    if(mysqli_num_rows($res)){
        while($row = mysqli_fetch_assoc($res)){
            echo '<ul>'.'<li>'.'მომხმარებელი '.$row['username'].'</li>'.'<li>'.'მობილური '.$row['mobiluri'].'<li>'.'რიცხვი:  ( '.$row['ricxvi'].' )</li>'.'</ul>';
        }
    }
    ?>
</div>
    <div class="prod_list">
        <ul>
            <li>Galaxy s8 ( 1 )</li>
            <li>Power Bank ( 2 )</li>
            <li>Drone ( 3 )</li>
            <li>Camera ( 4 )</li>
            <li>Table ( 5 )</li>
        </ul>
    </div>
</div>
</body>
</html>