<?php
/* @var $this UserController */
/* @var $data User */
?>
<div class="list-group-item operadores">

    <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/user/view/' . $data->id; ?>">
        <h3>
            <?php echo $data->username ?>&nbsp;&nbsp;
        </h3>
    </a>

    <b>Nombre: </b> 
    <?php echo $data->name . " " . $data->lastname ?>
    <br>
    <b>Estado: </b>
    <?php
    if ($data->active) {
        echo '<span class="label label-success">Activo</span>';
    } else {
        echo '<span class="label label-danger">Inactivo</span>';
    }
    ?>
    <br />

</div>