<?php
session_start();

if(isset($_GET['action']))
{
    session_destroy();
    header('Location: index.php');
}

require_once('controller.php');

if(isset($_POST['login']) && $_POST['login'] === 'Login')
{
    $post = [];
    if(!(empty($_POST['username']) && empty($_POST['password'])))
    {
        $post['username'] = $_POST['username'];
        $post['password'] = sha1(sha1($_POST['password'],true));
    }
}
$data = AdminController::login($post);
echo $data;
if($data === true)
{
    $_SESSION['user'] = $post['username'];
    header('Location: dashboard.php'); 
}
else{
    $_SESSION['errorMessage'] = 'incorrect username or password';
    header('Location: index.php');
}

