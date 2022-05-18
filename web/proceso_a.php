<?php
session_start();
$host="localhost";
$user="root";
$pass="";
$base="justificar_asistencia";
$cone= mysqli_connect($host, $user, $pass, $base) ;

// consular si existe
if(!isset($_SESSION["user"])){
    header('Location: ../web/Login.html');
}
// recuperacion de datos del alumno
$user= $_SESSION["user"];

// recuperar el correo del alumno
$sql="SELECT CORREO,Nombre FROM alumnos_2022_1 WHERE rut_alumno='$user' GROUP BY rut_alumno";
$reg= mysqli_query($cone,$sql);
$fila= mysqli_fetch_row($reg);
$correo=$fila[0];
$nombre=$fila[1];

//creacion de la clave
$opc_letras = TRUE; //  FALSE para quitar las letras
$opc_numeros = TRUE; // FALSE para quitar los números
$opc_letrasMayus = TRUE; // FALSE para quitar las letras mayúsculas
$opc_especiales = FALSE; // FALSE para quitar los caracteres especiales
$longitud = 10;
$password = "";
 
$letras ="abcdefghijklmnopqrstuvwxyz";
$numeros = "1234567890";
$letrasMayus = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$especiales ="|@#~$%()=^*+[]{}-_";
$listado = "";
 
if ($opc_letras == TRUE) {
    $listado .= $letras; }
if ($opc_numeros == TRUE) {
    $listado .= $numeros; }
if($opc_letrasMayus == TRUE) {
    $listado .= $letrasMayus; }
if($opc_especiales == TRUE) {
    $listado .= $especiales; }
 
str_shuffle($listado);
for( $i=1; $i<=$longitud; $i++) {
    $password[$i] = $listado[rand(0,strlen($listado))];
    str_shuffle($listado);
}
///echo "OK:".$password;



//enviar el correo con la clave
$to = $correo;
$subject = "Clave Justificar Asistencia";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 
$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>
<h1>Estimado Alumno:<b>$nombre</b></h1>
<p>La siguiente es su clave de acceso provisoria:<b>$password</b></p>
</body>
</html>";
 
mail($to, $subject, $message, $headers);

//modificar la clave por la provisoria
$sql2="UPDATE alumnos_2022_1 set pass='$password' WHERE RUT_ALUMNO='$user'";
$reg = mysqli_query($cone,$sql2);
//echo "OK Listo el envio";
header('Location: mensaje_acceso.html');
?>