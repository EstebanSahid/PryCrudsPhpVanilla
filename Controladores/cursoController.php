<?php 
include '../Conexion/conexion.php';

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

var_dump($accion);

switch($accion){
    case "btnAgregar":

        $curso = trim($_POST['txt_curso'], " \t\n\r\0\x0B");

        $autenticidad = $pdo->prepare("SELECT * FROM cursos WHERE cu_nombre = :val1");
        $autenticidad->bindParam(':val1', $curso);
        $autenticidad -> execute();

        $existe = $autenticidad->rowCount();

        if($existe > 0){
            header("Location: ../Vistas/cursoView.php?guardado=existe");
        }else{
            $insert=$pdo->prepare("INSERT INTO cursos 
                                        (cu_nombre, cu_estado, cu_fechaCreacion, 
                                        cu_fechaModificacion, emp_id) 
                                    VALUES 
                                        (:val1, '1', NOW(), NOW(), '1');
            ");

            $insert->bindParam(':val1',$curso);
            if ($insert->execute()) {
                header("Location: ../Vistas/cursoView.php?guardado=true");
                exit();
            } else {
                header("Location: ../Vistas/cursoView.php?guardado=false");
                exit();
            }
        }
        break;
    case "btnModificar":
        $curso = trim($_POST['txt_curso'], " \t\n\r\0\x0B");

        $autenticidad = $pdo->prepare("SELECT * FROM cursos WHERE cu_nombre = :val1");
        $autenticidad->bindParam(':val1', $curso);
        $autenticidad -> execute();

        $existe = $autenticidad->rowCount();

        if($existe > 0){
            header("Location: ../Vistas/cursoView.php?editado=existe");
        }else{
            $update = $pdo->prepare("UPDATE cursos SET
                                cu_nombre = :val1, 
                                cu_fechaModificacion = NOW()
                            WHERE cu_id = :val2");

            $update->bindParam(':val1', $_POST['txt_curso']);
            $update->bindParam(':val2', $_POST['txt_id']);

            if ($update->execute()) {
                header("Location: ../Vistas/cursoView.php?editado=true");
                exit();
            } else {
                header("Location: ../Vistas/cursoView.php?editado=false");
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
                header("Location: ../Vistas/cursoView.php?eliminado=true");
                exit();
            } else {
                header("Location: ../Vistas/cursoView.php?eliminado=false");
                exit();
            }
        }else{
            header("Location: ../Vistas/cursoView.php?eliminado=false");
            exit();
        }
        break; 
}