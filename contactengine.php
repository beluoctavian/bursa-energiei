<?php

$EmailFrom = "www.bursaenergiei.ro";
$EmailTo = "office@bursaenergiei.ro";
$Subject = Trim(stripslashes($_POST['Subject'])); 
$City = Trim(stripslashes($_POST['City'])); 
$Name = Trim(stripslashes($_POST['Name'])); 
$Telefon = Trim(stripslashes($_POST['Telefon'])); 
$Email = Trim(stripslashes($_POST['Email'])); 
$Message = Trim(stripslashes($_POST['Message'])); 

// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
  exit;
}

// prepare email body text
$Body = "";
$Body .= "Nume: ";
$Body .= $Name;
$Body .= "\n";
$Body .= "Oras: ";
$Body .= $City;
$Body .= "\n";
$Body .= "Telefon: ";
$Body .= $Telefon;
$Body .= "\n";
$Body .= "E-mail: ";
$Body .= $Email;
$Body .= "\n";
$Body .= "Mesaj: ";
$Body .= $Message;
$Body .= "\n";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

// redirect to success page 
if ($success){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=contactthanks.php\">";
}
else{
  print "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
}
?>