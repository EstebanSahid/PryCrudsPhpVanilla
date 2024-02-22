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
        echo "clic a editar";
        /*if((isset($_POST['txt_id']))){
            $id_empresa = $_POST['txt_id'];
            $nombre_empresa = $_POST['txt_nombre'];
            $ruc = $_POST['txt_RUC'];
            $telefono = $_POST['txt_telef'];
            $direccion = $_POST['txt_dir'];

            $update=$pdo->prepare("UPDATE empresa SET 
                emp_nombre = :val1,
                emp_RUC = :val2,
                emp_telefono = :val3,
                emp_direccion = :val4,
                emp_fechaModificacion = NOW()
                WHERE emp_id = :val5");

            $update->bindParam(':val1',$nombre_empresa);
            $update->bindParam(':val2',$ruc);
            $update->bindParam(':val3',$telefono);
            $update->bindParam(':val4',$direccion);
            $update->bindParam(':val5',$id_empresa);

            if ($update->execute()) {
                header("Location: ../Vistas/docenteView.php?editado=true");
                exit();
            } else {
                header("Location: ../Vistas/docenteView.php?editado=false");
                exit();
            }
        }else{
            header("Location: ../Vistas/docenteView.php?eliminado=false");
            exit();
        }*/
        break; 
    case "btnEliminar":
        if((isset($_POST['txt_id']))){
            $id_empresa = $_POST['txt_id'];

            $update=$pdo->prepare("UPDATE empresa SET 
                emp_estado = 0,
                emp_fechaModificacion = NOW()
                WHERE emp_id = :val1");

            $update->bindParam(':val1',$id_empresa);

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