    <ul>
        <li>Profile</li>
        <li>
            <div>
            <?php print CHtml::image(Yii::app()->request->baseUrl."/images/test/7thf1_r8_c4.png","",""); ?>
            </div>
            <div>Nombres: <?php print Yii::app()->user->_givenName ; ?></div>
            <div>Apellidos: <?php print Yii::app()->user->_sn ; ?></div>
            <div>Login: <?php print Yii::app()->user->_uid ; ?></div>
            <div>e-mail: <?php print Yii::app()->user->_mail ; ?></div>
        </li>
    </ul>