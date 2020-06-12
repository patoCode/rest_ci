# KUDOS - HW 04
API KUDOS
=========
1. Descargar el repositorio 
2. En una consola ingrese dentro la carpeta RestApiJS
3. en la consola ejecute npm run dev
4. El acceso los API de kudos, se detalla a continuacion
 * /kudos : Crea un kudos usando el metodo  POST
 * /list : Lista todos los kudos creados usando el metodo  GET
 * /kudos/:_kudosId : Muestra un kudos en particular usnado el metodo GET
 * /kudos/:_id : Elimina un kudos usando el metodo DELETE

API USUARIOS
============
1 Dentro del directorio "_bd" se encuentra el script de la BBDD el cual debe importar en una BBDD creada en MySQL
2. Mueva el archivo a la carpeta virtual de su servidor apache. Por ejemplo: "c:/xampp/htdocs/"
3. Con un editor de texto configure el archivo config y el archivo database que se encuentra en el directorio "users/application/config"
4. El detalle de APIS es:
 * /add : Crea un usuario usando el metodo  POST
 * /search : busca un usuario y sus kudos usando el metodo  POST
 * /all/:_kudosId : Muestra tdos los usuarios unado el metodo GET
 * /delete/:_id : Elimina un usurio usando el metodo DELETE
 
RABBIT
======
Las colas se crean automaticamente
Colas disponibles
* queueStats: 'STATS_Q' para incrementar QTY
* queueStatsDel: 'STATS_D' para decrementar QTY
* queueDelUser: 'USERDEL_' para eliminar los KUDOS de un usuario

MONGO
=====
La base de  datos se llama Kudos, al igual que las colecciones; esta se crea automaticamente

MySQL
=====
Ustede descide el nombre de la BBDD, no se olvide que despues este nombre debera coincidir con el nombre de "database" , de la carpeta config, editado anteriormente
