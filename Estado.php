<?php
ini_set('session.gc_maxlifetime', 7200);
session_start();
?>
<?php
include './clases/conexion.php';

$user = $_SESSION["user"];
//echo "<h1>usuario:".$user."</h1>";
if($user==''){
    header("Location: login.html");

}
$sql = "select * from alum_2022_1 where rut='$user'";
$resp = mysqli_query($cone, $sql);
while ($f = mysqli_fetch_array($resp)) {
    $nombre = $f[1];
}

if($nombre==''){
    $sql_uap = "select * from uap where rut='$user'";
    $resp_aup = mysqli_query($cone, $sql_uap);
    while ($f = mysqli_fetch_array($resp_aup)) {
        $rut = $f[0];
        $nombre = $f[1];
        
    }
    if($nombre!=''){
        header("Location: indexUAP.php");}
    else{
        header("Location: indexP.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Encuesta Temprana</title>
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top" style="background-image: url('img/cd747fae56cea74a8fdcbaaba43f3b66.jpg')">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <span class="d-block d-lg-none"><?php echo $nombre; ?></span>
              <!--  <span class="d-none d-lg-block"><img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="img/profe.jpg" alt="" /></span>-->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="respuestas.php">Tus Respuestas</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php">Tus Asignaturas</a></li>
                     
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="clases/cerrar_s.php">Cerrar Sesion</a></li>
                </ul>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container">
            <!-- About-->
            <section style="margin-top: 40px;">
                <div>
                    <h2 style="color: #bd2130">Tus Asignaturas</h2>
                    <hr>
                    <h3>
                        <font style="color: #bd2130">Alumno:</font> <?php echo $nombre." - Rut: ".$user; ?>                        
                    </h3>
                    <div>
                        Listado de las asignaturas que cursa este año:
                    </div>                    
                </div>
            </section>
            <section style="margin-top: 40px">
                <div style="font-size: 12px">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr style="background-color: #007bff;color: white;">
                                <td>NOMBRE ASIGNATURA</td>
                                <td>SECCION</td>
                                <td>INSTRUCTOR</td>
                                <td>NOMBRE SECCION</td>
                                <TD>OPCION</TD>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select DISTINCT al.`Descripcion Asignatura`,al.`Seccion`,pro.`INSTRUCTOR`,pro.`NOMBRE_SECCION`,pro.`RUT`,al.`status`
                                    from alum_2022_1 al inner join prof_2022_1 pro on al.`Seccion`=pro.`SECCION` where al.`Rut`='$user';";
                            $resp = mysqli_query($cone, $sql);
                            //echo "SQL SELECCION:".$sql;
                            while ($f = mysqli_fetch_array($resp)) {
                                ?>
                                <tr>
                                    <td><?php echo $f[0] ?></td>
                                    <td><?php echo $f[1] ?></td>
                                    <td><?php echo $f[2] ?></td>
                                    <td><?php echo $f[3] ?></td>
                                    <?php
                                    $sql2="select count(*) from respuestas_2022_1 where rut_alumno='$user' and rut_profesor='$f[4]' and seccion='$f[1]';";
                                    $cantidad2= mysqli_query($cone, $sql2);
                                    $numeros= mysqli_fetch_row($cantidad2);
                                    //echo 'cantidad:'.$numeros[0].'  - sql:'.$sql2.' \n';
                                    ?>
                                    <td>
                                        <?php 
                                        
                                        if($f[5]>0) { ?> 
                                            <?php if ($numeros[0]>0) { ?>
                                                <button class="btn btn-primary">Realizada</button>
                                            <?php }else{ ?>
                                            <form action="encuesta.php" method="post">
                                                <input type="hidden" name="txtRutProfe" value="<?php echo $f[4] ?>">
                                                <input type="hidden" name="txtSeccion" value="<?php echo $f[1] ?>">
                                                <input type="hidden" name="txtRutAlumno" value="<?php echo $f[1] ?>">
                                                
                                                <button class="btn btn-success">Realizar Encuesta</button>
                                            </form>
                                            <?php } ?>                                        
                                            <?php }else { ?>
                                            <button class="btn btn-warning">Bloqueada</button>
                                        <?php } ?>
                                        
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
