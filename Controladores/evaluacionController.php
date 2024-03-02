<?php
include '../Conexion/conexion.php';


$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
/*$listo = "";
if(isset($_POST['modal_cerrado'])){
    $listo = "h";
}

$formularioCerrado = ($listo == "" ? true : false);


//echo $formularioCerrado;

if(!$formularioCerrado){
    $numPreguntas = 0;
    $idevaluacion = $_POST['txt_id_evaluacion'];
    foreach ($_POST['pregunta'] as $indice => $valor) {
        guardarCerradoModal($indice, $idevaluacion);
    }
    header("Location: ../Vistas/evaluacionView.php");
    exit();
}*/

function guardarCerradoModal($id_pregunta, $id_evaluacion){
    global $pdo;
    $insert=$pdo->prepare("INSERT INTO evaluaciondetalle 
                                (evd_esCorrecto, pre_id, ev_id) 
                            VALUES 
                                (0, :val1, :val2);");

    $insert->bindParam(':val1',$id_pregunta);
    $insert->bindParam(':val2',$id_evaluacion);
    $insert->execute();

    updateCalifCerradoModal($id_evaluacion);
}

function updateCalifCerradoModal($id_evaluacion){
    global $pdo;
    $update = $pdo->prepare("UPDATE evaluacion SET
                                ev_nota = 1 
                            WHERE ev_id = :val1");
    $update->bindParam(':val1', $id_evaluacion);
    $update->execute();
}

if (isset($_GET["exec"]) and $_GET["exec"] == "traerRespuesta") {
    $sql = $pdo->prepare("SELECT 
                            p.pre_enunciado, 
                            r.res_texto, 
                            ed.evd_esCorrecto,
                            IF(ed.evd_esCorrecto = 0 && ed.res_id IS NULL,0,1) as resp 
                        FROM preguntas p 
                            INNER JOIN evaluaciondetalle ed ON ed.pre_id = p.pre_id
                            LEFT JOIN respuestas r ON r.res_id = ed.res_id
                        WHERE ed.ev_id =:val1");
    $sql->bindParam(':val1', $_POST['id_evaluacion']);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);

    ?> 
    <ol class="list-group list-group-numbered">
        <?php foreach($listado as $lista){ ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold"><?= $lista["pre_enunciado"] ?></div>
                    <?php if($lista['resp'] == 1){ ?>
                        <?= $lista["res_texto"] ?>
                    <?php }else{?>
                        No Respondido
                    <?php } ?>
                    
                </div>
                <?php if($lista['evd_esCorrecto'] == 0){ ?>
                    <span class="badge text-bg-danger rounded-pill">X</span>
                <?php }else{ ?>
                    <span class="badge text-bg-primary rounded-pill">✓</span>
                <?php } ?>
            </li>
        <?php } ?> 
    </ol>
    <?php
}

if (isset($_GET["exec"]) and $_GET["exec"] == "traerEvaluacion") {
    $id_curso = $_POST['id_curso'];
    $nPreguntas = limitEvaluacion($id_curso);
    $listaPreguntas = traerPreguntas($id_curso, $nPreguntas);

    if(!empty($listaPreguntas)){
    ?> 
    <form action="../Controladores/evaluacionController.php" method="post" id="form_evaluacion">
        <input type="hidden" name="modal_cerrado" id="modal_cerrado">
        <input type="hidden" name="txt_id_evaluacion" id="txt_id_evaluacion" value="<?= $_POST['id_evaluacion'] ?>">
        <ol class="list-group list-group-numbered">
            <?php foreach($listaPreguntas as $pregunta){ 
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"><?= $pregunta["pre_enunciado"] ?></div>
                        <input type="hidden" name="pregunta[<?= $pregunta['pre_id'] ?>]">
                        <?php $listaRespuestas = traerRespuestas($pregunta['pre_id']);  
                        foreach($listaRespuestas as $respuesta){
                            ?>
                            <div class="form-check">
                                    <input class="form-check-input" type="radio" name="respuesta[<?= $pregunta['pre_id'] ?>]" id="respuesta_<?= $respuesta['res_id'] ?>" value="<?= $respuesta['res_id'] ?>">
                                    <label class="form-check-label" for="respuesta_<?= $respuesta['res_id'] ?>">
                                        <?= $respuesta['res_texto']; ?>
                                    </label>
                                </div>
                            <?php
                        }
                        ?>
                    </div>
                </li>
            <?php } ?> 
        </ol>
        <hr>
        <div class="row">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                <button value="btnAgregar" type="submit" name="accion" class="btn btn-primary">Finalizar</button>
            </div>
        </div>
    </form>
    <?php
    }else{
        ?> 
        <p class="text-center">No hay Preguntas Para este Curso,<br> Por favor Ingrese al sistema</p>
        <div class="d-flex justify-content-center">
            <a href="../Vistas/preguntasRespuestasView.php">
                <button type="button" class="btn btn-primary">Registrar Preguntas</button>
            </a> 
        </div>
        <?php
    }
}

function limitEvaluacion($id_curso){
    $preguntasExamen = 2;
    global $pdo;
    $nPreguntas = $pdo->prepare("SELECT DISTINCT
                                        p.*
                                    FROM evaluacion e 
                                    INNER JOIN matricula m ON e.mat_id = m.mat_id
                                    INNER JOIN cursoxdocente cxd ON cxd.cxd_id = m.cxd_id
                                    INNER JOIN cursos c ON c.cu_id = cxd.cu_id
                                    INNER JOIN planificacion p ON p.cu_id = c.cu_id
                                    WHERE c.cu_id = :val1 AND p.plan_esExamen = 1");
    $nPreguntas->bindParam(':val1', $_POST['id_curso']);
    $nPreguntas->execute();
    $numero = $nPreguntas->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($numero)){
        foreach ($numero as $fila) {
            $preguntasExamen = $fila['plan_numPreguntas'];
        }
    }
    return $preguntasExamen;
}

function traerPreguntas($id_curso, $nPreguntas){
    global $pdo;
    $preguntas = $pdo->prepare("SELECT * FROM preguntas WHERE cu_id = :val1 ORDER BY RAND() limit :val2");
    $preguntas->bindParam(':val1', $id_curso, PDO::PARAM_INT);
    $preguntas->bindParam(':val2', $nPreguntas, PDO::PARAM_INT);
    $preguntas->execute();
    return $preguntas->fetchAll(PDO::FETCH_ASSOC);
}

function traerRespuestas($id_pregunta){
    global $pdo;
    $respuestas = $pdo->prepare("SELECT res_id, res_texto FROM respuestas WHERE pre_id = :val1 ORDER BY RAND()");
    $respuestas->bindParam(':val1', $id_pregunta, PDO::PARAM_INT);
    $respuestas->execute();
    return $respuestas->fetchAll(PDO::FETCH_ASSOC);
}

switch($accion){
    case "btnAgregar":
        //var_dump($_POST);
        compararDatos($_POST['respuesta'], $_POST['pregunta'], $_POST['txt_id_evaluacion']);
        break;
    case "btnAgregarDocente":
        //guardar($_POST['txt_idti'], $_POST['txt_id']);
        break;
}

function compararDatos($respuestas, $preguntas, $id_evaluacion){
    $resp_evaluacion = [];
    $preg = array_keys($preguntas);

    $respuestasCorrectas = [];
    foreach($preguntas as $p => $valor){
        $id_respuesta = traerEsCorrecto($p);
        if ($id_respuesta !== null) {
            $respuestasCorrectas[] = $id_respuesta;
        }
    }

    //var_dump($respuestasCorrectas);

    foreach ($preg as $id_pregunta) { 
        if (array_key_exists($id_pregunta, $respuestas)) {
            $respuesta = $respuestas[$id_pregunta];
        } else {
            $respuesta = 0;
        }

        $resp_evaluacion[] = [
            'id_pregunta' => $id_pregunta,
            'id_respuesta' => $respuesta
        ];
    }

    $respFinal = [];
    foreach($respuestasCorrectas as $res){
        $encontrado = false; // Bandera para verificar si se encuentra el ID de la respuesta
        foreach($respuestas as $respu){
            if($res == $respu){ // Compara el ID de la respuesta correcta con el ID de la respuesta
                $encontrado = true;
                break; 
            }
        }
        if($encontrado){
            array_push($respFinal, 1);
        }else{
            array_push($respFinal, 0);
        }
    }


    for ($i = 0; $i < count($resp_evaluacion); $i++) {
        if (isset($respFinal[$i])) {
            $resp_evaluacion[$i]['esCorrecto'] = $respFinal[$i];
        } else {
            $resp_evaluacion[$i]['esCorrecto'] = 0;
        }
    }

    //var_dump("hola");
    $contadorCorrectos = [];
    foreach($resp_evaluacion as $res){
        if($res['esCorrecto'] == 1){
            array_push($contadorCorrectos, 1);
        }
    }

    $asiertos = count($contadorCorrectos);
    $numPreguntasEval = count($preguntas);

    /*var_dump($asiertos);
    var_dump($numPreguntasEval);*/

    calcularNota($asiertos, $numPreguntasEval, $id_evaluacion);

    foreach($resp_evaluacion as $res){
        guardarEvaluacionDetalle($res['id_pregunta'], $res['id_respuesta'], $res['esCorrecto'] , $id_evaluacion);
    }

    header("Location: ../Vistas/evaluacionView.php");
    exit();
}

function traerEsCorrecto($id_pregunta){
    global $pdo;
    $select = $pdo->prepare("SELECT * FROM respuestas WHERE pre_id = :val1 AND res_esCorrecto = 1");
    $select->bindParam(':val1', $id_pregunta);
    $select->execute();
    $esCorrecto = $select->fetch(PDO::FETCH_ASSOC); // Usar fetch en lugar de fetchAll
    if ($esCorrecto) {
        $id_respuesta = $esCorrecto['res_id'];
        return $id_respuesta;
    } else {
        return null; // O retorna lo que necesites en caso de no encontrar un resultado
    }
}

function guardarEvaluacionDetalle($id_pregunta, $id_respuesta, $esCorrecto, $id_evaluacion){
    global $pdo;
    $insert = $pdo->prepare("INSERT INTO evaluaciondetalle (evd_esCorrecto, ev_id, pre_id, res_id)
                                VALUES (:val1, :val2, :val3, :val4)");
    $insert->bindParam(':val1', $esCorrecto);
    $insert->bindParam(':val2', $id_evaluacion);
    $insert->bindParam(':val3', $id_pregunta);
    $insert->bindParam(':val4', $id_respuesta);
    $insert->execute();
}

function calcularNota($asiertos, $numPreguntasEval, $id_evaluacion){
    global $pdo;
    $nota = ($asiertos*10)/$numPreguntasEval;
    var_dump($nota);
    $update = $pdo->prepare("UPDATE evaluacion 
                                SET ev_nota = :val1
                            WHERE ev_id = :val2");
    $update->bindParam(':val1', $nota);
    $update->bindParam(':val2', $id_evaluacion);
    $update->execute();
}
