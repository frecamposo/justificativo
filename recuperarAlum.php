<?php
session_start();
$host="localhost";
$user="encuesta_uno";
$pass="E9.jLNWv]t556p";
$base="encuesta_encuesta";
$cone= mysqli_connect($host, $user, $pass, $base) ;

// consular si existe
if(!isset($_SESSION["user"])){
    header('Location: login.html');
}
// recuperacion de datos del alumno
$user= $_SESSION["user"];

// recuperar el correo del alumno
$sql="SELECT CORREO,nombre,pass FROM alum_2022_1 WHERE RUT='$user' GROUP BY RUT";
$reg= mysqli_query($cone,$sql);
$fila= mysqli_fetch_row($reg);
$correo=$fila[0];
$nombre=$fila[1];
$pass=$fila[2];




//enviar el correo con la clave
$to = $correo;
$subject = "Clave Encuesta Temprana: Recupera Contrasena";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 
$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>
<h1>Estimado Alumno:<b>$nombre</b></h1>
<p>La siguiente es su clave registrada en la base de datos:<b>$pass</b></p>
<p>$correo</p>
</body>
</html>";
 
mail($to, $subject, $message, $headers);

header('Location: ../mensaje3.html');

?>