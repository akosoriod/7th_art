#Instalación
##Requisitos
- PHP v.5.1 (mínimo para Yii)
- Yii v.1.1.14

##Framework
* Descargar Yii en un directorio accesible por la aplicación

* Renombrar el folder descargado como yii

* Descargar esta versión del código

* Si es necesario cambiar la variable "$yii" en index.php de 7th_art
```php
// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
...
```

* Si no existe el folder 7th_art/protected/runtime, crearlo:
```bash
sudo mkdir 7th_art/protected/runtime
```

* Dar los permisos necesarios (estando en el folder raíz de apache):
```bash
sudo chmod -R 777 7th_art/assets
sudo chmod -R 777 7th_art/protected/runtime
```

##Base de datos (como root de MySQL)
```sql
GRANT SELECT, INSERT, UPDATE, DROP, DELETE, CREATE ON 7th_art.* TO '7th_art_web_app'@'localhost' IDENTIFIED BY 'nTwWEMb3YjkLTY4';
```