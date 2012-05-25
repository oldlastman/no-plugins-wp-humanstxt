no-plugins-wp-humanstxt
=======================

Método para incluir humans.txt en el functions.php de un theme wordpress sin necesidad de invadir el raíz
Web original desde la que se ha tomado la mayoría del código 
http://www.onextrapixel.com/2011/11/07/how-to-incorporate-humans-txt-into-your-wordpress-site/

Cambios realizados sobre original
=================================
- El humans.txt existe como archivo texto en el directorio del theme (facilita la edición sin tocar código)
- Las funciones necesarias para la lectura y muestra del humans.txt se han movido a un archivo independiente
- Se realiza un llamanda en el functions.php para la carga de las funciones del humans..txt

Twitter: @oldlastman