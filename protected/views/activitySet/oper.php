<?php
/* @var $this ActivitySetController */
/* @var $activitySets ActivitySet */
/* @var $currentUser User */
/* @var $users User */
$this->breadcrumbs=array(
	'Operador',
);

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
?>
<script type="text/javascript">
    $( document ).ready(function(){
//        $(".site-url").empty().append('<div class="icon"> </div> 7 <sup>th</sup> @rt Administator');
        var appUrl="<?php // echo Yii::app()->baseUrl."/"; ?>";
//        var editor=new Editor({
//            appUrl:appUrl
//        });
//        editor.init();
//
//        var sections=$("#navigation").children("ul");
//        sections.click(function(){
//            alert("only a prototype");
//        });
    });
</script>
<main id="oper_page" class="oper_page">
    <?php
    $this->breadcrumbs=array(
	'Activity Sets',
    );
    ?>
    <div id="container">
        <div id="activitySets" class="section">
            <h3 class="section_title">Sets de actividades asignados</h3>
            
            <div class="list">
			        <?php
				    foreach ($activitySets as $activitySet) {
					// Selecciona unicamente los sets de actividades asignados al operador
					if($activitySet->operator_id == $currentUser->id){
						// Que estén en edición
						if($activitySet->status_id == 1){					
							$this->renderPartial('_oper_view',array('data'=>$activitySet));
						}
					}
				    }
				?>                

            </div>
	    <!--
	    <div align="center" class="row row4">
	    <table style="width:30%">
		  <tr>
		    <td>Select activity set to edit:</td>
		    <td>
			<select>
			  	<?php
				    foreach ($activitySets as $activitySet) {
					if($activitySet->operator_id == $currentUser->id){					
						?>
						<option><?php echo CHtml::encode($activitySet->title); ?> </option>
						<?php
					}
				    }
				?>
			</select> 
		    </td>
		    <td> <button type="button">Edit</button> </td>
		  </tr>
		  <tr height="30px">
		  </tr>
	     </table> 
	</div> -->
        
    </div>

	<div id="activitySets" class="section">
            <h3 class="section_title">Sets de actividades aprobados</h3>
            
            <div class="list">
                		<?php
				    foreach ($activitySets as $activitySet) {
					if($activitySet->operator_id == $currentUser->id){
						if($activitySet->status_id != 1){					
							$this->renderPartial('_oper_view',array('data'=>$activitySet));
						}
					}
				    }
				?>   
            </div>

	    
</main>
