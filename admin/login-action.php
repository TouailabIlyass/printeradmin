<?php
session_start();
require_once('controller.php');

if(isset($_GET['action']))
{
    session_destroy();
    header('Location: index.php');
}

if(isset($_POST['login']) && $_POST['login'] === 'Login')
{
    $post = [];
    if(!(empty($_POST['username']) && empty($_POST['password'])))
    {
        $post['username'] = $_POST['username'];
        $post['password'] = sha1(sha1($_POST['password'],true));
        $data = AdminController::login($post);
        if($data === true)
        {
            $_SESSION['user'] = $post['username'];
            header('Location: dashboard.php'); 
        }
        else{
            $_SESSION['errorMessage'] = 'incorrect username or password';
            header('Location: index.php');
        }
    }
    else{
        $_SESSION['errorMessage'] = 'username or password can\'t be empty';
        header('Location: index.php');
    }
    
}


