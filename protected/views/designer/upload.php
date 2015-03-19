<?php    
$output_dir = getcwd()."/../../data/";
$file=$_FILES["file"];
if(isset($file)){
    $ret = array();
    $error =$file["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData() 
    if(!is_array($file["name"])){ //single file
        $fileName='entity_'.$_POST["entity"].'_'.$_POST["type"].'.'.$_POST["extension"];
        move_uploaded_file($file["tmp_name"],$output_dir.$fileName);
        $ret["file"]= $fileName;
    }else{  //Multiple files, file[]
        $fileCount = count($file["name"]);
        for($i=0; $i < $fileCount; $i++){
            $fileName = $file["name"][$i];
            move_uploaded_file($file["tmp_name"][$i],$output_dir.$fileName);
            $ret[]= $fileName;
        }
    }
    echo json_encode($ret);
 }