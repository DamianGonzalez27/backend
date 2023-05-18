# Backend para prueba técnica
Este proyecto contiene los requerimientos solicitados para el desarrollo del API del backend

El proyecto contiene un stack de 21 pruebas unitarias que verifican el comportamiento desdeado de los casos de uso definidos en el manual de análisis del proyecto.

El proyecto aprovecha las bondades del sistema de inyección de dependencias de Laravel para poder gestionar el patron de diseño de Repositorios y servicios. Se crean 4 entidades principales para una base de datos MySQL. 

Se implementa un sistema de JWT para la autenticación de usuarios, un sistema de filtros con eloquent para realizar busquedas con filtros customizados, lo cual permite al sistema ser escalable.

Se crean clases de Requests personalizados para manipular las validaciones de los datos de entrada de la capa transaccional de la aplicación.

Se trabajan en 11 endpoints para determinar el comportamiento del backend

Se trabajan en 4 servicios fundamentales.

Crea un archivo ``.env`` y agrega los accesos de tu base de datos puedes ayudarte del ``.env.example``

Instala dependencias 

```bash
$ composer install
```

Ejecuta las migraciones

```bash
$ php artisan migrate
```

Crea una Key para JWT

```bash
$ php artisan key:generate
```

Ejecuta el servidor

```bash
$ php artisan serve
```


By.: Erick Damian Gonzalez Aranda
