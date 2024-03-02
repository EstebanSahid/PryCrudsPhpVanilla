<?php
include '../Conexion/conexion.php';

if (isset($_GET["exec"]) and $_GET["exec"] == "respuestasView") {
    $sql = $pdo->prepare("SELECT * from respuestas WHERE pre_id = :val1");
    $sql->bindParam(':val1', $_POST['id_pregunta'], PDO::PARAM_INT);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);

    ?> 
    <ol class="list-group list-group-numbered">
        <?php foreach($listado as $lista){ ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class=""><?= $lista["res_texto"] ?></div>
                </div>
            </li>
        <?php } ?> 
    </ol>
    <?php
}

if (isset($_GET["exec"]) and $_GET["exec"] == "mostrarCurso") {
    $sql = $pdo->prepare("SELECT
                            cxd.cxd_fechaCreacion,
                            c.cu_nombre
                        FROM cursoxdocente cxd
                        INNER JOIN cursos c ON c.cu_id = cxd.cu_id
                        WHERE cxd.doc_id = :val1");
    $sql->bindParam(':val1', $_POST['id_doc']);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);

    ?> 
    <ol class="list-group list-group-numbered">
        <?php 
        if(!empty($listado)){
            foreach($listado as $lista){ ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"><?= $lista["cu_nombre"] ?></div>
                        <?= $lista["cxd_fechaCreacion"] ?>
                    </div>
                </li>
            <?php } 
        }else{ ?>
            <li class="d-flex justify-content-between align-items-start text-center">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">Sin Registros</div>
                    Por favor Asignar un Curso al Docente
                </div>
            </li>
        <?php } ?> 
    </ol>
    <?php
}

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch($accion){
    case "btnAgregar":
        recorrerPreguntas(
            $_POST['txt_pregunta'],
            $_POST["txt_idcurso"],
            $_POST["preguntas_array"],
            $_POST["txt_esCorrecto"]
        );
        break;
    case "btnEliminar":
        borrarRespuestas($_POST['txt_id']);
        break;
}

function borrarRespuestas($id_pregunta){
    global $pdo;
    $delete = $pdo->prepare("DELETE FROM respuestas WHERE pre_id = :val1");
    $delete->bindParam(':val1', $id_pregunta);
    if($delete->execute()){
        borrarPregunta($id_pregunta);
    }
}

function borrarPregunta($id_pregunta){
    global $pdo;
    $delete = $pdo->prepare("DELETE FROM preguntas WHERE pre_id = :val1");
    $delete->bindParam(':val1', $id_pregunta);
    if($delete->execute()){
        header("Location: ../Vistas/preguntasRespuestasView.php?guardado=true");
        exit();
    }else{
        header("Location: ../Vistas/preguntasRespuestasView.php?guardado=false");
        exit();
    }
}

function recorrerPreguntas($pregunta, $id_curso, $respuestas, $esCorrecto){
    $respuestasArray = json_decode($respuestas);
    $respuestaCorrecta = $esCorrecto;
    $indexrespuesta = [];
    $respuestas = [];
    $valorRespuesta = [];
    $respuestasFinal = [];

    foreach ($respuestasArray as $index => $respuesta) {
        $respuesta = rtrim($respuesta, 'x');
        array_push($indexrespuesta, $index);
        array_push($respuestas, $respuesta);

        if ($index + 1 == $respuestaCorrecta) {
            array_push($valorRespuesta, 1);
        } else {
            array_push($valorRespuesta, 0);
        }

        $respuestasFinal[] = [
            'respuesta' => $respuesta,
            'valorRespuesta' => $valorRespuesta[$index]
        ];
    }

    //print_r($respuestasFinal);
    /*foreach ($respuestasFinal as $respuestaItem) {
        $respuesta = $respuestaItem['respuesta'];
        $valorRespuesta = $respuestaItem['valorRespuesta'];

        echo "Respuesta: $respuesta - Valor de respuesta: $valorRespuesta <br>";
    }*/
    
    addPregunta($pregunta, $id_curso ,$respuestasFinal);

}

function addPregunta($pregunta, $id_curso ,$respuestasFinal){
    global $pdo;
    $insert = $pdo->prepare("INSERT INTO preguntas (pre_enunciado, pre_fechaRegistro, pre_estado, cu_id)
                            VALUES (:val1, NOW(), '1', :val2)");
    $insert->bindParam(':val1', $pregunta);
    $insert->bindParam(':val2', $id_curso);
    if($insert->execute()){
        $ultimoId = $pdo->lastInsertId();
        addRespuestas($respuestasFinal, $ultimoId);
    }
}

function addRespuestas($respuestasFinal, $id_pregunta){
    global $pdo;
    foreach ($respuestasFinal as $respuestaItem) {
        $respuesta = $respuestaItem['respuesta'];
        $valorRespuesta = $respuestaItem['valorRespuesta'];

        $insert = $pdo->prepare("INSERT INTO respuestas (res_texto, res_esCorrecto, pre_id)
                                VALUES (:val1, :val2, :val3)");
        $insert->bindParam(':val1', $respuesta);
        $insert->bindParam(':val2', $valorRespuesta);
        $insert->bindParam(':val3', $id_pregunta);
        $insert->execute();
    }
    header("Location: ../Vistas/preguntasRespuestasView.php?guardado=true");
    exit();
}