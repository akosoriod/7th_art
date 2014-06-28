#Instalación
##Requisitos
- PHP v.5.1 (mínimo para Yii)
- Yii v.1.1.14

##Framework
1. Descargar Yii en un directorio accesible por la aplicación
2. Renombrar el folder descargado como yii
3. Descargar esta versión del código
4. Si es necesario cambiar la variable "$yii" en index.php de 7th_art
5. Dar los permisos necesarios (estando en el folder raíz de apache):
```bash
sudo chmod -R 777 7th_art/assets
sudo chmod -R 777 7th_art/protected/runtime
```


##Base de datos (como root de MySQL)
```sql
GRANT SELECT, INSERT, UPDATE, DROP, DELETE, CREATE ON 7th_art.* TO '7th_art_web_app'@'localhost' IDENTIFIED BY 'nTwWEMb3YjkLTY4';
```