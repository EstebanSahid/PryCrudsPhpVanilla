<?php 
include '../Conexion/conexion.php';

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch($accion){
    case "btnAgregar":
        $pass1 = (isset($_POST['txt_password1'])) ? $_POST['txt_password1'] : "";
        $pass2 = (isset($_POST['txt_password'])) ? $_POST['txt_password'] : "";

        if (!empty($pass1) && $pass1 == $pass2 && strlen($pass1) > 5) {
            $passSha = md5($pass1);

            $insert=$pdo->prepare("INSERT INTO estudiante 
                                        (est_primerNombre, est_segundoNombre, est_primerApellido, 
                                        est_segundoApellido, est_correo, est_telefono, est_direccion, 
                                        est_estado, est_clave, est_fechaCreacion, 
                                        est_fechaModificacion, ti_id, est_numIdentificacion) 
                                    VALUES 
                                        (:val1, :val2, :val3, :val4, :val5, :val6, :val7, '1', :val8, NOW(), NOW(), :val9,:val10);
            ");

            $insert->bindParam(':val1',$_POST['txt_pNombre']);
            $insert->bindParam(':val2',$_POST['txt_sNombre']);
            $insert->bindParam(':val3',$_POST['txt_pApellido']);
            $insert->bindParam(':val4',$_POST['txt_sApellido']);
            $insert->bindParam(':val5',$_POST['txt_correo']);
            $insert->bindParam(':val6',$_POST['txt_telefono']);
            $insert->bindParam(':val7',$_POST['txt_direccion']);
            $insert->bindParam(':val8',$passSha);
            $insert->bindParam(':val9',$_POST['txt_idti']);
            $insert->bindParam(':val10',$_POST['txt_numIdentif']);

            if ($insert->execute()) {
                header("Location: ../Vistas/alumnoView.php?guardado=true");
                exit();
            } else {
                header("Location: ../Vistas/alumnoView.php?guardado=false");
                exit();
            }
        } else {
            header("Location: ../Vistas/alumnoView.php?guardado=cdif");
            exit();
        }
        break;
    case "btnModificar":
        $pass1 = (isset($_POST['txt_password1'])) ? $_POST['txt_password1'] : "";
        $pass2 = (isset($_POST['txt_password'])) ? $_POST['txt_password'] : "";

        if ($pass1 == $pass2) {
            $passSha = md5($pass1);
            $update = $pdo->prepare("UPDATE estudiante SET
                                est_primerNombre = :val1, 
                                est_segundoNombre = :val2, 
                                est_primerApellido = :val3, 
                                est_segundoApellido = :val4, 
                                est_correo = :val5, 
                                est_telefono = :val6, 
                                est_direccion = :val7, 
                                est_fechaModificacion = NOW(), 
                                ti_id = :val9, 
                                est_numIdentificacion = :val10
                                " . (!empty($_POST['txt_password']) ? ", est_clave = :val8" : "") . "
                            WHERE est_id = :val11");

            $update->bindParam(':val1', $_POST['txt_pNombre']);
            $update->bindParam(':val2', $_POST['txt_sNombre']);
            $update->bindParam(':val3', $_POST['txt_pApellido']);
            $update->bindParam(':val4', $_POST['txt_sApellido']);
            $update->bindParam(':val5', $_POST['txt_correo']);
            $update->bindParam(':val6', $_POST['txt_telefono']);
            $update->bindParam(':val7', $_POST['txt_direccion']);
            $update->bindParam(':val9', $_POST['txt_idti']);
            $update->bindParam(':val10', $_POST['txt_numIdentificacion']);
            $update->bindParam(':val11', $_POST['txt_idAlumno']);
            if (!empty($_POST['txt_password'])) {
                $update->bindParam(':val8', $passSha);
            }

            if ($update->execute()) {
                header("Location: ../Vistas/alumnoView.php?editado=true");
                exit();
            } else {
                header("Location: ../Vistas/alumnoView.php?editado=false");
                exit();
            }
        } else {
            header("Location: ../Vistas/alumnoView.php?guardado=cdif");
            exit();
        }
        break; 
    case "btnEliminar":
        if((isset($_POST['txt_id']))){
            $id_docente = $_POST['txt_id'];

            $update=$pdo->prepare("UPDATE estudiante SET 
                est_estado = 0,
                est_fechaModificacion = NOW(),
                est_fechaInactivacion = NOW()
                WHERE est_id = :val1");

            $update->bindParam(':val1',$id_docente);

            if ($update->execute()) {
                header("Location: ../Vistas/alumnoView.php?eliminado=true");
                exit();
            } else {
                header("Location: ../Vistas/alumnoView.php?eliminado=false");
                exit();
            }
        }else{
            header("Location: ../Vistas/alumnoView.php?eliminado=false");
            exit();
        }
        break; 
}