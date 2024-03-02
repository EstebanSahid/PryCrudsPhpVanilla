<?php 
include '../Conexion/conexion.php';

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

var_dump($accion);

switch($accion){
    case "btnAgregar":
        $pass1 = (isset($_POST['txt_password1'])) ? $_POST['txt_password1'] : "";
        $pass2 = (isset($_POST['txt_password'])) ? $_POST['txt_password'] : "";

        if (!empty($pass1) && $pass1 == $pass2 && strlen($pass1) > 5) {
            $passSha = md5($pass1);

            $insert=$pdo->prepare("INSERT INTO docente 
                                        (doc_primerNombre, doc_segundoNombre, doc_primerApellido, 
                                        doc_segundoApellido, doc_correo, doc_telefono, doc_direccion, 
                                        doc_estado, doc_clave, doc_fechaCreacion, 
                                        doc_fechaModificacion, ti_id, doc_numIdentificacion) 
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
                header("Location: ../Vistas/docenteView.php?guardado=true");
                exit();
            } else {
                header("Location: ../Vistas/docenteView.php?guardado=false");
                exit();
            }
        } else {
            header("Location: ../Vistas/docenteView.php?guardado=cdif");
            exit();
        }
        break;
    case "btnModificar":
        $pass1 = (isset($_POST['txt_password1'])) ? $_POST['txt_password1'] : "";
        $pass2 = (isset($_POST['txt_password'])) ? $_POST['txt_password'] : "";

        echo $pass1 . " " . $pass2;

        if ($pass1 == $pass2) {
            $passSha = md5($pass1);
            //echo "son iguales entra aqui " . $passSha;
            $update = $pdo->prepare("UPDATE docente SET
                                doc_primerNombre = :val1, 
                                doc_segundoNombre = :val2, 
                                doc_primerApellido = :val3, 
                                doc_segundoApellido = :val4, 
                                doc_correo = :val5, 
                                doc_telefono = :val6, 
                                doc_direccion = :val7, 
                                doc_fechaModificacion = NOW(), 
                                ti_id = :val9, 
                                doc_numIdentificacion = :val10
                                " . (!empty($_POST['txt_password']) ? ", doc_clave = :val8" : "") . "
                            WHERE doc_id = :val11");

            $update->bindParam(':val1', $_POST['txt_pNombre']);
            $update->bindParam(':val2', $_POST['txt_sNombre']);
            $update->bindParam(':val3', $_POST['txt_pApellido']);
            $update->bindParam(':val4', $_POST['txt_sApellido']);
            $update->bindParam(':val5', $_POST['txt_correo']);
            $update->bindParam(':val6', $_POST['txt_telefono']);
            $update->bindParam(':val7', $_POST['txt_direccion']);
            $update->bindParam(':val9', $_POST['txt_idti']);
            $update->bindParam(':val10', $_POST['txt_numIdentificacion']);
            $update->bindParam(':val11', $_POST['txt_iddocente']);
            if (!empty($_POST['txt_password'])) {
                $update->bindParam(':val8', $passSha);
            }
            
            if ($update->execute()) {
                header("Location: ../Vistas/docenteView.php?editado=true");
                exit();
            } else {
                header("Location: ../Vistas/docenteView.php?editado=false");
                exit();
            }
        } else {
            header("Location: ../Vistas/docenteView.php?guardado=cdif");
            exit();
        }
        break; 
    case "btnEliminar":
        if((isset($_POST['txt_id']))){
            $id_docente = $_POST['txt_id'];

            $update=$pdo->prepare("UPDATE docente SET 
                doc_estado = 0,
                doc_fechaModificacion = NOW(),
                doc_fechaInactivacion = NOW()
                WHERE doc_id = :val1");

            $update->bindParam(':val1',$id_docente);

            if ($update->execute()) {
                header("Location: ../Vistas/docenteView.php?eliminado=true");
                exit();
            } else {
                header("Location: ../Vistas/docenteView.php?eliminado=false");
                exit();
            }
        }else{
            header("Location: ../Vistas/docenteView.php?eliminado=false");
            exit();
        }
        break; 
}