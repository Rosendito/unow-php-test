# Unow prueba técnica PHP

## Tecnologías
* PHP 8

## Cómo correr

1. Instalar las dependencias con composer:
```bash
composer install
```
2. Ejecutar el script `database.sql` para crear las tablas de la base de datos
3. Cambiar las variables de entorno para utilizar su propia base de datos
4. Correr el servidor de PHP con el comando:
```bash 
php -S 127.0.0.1:8000
```
5. Importar la colección de postman

## Documentación y bitácora


### ORM
He decidido crear un ORM básico para interactuar con la base de datos. Para ello, he creado un servicio `src/models/database/Database` que se encarga de la conexión de los statements básicos que interactúan con la base de datos (Usando PDO). Además de eso he creado un modelo base `src/models/Model` de la cual extienden las clases de la aplicación donde, de forma muy básica se manipulan los recursos.

Dicho ORM tiene los siguientes métodos:
**create**: Acepta un arreglo `data` que inserta en la tabla correspondiente validando que solo se inserten los campos que corresponden a la tabla.
**find**: Busca un registro en la tabla correspondiente.
**all**: Devuelve todos los registros de la tabla correspondiente con la opción de filtrar por un arreglo `where`.
**update**: Actualiza un registro en la tabla correspondiente.

Al buscar, crear o actualizar un registro, los atributos se anexan a la clase para poder tener un acceso fácil a ellos como en cualquier otro ORM.

### Http handler
También opté por crear un handler de peticiones HTTP para poder manejar las peticiones de forma más sencilla. Consta de una clase `src/controller/kernel/Request` que devuelve los datos de la petición y una clase `src/controllers/kernel/Router` que se encarga de registrar y manejar las rutas de la aplicación. Las rutas se registran en la clase `src/controllers/kernel/Kernel`.

## Conclusiones

Fue muy interesante realizar la prueba técnica con PHP nativo, evité tener que usar ciertas librerías que sin duda hubieran sido muy útiles con tal de demostrar mis hábilidades. Ya antes había investigado un poco de como crear un ORM pero sin duda no fue tan fácil. Para el router si ya tenía experiencia previa en otros proyectos con apis sencillas con enfoque lambda.

Me quedé ganas de hacer mucho más, como agregar validaciones a los requests y las pruebas tanto feature como unitarias de la aplicación. De haber tenido más tiempo sin duda lo habría hecho.
