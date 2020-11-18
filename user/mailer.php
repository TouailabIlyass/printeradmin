<?php

   $to = "hydrocontrol2020@gmail.com";
   $subject = "A New Order Has arrived !";
   
   $message = "<center><h1>A new order has arrived !</h1></center><br>\n";
   $message .= "<p>Go check it out !</b>\n";
   
   $header = "From:hydrocontrol2020@gmail.com \r\n";
   $header .= "MIME-Version: 1.0\r\n";
   $header .= "Content-type: text/html; charset=UTF-8\r\n";
   
   $retval = mail ($to, $subject, $message, $header);
   
   if( $retval == true ) {
      echo "Message sent successfully...";
   } else {
      echo "Message could not be sent...";
   }

?>