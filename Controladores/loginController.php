<?php 
include '../Conexion/conexion.php';

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch($accion){
    /*case "btnEst":
        $usu = $_POST['txt_user'];
        $pass = md5($_POST['txt_pass']);

        $login = $pdo->prepare("SELECT * FROM estudiante WHERE est_correo = :val1 AND est_clave = :val2");
        $login->bindParam(':val1', $usu);
        $login->bindParam(':val2', $pass );
        $login->execute();
        $existe = $login->rowCount();

        if($existe > 0){
            header("Location: ../../../index2.php");
            exit();
        }else{
            header("Location: ../../../Vistas/Logins/loginEstudiante.php?incorrecto=true");
            exit();
        }
        break;*/
    case "btnAdmin":
        $usu = $_POST['txt_user'];
        $pass = md5($_POST['txt_pass']);

        buscarDocente($usu, $pass);
        break; 
}

function buscarDocente($usu, $pass){
    global $pdo;
    $login = $pdo->prepare("SELECT * FROM docente WHERE doc_correo = :val1 AND doc_clave = :val2");
    $login->bindParam(':val1', $usu);
    $login->bindParam(':val2', $pass );
    $login->execute();
    $existe = $login->rowCount();

    if($existe > 0){
        header("Location: ../index2.php");
        exit();
    }else{
        buscarEstudiante($usu, $pass);
    }
}

function buscarEstudiante($usu, $pass){
    global $pdo;
    $login = $pdo->prepare("SELECT * FROM estudiante WHERE est_correo = :val1 AND est_clave = :val2");
    $login->bindParam(':val1', $usu);
    $login->bindParam(':val2', $pass );
    $login->execute();
    $existe = $login->rowCount();

    if($existe > 0){
        header("Location: ../index2.php");
        exit();
    }else{
        header("Location: ../index.php?incorrecto=true");
        exit();
    }
}