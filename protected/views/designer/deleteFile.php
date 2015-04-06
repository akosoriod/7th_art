<?php
$output_dir = getcwd()."/../../data/sets/".$_POST["activitySetName"];
$deleted=unlink($output_dir.'/'.$_POST["filename"]);
echo json_encode(array('deleted'=>$deleted));