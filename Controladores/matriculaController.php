<?php
include '../Conexion/conexion.php';

if (isset($_GET["exec"]) and $_GET["exec"] == "selectCurso") {
    $sql = $pdo->prepare("SELECT c.cu_nombre, c.cu_id
                            FROM cursos c
                            WHERE c.cu_id NOT IN (
                                SELECT cxd.cu_id
                                FROM cursoxdocente cxd
                                INNER JOIN matricula m ON m.cxd_id = cxd.cxd_id
                                WHERE m.est_id = :val1
                            )");
    $sql->bindParam(':val1', $_POST['id_alumno']);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    ?> 
        <div class="form-floating">
            <select class="form-select" id="id_curso" name="txt_id_curso" aria-label="Floating label select example" required>
                <?php if(empty($listado)){ ?>
                    <option value="0">Cursos No Disponibles</option>
                <?php }else{ ?>
                <option value="0">- Seleccionar Curso -</option>
                <?php foreach($listado as $lista){ ?>
                <option value="<?= $lista["cu_id"]; ?>">
                    <?= $lista["cu_nombre"]; ?>
                </option>
                <?php }
                } ?>
            </select>
            <label for="id_curso">Cursos Disponibles</label>
        </div>
    <?php
}

if (isset($_GET["exec"]) and $_GET["exec"] == "selectDocente") {
    $sql = $pdo->prepare("SELECT 
                                CONCAT(d.doc_primerApellido,' ',d.doc_segundoApellido, ' ', d.doc_primerNombre) as docente,
                                d.doc_id,
                                cxd.cxd_id
                            FROM cursoxdocente cxd 
                            INNER JOIN docente d ON d.doc_id = cxd.doc_id
                            WHERE cu_id = :val1");
    $sql->bindParam(':val1', $_POST['id_curso']);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    ?> 
        <div class="form-floating">
            <select class="form-select" id="id_curso" name="txt_id_docente" aria-label="Floating label select example" required>
                <?php if(empty($listado)){ ?>
                    <option value="0">Sin Docentes Asignados</option>
                <?php }else{ ?>
                    <option value="0">- Seleccionar Docente -</option>
                <?php foreach($listado as $lista) { ?>
                    <option value="<?= $lista["cxd_id"]; ?>">
                        <?= $lista["docente"]; ?>
                    </option>
                <?php } 
                } ?>
            </select>
            <label for="id_curso">Docentes Asignados</label>
        </div>

    <?php
}

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch($accion){
    case "btnAgregar":
        //var_dump($_POST);
        $id_alumno = (isset($_POST['txt_id_alumno'])) ? $_POST['txt_id_alumno'] : 0;
        $id_curso = (isset($_POST['txt_id_curso'])) ? $_POST['txt_id_curso'] : 0;
        $id_docente = (isset($_POST['txt_id_docente'])) ? $_POST['txt_id_docente'] : 0;

        $valido = ($id_alumno != 0 && $id_curso != 0 && $id_docente != 0);

        if($valido){
            $insert = $pdo->prepare("INSERT INTO matricula 
                                (mat_estado, mat_fechaCreacion, cxd_id, est_id)
                            VALUES 
                                ('A', NOW(), :val1, :val2)");

            $insert->bindParam(':val1', $id_docente);
            $insert->bindParam(':val2', $id_alumno);

            if ($insert->execute()) {
                $ultimo_id_insertado = $pdo->lastInsertId();

                $inserMatricula = $pdo->prepare("INSERT INTO evaluacion 
                                                    (ev_notaMaxima, ev_fechaEvaluacion, mat_id)
                                                VALUES 
                                                    (10, NOW(), :val1)");
                
                $inserMatricula->bindParam(':val1', $ultimo_id_insertado);
                if($inserMatricula->execute()){
                    header("Location: ../Vistas/matriculaView.php?guardado=true");
                    exit();
                }else{
                    header("Location: ../Vistas/matriculaView.php?guardado=false");
                    exit();
                }
            } else {
                header("Location: ../Vistas/matriculaView.php?guardado=false");
                exit();
            }
        }else{
            header("Location: ../Vistas/matriculaView.php?guardado=incompleto");
            exit();
        }
        break;
}
