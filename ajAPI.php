<?php

    include("../includes/config.php");
    include("../includes/functions.php");

    if ($_GET) $array=$_GET;
    else $array=$_POST;

    $miopcion=$array["miopcion"];
    switch($miopcion){
        case "show":
            $vNroDocumento=trim($array['documento']);
            $vIdAlumno=0;
            //$vProcesoMatriculaId=intval($array['procesomatriculaid']);
            //$vColegioId=intval($array['colegioid']);            			                        
            
            //$rs=$oS->Leer_Saldo_Visa($vNroDocumento, $vColegioId, $vProcesoMatriculaId);
            $rowDatos=DatosByAlumno($vNroDocumento);
            $rowDatosd= json_decode($rowDatos); 
            $vIdAlumno=intval($rowDatosd->data->id_alumno);
            
            $arrDatos=Saldo_Visa($vIdAlumno);
                         
            
            $jsondata['rowDatos'] = $rowDatosd;
            $jsondata['oData'] = $arrDatos;            
            
            echo json_encode($jsondata);
            break;
        case "checkout":            
            $vImporte=trim($array['importe']);
            $vIdVentas=trim($array['idventas']);
            $vImportes=trim($array['importes']);
            $vIdArticulos=trim($array['idarticulos']);
            $vIdAlumno=trim($array['idalumno']);
            
            $vResponse=checkout($vImporte,$vIdVentas,$vImportes,$vIdArticulos,$vIdAlumno); 
            
            echo $vResponse;
            break;
    }