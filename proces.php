<?php

$msg = '';

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


if(isset($_POST['register'])){
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $password_2 = $_POST['password_2'];
    $ip = get_client_ip();

    if(empty($username)){
        array_push($errors,'მომხმარებლის ველი ცარიელია');
    }

    if(empty($email)){
        array_push($errors,'ემაილის ველი ცარიელია');
    }

    if(empty($password)){
        array_push($errors,'პაროლის ველი ცარიელია');
    }

    if($password != $password_2){
        array_push($errors,'პაროლები არ ემთხვევა');
    }

    if(!empty($password and strlen($password) != 8 )){
        array_push($errors,'პაროლი უნდა შედგებოდეს 8 ციფრისგან');
    }

    $sql = "SELECT * FROM users WHERE username='$username'";
    $res = mysqli_query($con,$sql);
    if(mysqli_num_rows($res)){
        array_push($errors,'ესეთი მომხმარებელი უკვე არსებობს<br><img src=\'img/user.png\' style=\'width: 70px; margin-top: 5px;\'>');
    }

    $sql = "SELECT * FROM users WHERE email='$email'";
    $res = mysqli_query($con,$sql);
    if(mysqli_num_rows($res)){
        array_push($errors,'ეს ემაილი უკვე გამოყენებულია<br><img src=\'img/email.png\' style=\'width: 70px; margin-top: 5px;\'>');
    }

    $sql = "SELECT * FROM users WHERE ip='$ip'";
    $res = mysqli_query($con,$sql);
    if(mysqli_num_rows($res) >= 1){
        array_push($errors,'თქვენ ვეღარ დარეგისტრირდებით<br>თქვენ ერთხელ გაიარეთ რეგისტრაცია !!!');
    }

    if(count($errors) == 0 ){
        $password = md5($password);
        $sql = "INSERT INTO users (ip,username,email,password) VALUES ('$ip','$username','$email','$password')";
        if(mysqli_query($con,$sql)){
            $msg = "რეგისტრაცია წარმატებულია<br><img src='img/corect.gif' style='width: 50px; margin-top: 5px;'><iframe src='sounds/corect.mp3' allow='autoplay' style='display: none;'></iframe>";
        }
    }
}



if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    if(empty($username)){
        array_push($errors,'მომხმარებლის ველი ცარიელია');
    }

    if(empty($password)){
        array_push($errors,'პაროლის ველი ცარიელია');
    }

    if(count($errors) == 0 ){
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
        $res = mysqli_query($con,$sql);
        if(mysqli_num_rows($res)){
            $row = mysqli_fetch_assoc($res);
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            if($username == 'admin'){
                header('location:admin.php');
            }else{
                header('location:home.php');
            }
        }else{
            array_push($errors,'მომხმარებლის სახელი ან პაროლი არასწორია');
        }
    }
}


if(isset($_POST['start'])){
    $mobiluri = mysqli_real_escape_string($con,$_POST['mobiluri']);
    $ricxvi = mysqli_real_escape_string($con,$_POST['ricxvi']);
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];

    if(empty($mobiluri)){
        array_push($errors,'მობილურის ველი ცარიელია');
    }

    if(empty($ricxvi)){
        array_push($errors,'რიცხვის ველი ცარიელია');
    }

    $sql = "SELECT * FROM motamasheebi WHERE mobiluri='$mobiluri'";
    $res = mysqli_query($con,$sql);
    if(mysqli_num_rows($res)){
        array_push($errors,'ეს მობილური უკვე გამოყენებულია');
    }

    $sql = "SELECT * FROM motamasheebi WHERE user_id='".$_SESSION['user_id']."'";
    $res = mysqli_query($con,$sql);
    if(mysqli_num_rows($res) != 0 ){
        array_push($errors,'თქვენ ერთხელ უკვე ითამაშეთ !!!');
    }

    if(count($errors) == 0 ){
        $sql = "INSERT INTO motamasheebi (username,user_id,mobiluri,ricxvi) VALUES ('$username','$user_id','$mobiluri','$ricxvi')";
        if(mysqli_query($con,$sql)){
            if($ricxvi == 1){
                $msg = "გილოცავთ თქვენ მოიგეთ  ( <b>Samsung Galaxy S8 </b>)<br><img src='img/win1.png' style='width: 450px; padding-top: 20px; padding-bottom: 20px;'><br>პრიზის მისაღებად დაგიკავშირდებით მითითებულ ნომერზე";
            }
            elseif($ricxvi == 2){
                $msg = "გილოცავთ თქვენ მოიგეთ  ( <b>Power Bank</b> )<br><img src='img/win2.png' style='width: 450px; padding-top: 20px; padding-bottom: 20px;'><br>პრიზის მისაღებად დაგიკავშირდებით მითითებულ ნომერზე";
            }
            elseif($ricxvi == 3){
                $msg = "გილოცავთ თქვენ მოიგეთ  ( <b>Drone</b> )<br><img src='img/win3.png' style='width: 450px; padding-top: 20px; padding-bottom: 20px;'><br>პრიზის მისაღებად დაგიკავშირდებით მითითებულ ნომერზე";
            }

            elseif($ricxvi == 4){
                $msg = "გილოცავთ თქვენ მოიგეთ  ( <b>Camera</b> )<br><img src='img/win4.png' style='width: 450px; padding-top: 20px; padding-bottom: 20px;'><br>პრიზის მისაღებად დაგიკავშირდებით მითითებულ ნომერზე";
            }

            elseif($ricxvi == 5){
                $msg = "გილოცავთ თქვენ მოიგეთ  ( <b>Tablet</b> )<br><img src='img/win5.png' style='width: 450px; padding-top: 20px; padding-bottom: 20px;'><br>პრიზის მისაღებად დაგიკავშირდებით მითითებულ ნომერზე";
            }
        }
    }
}

?>