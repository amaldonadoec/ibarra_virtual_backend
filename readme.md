## Configuración Laravel

#### Composer

* Correr el siguiente comando:
```bash
composer install
```
#### Base de Datos MYSQL

##### - Conectar el proyecto a la base de datos de mysql
Para conectar el proyecto con la base correspondiente actualizar las siguientes variables de ambiente:

```
DB_CONNECTION=mysql (motor de base de datos)
DB_HOST=127.0.0.1 (hostname)
DB_PORT=3306 (puerto)
DB_DATABASE=database (nombre de la base de datos)
DB_USERNAME=usuario (usuario del motor de base de datos)
DB_PASSWORD=password (contraseña del usuario con el que conecta)
``` 

##### - Creación de la base de datos
 La generación de la base de datos se realiza con `migrations`, para esto correr los siguientes comando.
 
 * Crear estructura
```
php artisan migrate
```

* Carga de data inicial de base datos (seeders)
Una vez realizada la migración e instalación de passport, para cargar la data inicial en la base de datos es necesario correr los siguientes comandos:
```
composer dump-autoload

php artisan db:seed
```
Si se quiere resetear por completo la base de datos:
```
php artisan migrate:refresh --seed
```
Tambien se puede crear mediante un dump el cual se encuentra localizado en:

```
/docs/database/dump/dump_companies.sql
```

#### Laravel Passport OAuth2
   Passport OAuth2 es el módulo de laravel para manejar la autenticación y autorización en los llamados al api utilizando el protocolo OAuth2. Para habilitarlo es necesario correr el siguiente comando:
   
   ```
   php artisan passport:install
   ```

#### Configuración Firebase

Este proyecto se conecta a firebase con la finalidad de validar el token y obtener información de los usuarios existentes.
Para esto debemos configurar las siguientes variables de ambiente:

```
FIREBASE_KEY = AAAAPQjpa0Q:APA91....  (Key del proyecto)
FIREBASE_PROJECT_ID = 262142520132 (ID del proyecto)
``` 
Para más información sobre la firebase [haz clic aquí](https://firebase.google.com/).

##Supervisor Configuration

Para manejar los procesos asíncronos a través de las colas de Laravel es necesario configurar el servidor como se indica en este enlace
https://laravel.com/docs/5.6/queues#supervisor-configuration

Ejemplo de configuración en Vagrant Homestead. Archivo /etc/supervisor/conf.d/laravel-worker.conf

```bash
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/vagrant/code/ECOMMERCE_COMPANIES/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=vagrant
numprocs=8
redirect_stderr=true
stdout_logfile=/home/vagrant/code/ECOMMERCE_COMPANIES/storage/logs/laravel-worker.log
```

Si se cambia la configuración de este archivo se deben ejecutar estos comandos

```bash
sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*
```

Para ver el estado de los procesos

```bash
sudo supervisorctl status
```

## Utilidades
### Librería para generar migraciones
Esta librería nos ayuda a generar archivos de migraciones en base a la estructura de la base de datos actual.

Si deseamos generar los archivos de migraciones de toda la base de datos lo único que debemos ejecutar es el siguiente comando. 

``php artisan migrate:generate``

Pero si queremos generar unicamente las migraciones de algunas tablas en especifico ejecutamos. 

``php artisan migrate:generate nombre_tabla_1,nombre_tabla_2,...(demas tablas que se quiera)``

Para más información sobre la librería [haz clic aquí](https://github.com/Xethron/migrations-generator).
###Librería para generar seeders
Esta librería nos ayuda a generar seeders en base a los datos de la base de datos actual. Para generar los seeders solamente ejcutamos el siguiente comando:

``php artisan iseed nombre_tabla_1,nombre_tabla_2,...(demas tablas que se quiera)``

Para más información sobre la librería [haz clic aquí](https://github.com/orangehill/iseed).
 