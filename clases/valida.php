<?php

session_start();
$host="localhost";
$user="root";
$pass="";
$base="justificar_asistencia";

$cone= mysqli_connect($host, $user, $pass, $base) ;

// recupera los datos  
$user=$_POST["txtUsuario"];
$_SESSION["user"]=$user;
$pass=$_POST["txtPass"];

// saber si es Alumno
$sql_alum="SELECT count(*) from alumnos_2022_1 WHERE rut_alumno='$user'";
$reg_alum=mysqli_query($cone,$sql_alum);
$fila_alum=mysqli_fetch_row($reg_alum);
$SW=0;

if($fila_alum[0]>0){
    $SW=1;
    //saber si tiene o no una password
    $sql2="SELECT count(*) FROM alumnos_2022_1 WHERE rut_alumno='$user' and pass=''";
    $reg = mysqli_query($cone, $sql2);
    $fila = mysqli_fetch_row($reg);
    if($fila[0]>0){
        
        header('Location: ../web/proceso_a.php');
    }else{
        // verificar que la pass sea la correcta
        $sql_llave="SELECT count(*) FROM `alumnos_2022_1` WHERE rut_alumno='$user' and trim(pass)='$pass'";
        $reg_llave = mysqli_query($cone,$sql_llave);
        $fila_llave = mysqli_fetch_row($reg_llave);
        if($fila_llave[0]>0){
            header('Location: ../web/HomeAlumno.php');
        }else{
            //echo "mensaje alumno.".$sql_llave;
            header('Location: ../web/mensaje_acceso.html');
            
        }
        
    }
    
    
}

if($SW==0){
    header('Location: ../web/Login.html');
}
