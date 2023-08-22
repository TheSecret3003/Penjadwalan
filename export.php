<?php  
 //export.php  
 if(isset($_POST["create_word"]))  
 {  
      if(empty($_POST["heading"]) || empty($_POST["description"]))  
      {  
           echo '<script>alert("Both Fields are required")</script>';  
           echo '<script>window.location = "index.php"</script>';  
      }  
      else  
      {  
           header("Content-type: application/vnd.ms-word");  
           header("Content-Disposition: attachment;Filename=jadwal.doc");  
           header("Pragma: no-cache");  
           header("Expires: 0");  
           echo '<h1>'.$_POST["heading"].'</h1>';  
           echo $_POST["description"];  
      }  
 }  
 ?>  