<?php 
include '../Conexion/conexion.php';

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch($accion){
    case "btnAgregar":
        //var_dump($_POST);
        $esExamen = (isset($_POST['check_esExamen']) ? 1 : 0);
        $numPreguntas = ($_POST['txt_numPreguntas'] == '' ? 0 : $_POST['txt_numPreguntas']);
        $comentarios = (isset($_POST['txt_area_comentarios']) ? $_POST['txt_area_comentarios'] : "");


        $insert=$pdo->prepare("INSERT INTO planificacion 
                                        (plan_tema, plan_lugar, plan_comentarios, plan_estado, plan_fechaRegistro, cu_id, plan_esExamen " . (($esExamen == 1) ? ", plan_numPreguntas" : "") . ") 
                                VALUES 
                                        (:val1, :val2, :val3, '1', NOW(), :val4, :val5 " . (($esExamen == 1) ? ", :val6" : "") . ");");

        $insert->bindParam(':val1', $_POST['txt_nombre']);
        $insert->bindParam(':val2', $_POST['txt_lugar']);
        $insert->bindParam(':val3', $comentarios);
        $insert->bindParam(':val4', $_POST['id_curso']);
        $insert->bindParam(':val5', $esExamen);
        if ($esExamen == 1) {
            $insert->bindParam(':val6', $numPreguntas);
        }

        if ($insert->execute()) {
            header("Location: ../Vistas/planifView.php?guardado=true");
            exit();
        } else {
            header("Location: ../Vistas/planifView.php?guardado=false");
            exit();
        }
        break;
    case "btnModificar":
        $curso = trim($_POST['txt_curso'], " \t\n\r\0\x0B");

        $autenticidad = $pdo->prepare("SELECT * FROM cursos WHERE cu_nombre = :val1");
        $autenticidad->bindParam(':val1', $curso);
        $autenticidad -> execute();

        $existe = $autenticidad->rowCount();

        if($existe > 0){
            header("Location: ../Vistas/planifView.php?editado=existe");
        }else{
            $update = $pdo->prepare("UPDATE cursos SET
                                cu_nombre = :val1, 
                                cu_fechaModificacion = NOW()
                            WHERE cu_id = :val2");

            $update->bindParam(':val1', $_POST['txt_curso']);
            $update->bindParam(':val2', $_POST['txt_id']);

            if ($update->execute()) {
                header("Location: ../Vistas/planifView.php?editado=true");
                exit();
            } else {
                header("Location: ../Vistas/planifView.php?editado=false");
                exit();
            }
        }
        break; 
    case "btnEliminar":
        if((isset($_POST['txt_id']))){
            $id_docente = $_POST['txt_id'];

            $update=$pdo->prepare("UPDATE cursos SET 
                cu_estado = 0,
                cu_fechaModificacion = NOW()
                WHERE cu_id = :val1");

            $update->bindParam(':val1',$id_docente);

            if ($update->execute()) {
                header("Location: ../Vistas/planifView.php?eliminado=true");
                exit();
            } else {
                header("Location: ../Vistas/planifView.php?eliminado=false");
                exit();
            }
        }else{
            header("Location: ../Vistas/planifView.php?eliminado=false");
            exit();
        }
        break; 
}