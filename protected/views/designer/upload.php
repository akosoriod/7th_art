<?php    
$output_dir = getcwd()."/../../data/sets/";
$file=$_FILES["file"];
if(isset($file)){
    $ret = array();
    $error =$file["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData() 
    if(!is_array($file["name"])){ //single file
        //Si es un archivo de estilos
        if($_POST["type"]==="style"){
            $output_dir.=$_POST["activitySetName"].'/css/';
            //Borra el anterior estilo si existe
            if($_POST["previousCss"]){
                unlink($output_dir.$_POST["previousCss"]);
            }
            //Copia la nueva hoja de estilos y retorna el nombre del archivo
            $fileName='style_'.md5(uniqid(rand(),true)).'.'.$_POST["extension"];
            move_uploaded_file($file["tmp_name"],$output_dir.$fileName);
            $ret["file"]=$fileName;
        }
    }
    echo json_encode($ret);
 }