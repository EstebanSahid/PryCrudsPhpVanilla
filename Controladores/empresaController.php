<?php 
include '../Conexion/conexion.php';

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch($accion){
    case "btnAgregar":
        $nombre_empresa = (isset($_POST['txt_nombre'])) ? $_POST['txt_nombre'] : "";
        $ruc = (isset($_POST['txt_RUC'])) ? $_POST['txt_RUC'] : "";
        $telefono = (isset($_POST['txt_telef'])) ? $_POST['txt_telef'] : "";
        $direccion = (isset($_POST['txt_dir'])) ? $_POST['txt_dir'] : "";

        $insert=$pdo->prepare("INSERT INTO empresa (emp_nombre, emp_RUC, emp_telefono, emp_direccion, emp_estado, emp_fechaCreacion, emp_fechaModificacion) 
        VALUES (:val1, :val2, :val3, :val4, '1', NOW(), NOW());");

        $insert->bindParam(':val1',$nombre_empresa);
        $insert->bindParam(':val2',$ruc);
        $insert->bindParam(':val3',$telefono);
        $insert->bindParam(':val4',$direccion);

        if ($insert->execute()) {
            header("Location: ../index.php?guardado=true");
            exit();
        } else {
            header("Location: ../index.php?guardado=false");
            exit();
        }
        break; 
    case "btnModificar":
        if((isset($_POST['txt_id']))){
            $id_empresa = $_POST['txt_id'];
            $nombre_empresa = $_POST['txt_nombre'];
            $ruc = $_POST['txt_RUC'];
            $telefono = $_POST['txt_telef'];
            $direccion = $_POST['txt_dir'];

            $update=$pdo->prepare("UPDATE empresa SET 
                emp_nombre = :val1,
                emp_RUC = :val2,
                emp_telefono = :val3,
                emp_direccion = :val4
                WHERE emp_id = :val5");

            $update->bindParam(':val1',$nombre_empresa);
            $update->bindParam(':val2',$ruc);
            $update->bindParam(':val3',$telefono);
            $update->bindParam(':val4',$direccion);
            $update->bindParam(':val5',$id_empresa);

            if ($update->execute()) {
                header("Location: ../index.php?editado=true");
                exit();
            } else {
                header("Location: ../index.php?editado=false");
                exit();
            }
        }else{
            header("Location: ../index.php?editado=false");
            exit();
        }
        break; 
    case "btnEliminar":
        if((isset($_POST['txt_id']))){
            $id_empresa = $_POST['txt_id'];

            $update=$pdo->prepare("UPDATE empresa SET 
                emp_estado = 0
                WHERE emp_id = :val1");

            $update->bindParam(':val1',$id_empresa);

            if ($update->execute()) {
                header("Location: ../index.php?eliminado=true");
                exit();
            } else {
                header("Location: ../index.php?eliminado=false");
                exit();
            }
        }else{
            header("Location: ../index.php?eliminado=false");
            exit();
        }
        break; 
    case "btnCancelar":
        echo $nombre_empresa;
        echo "Presionaste el can";
        break; 
}