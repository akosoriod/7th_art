Esta aplicación... PENDING:

* Intro
* Propósito del proyecto
* Instalación
* Historia
* Desarrolladores
* Hacking
* Referencias

# Instalación

## Requisitos
- [PHP (>= v.5.1)](http://php.net/), cuya instalación depende de su S.O., e.g., `sudo pacman -S php` en arch.
- [Yii (>=v.1.1.15)](https://github.com/yiisoft/yii)

## Yii

1. Crear una carpeta para la aplicación:

 ```sh
 $ mkdir dev
 $ cd dev
 ```

1. Descargar y renombrar [Yii](https://github.com/maparrar/7th_art.git) 

 ```sh
 $ wget https://github.com/yiisoft/yii/releases/download/1.1.15/yii-1.1.15.022a51.tar.gz
 $ tar zxvf yii-1.1.15.022a51.tar.gz
 $ mv yii-1.1.15.022a51 yii
 ```

1. Clonar el repo y crear la carpeta runtime

 ```sh
 $ git clone https://github.com/maparrar/7th_art.git
 $ mkdir 7th_art/protected/runtime
 ```

<!--- de acá para adelante no se entiende nada y además está incompleto -->

* Dar los permisos necesarios (estando en el folder raíz de apache):
```bash
sudo chmod -R 777 7th_art/assets
sudo chmod -R 777 7th_art/protected/runtime
```

##Base de datos (como root de MySQL)
```sql
GRANT SELECT, INSERT, UPDATE, DROP, DELETE, CREATE ON 7th_art.* TO '7th_art_web_app'@'localhost' IDENTIFIED BY 'nTwWEMb3YjkLTY4';
```

##Layout
En el directorio ```layout``` están los archivos HTML, CSS y Javascript para aplicar los estilos. No requiere el uso de servidor.

* Los estilos generales de la aplicación están en: ```layout/css/7th_art.css```
* Para editar el layout de una página en particular, por ejemplo intro, los estilos están en: ```layout/css/intro.html```
* Los templates usados, como header y footer de la UNAL están en: ```layout/templates/header.html```, ```layout/templates/footer.html```
* Todos los archivos requeridos por la UNAL están en: ```layout/templates/unal/```