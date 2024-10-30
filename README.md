# Proyecto de Gestión de Categorías

Este proyecto está diseñado para gestionar categorías utilizando la base de datos **Northwind**. A continuación se presentan las instrucciones necesarias para configurar y ejecutar el proyecto correctamente.

## Requisitos Previos

- [XAMPP](https://www.apachefriends.org/index.html) instalado en tu máquina.
- Base de datos **Northwind** disponible en tu servidor MySQL.

## Configuración de la Base de Datos

### 1. Importar la Base de Datos Northwind

Asegúrate de que la base de datos **Northwind** esté importada en tu servidor MySQL. Puedes obtener el archivo SQL de la base de datos [aquí](https://github.com/jpwhite3/northwind-SQLite3/blob/master/Northwind.sqlite).

### 2. Crear un Usuario para Iniciar Sesión

Ejecuta la siguiente consulta SQL en tu base de datos para crear un nuevo usuario:

```sql
INSERT INTO usuarios (username, password) VALUES ('Usuario', MD5('Contraseña'));
```
### Importante
Ir al documento php.ini en **XAMPP/Apache/php.ini** (darle click a config de Apache e ir a  php.ini)
y desdocumentar la línea **extension=gd**
