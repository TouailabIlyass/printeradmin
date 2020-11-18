<?php

require_once('../admin/controller.php');

$fileName = '';

//file upload function
function upload_file() {

  $message = '';
  global $fileName;
  $dest_path = NULL;

  if (isset($_POST['send']) && $_POST['send'] == 'order')
  {
    if (isset($_FILES['designfile']) && $_FILES['designfile']['error'] === UPLOAD_ERR_OK)
    {
      // get details of the uploaded file
      $fileTmpPath = $_FILES['designfile']['tmp_name'];
      $fileName = $_FILES['designfile']['name'];
      $fileSize = $_FILES['designfile']['size'];
      $fileType = $_FILES['designfile']['type'];
      $fileNameCmps = explode(".", $fileName);
      $fileExtension = strtolower(end($fileNameCmps));

      // sanitize file-name
      //$newFileName = md5(time() . $fileName) . '.' . $fileExtension;

      // check if file has one of the following extensions
      $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'zip');

      if (in_array($fileExtension, $allowedfileExtensions))
      {
        // directory in which the uploaded file will be moved
        $uploadFileDir = '../uploaded_designs/';

        //////////////////////////////////
        $date = new DateTime();
        $fileName = $date->getTimestamp().'.'.$fileExtension;
        
        $dest_path = $uploadFileDir . $fileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) 
        {
          $message ='File is successfully uploaded.';
        }
        else 
        {
          $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
        }
      }
      else
      {
        $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
      }
    }
    else
    {
      $message = 'There is some error in the file upload. Please check the following error.<br>';
    }
  }

  return $message;
}


//gathering forms data

$data = [];

if (isset($_POST['send']) && $_POST['send'] == 'order') {

  upload_file();
  
  $data['firstname'] = $_POST['firstname'];
  $data['lastname'] = $_POST['lastname'];
  $data['email'] = $_POST['email'];
  $data['postal_code'] = $_POST['postalcode'];
  $data['width'] = $_POST['width'];
  $data['height'] = $_POST['height'];
  $data['address'] = $_POST['address'];
  $data['phone'] = $_POST['phone'];
  $data['file_name'] = $fileName;

}


//add order
$status = AdminController::addOrder($data);

if($status) header("Location: thanks.html");

else header("Location: index.html");


?>