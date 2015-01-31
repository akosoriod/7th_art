<?php
/* @var $this CommentController */
/* @var $model Comment */
?>

<!-- Comentarios -->
<div id="divComments" class="section">
	<h3 class="section_title">Comentarios</h3>
	<div>&nbsp;</div>
	<div class="list">
		<?php
			foreach($comments as $comment) {
				$this->renderPartial('/wall/_view',array('data'=>$comment));
			}
		?>
	</div>
</div>
