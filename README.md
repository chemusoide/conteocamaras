# Sistema de Monitorización de Aforo para IB-Seguretat

Este proyecto proporciona una solución integral para la monitorización de aforo utilizando múltiples cámaras. Está diseñado para ser utilizado por IB-Seguretat y proporciona una interfaz en tiempo real para el seguimiento del aforo, permitiendo ajustes manuales y proporcionando alertas cuando el aforo alcanza umbrales definidos.

## Características Principales

- Interfaz de usuario clara y responsiva.
- Monitorización del aforo en tiempo real.
- Alertas visuales de aforo máximo y aforo cercano al máximo.
- Ajuste manual del aforo a través de una interfaz web.
- Detalles del aforo desglosados por cámara.

## Tecnologías Utilizadas

- Frontend: HTML, CSS (con Flexbox), JavaScript (jQuery)
- Backend: PHP
- Base de datos: MySQL

## Estructura del proyecto

	CONTEOCAMARAS
	│
	├── assets
	│ ├── css
	│ │ └── styles.css
	│ ├── img
	│ │ ├── camera.png
	│ │ └── Logo.png
	│ └── js
	│ └── scripts.js
	│
	├── config
	│ ├── cameraInfo.json
	│ └── config.php
	│
	├── helpers
	│ └── debug.php
	│
	├── public
	│ ├── .htaccess
	│ ├── decrementar_aforo.php
	│ ├── fetch_aforo_total.php
	│ ├── incrementar_aforo.php
	│ └── index.php
	│
	├── src
	│ ├── controllers
	│ │ └── CameraController.php
	│ ├── models
	│ ├── services
	│ │ ├── cameraApiService.php
	│ │ └── Database.php
	│ └── views
	│ ├── aforo_total_simple.php
	│ └── aforo_total_view.php
	│
	├── tests
	│ ├── cameraApiServiceTest.php
	│ └── cameraControllerTest.php
	│
	├── vendor
	│
	├── .gitignore
	└── README.md

## Instalación

### Requisitos Previos

- Servidor con soporte para PHP 7.4 o superior.
- MySQL 5.7 o superior.

### Pasos de Instalación

1. Clona el repositorio:
	git clone https://github.com/chemusoide/conteocamaras.git

2. Configura los archivos en `config/` con los detalles de tu base de datos y otros parámetros relevantes. Por razones de seguridad, asegúrate de que estos archivos no se suban a ningún repositorio público.

3. Importa el esquema de la base de datos.

4. Instala las dependencias necesarias, si las hay.

5. Coloca los archivos en tu servidor web de manera que la carpeta `public/` sea la raíz accesible públicamente.

6. Accede a la aplicación a través de la URL configurada para tu servidor.

## Uso

Simplemente navega a la URL de la aplicación en tu servidor. La interfaz mostrará el aforo actualizado en tiempo real y permitirá los ajustes manuales.

	http://localhost:8888/IB-Seguretat/conteoCamaras/public/

	http://localhost:8888/IB-Seguretat/conteoCamaras/public/?view=simple


## Contribuciones

Las contribuciones al proyecto son bienvenidas. Por favor, realiza tus contribuciones en una rama separada y abre un pull request cuando estés listo para integrar tus cambios.

## Licencia

Este proyecto se distribuye bajo la Licencia Pública General de GNU, versión 3.0 (GPLv3). Para más detalles, consulta el archivo `LICENSE` en este repositorio.

## Configuración del fichero de cameraInfo.json
El fichero de configuración de cámaras y de la aplicación espera un JSON con esta estructura:
	{
	   "cameras": {
	       "camera01": {
	           "auth": "http://[ruta]:[puerto]/api/auth/token",
	           "url": "http://[ruta]:[puerto]/",
	           "name": "camera01",
	           "user": "USUARIO",
	           "password": "PASSWORD",
	           "obs": "Entrada 1"
	       },
	       "camera02": {
	           "auth": "http://[ruta]:[puerto]/api/auth/token",
	           "url": "http://[ruta]:[puerto]/",
	           "name": "camera02",
	           "user": "USUARIO",
	           "password": "PASSWORD",
	           "obs": "Salida 1"
	       }(...RESTO DE CÁMARAS...)
		},
		"totalForum": 100,
		"warning": 80,
		"refresh": 10
	}

El programa se adapta al numero de cámaras se pueden poner 1 hasta n cámaras, todas las cámaras se definen en este fichero y el programa se encarga del resto.

## Configuración de la Base de Datos

La aplicación utiliza MySQL para almacenar los datos del aforo. Deberás crear una base de datos y proporcionar las credenciales correctas en el archivo `config.php`.

Aquí tienes un ejemplo de cómo configurar la base de datos:

	`php
// config.php

	define('DB_HOST', 'tu_host');
	define('DB_NAME', 'nombre_de_tu_base_de_datos');
	define('DB_USER', 'tu_usuario');
	define('DB_PASS', 'tu_contraseña');

### Estructura de la tabla en la BD
	SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
	START TRANSACTION;
	SET time_zone = "+00:00";
	
	CREATE TABLE `aforo` (
	  `id` int(11) NOT NULL,
	  `aforo_manual` int(11) DEFAULT '0',
	  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	
	ALTER TABLE `aforo`
	  ADD PRIMARY KEY (`id`);
	
	ALTER TABLE `aforo`
	  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

Desarrollado con ♥ por Informática Polo.