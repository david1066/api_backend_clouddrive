<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Paquetes instalados: composer y npm
1. fruitcake/laravel-cors: ^2.0
2. guzzlehttp/guzzle: ^7.0.1
3. @fortawesome/fontawesome-svg-core: ^6.2.1
4. @fortawesome/free-regular-svg-icons: ^6.2.1
5. @fortawesome/free-solid-svg-icons: ^6.2.1,
6. @fortawesome/vue-fontawesome: ^3.0.2,
7. axios: ^1.2.0
8. core-js: ^3.8.3
9. vue: ^3.2.13
10. vue-router: ^4.0.3
11. laravel/framework: ^8.75
12. laravel/sanctum: ^2.11
13. laravel/tinker: ^2.5
14. postcss: ^8.4.19
15. tailwindcss: ^3.2.4

## Funcionalidades

1. La eliminación está por softdelete, no sé eliminan los datos.
2. Se validan los campos con la librería VALIDATOR.
3. El sistema no permite duplicados por email.
4. Se configura el cors de la aplicacion donde se especifica un origin

## Instalación y despliegue

1. Instalar composer 

https://getcomposer.org/



2. Clonar proyecto

git clone https://github.com/david1066/api_backend_clouddrive.git

3. Ejectuar los siguientes comandos para instalar las dependencias

En el proyecto backend ejecutar

cd backend  

Composer install 

cd ..

En el proyecto frontend ejecutar

cd frontend

npm install

4. Revisamos en el proyecto backend el archivo .env que tenga correctamente las credenciales (usuario y contraseña) y creamos una base de datos con el nombre brm directamente con el administrador de base de datos.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=brm
DB_USERNAME=root
DB_PASSWORD=

5. Ejecutamos la migraciones que nos creara las tablas.

php artisan migrate

6. Corremos los proyectos
cd backend
php artisan serve
cd ..
cd frontend
npm run serve

7. en el navegador abrimos la ruta

backend: http://127.0.0.1:8000

frontend: http://localhost:8080
