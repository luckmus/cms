<?php              
      $filename = $_GET['filename'];
      $filename = '/distr/geturlpage.exe';
      $filename = urldecode($filename);
      $filename = preg_replace('..', '', $filename);
      $name = preg_replace('/^.*\//', '', $filename);
      header("Content-Type: text/xml");
      header("Content-Disposition: attachment; name=\"$name\"");
      
      echo stripslashes(getFile($fileId));
?>      