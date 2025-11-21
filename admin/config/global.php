<?php 

// Si existe la variable de entorno (Nube), úsala; si no, usa el valor local

// IP / host del servidor de la base de datos
define("DB_HOST", getenv('DB_HOST') ?: "localhost");

// Nombre de la base de datos
define("DB_NAME", getenv('DB_NAME') ?: "control_asistencia");

// Usuario de la base de datos
define("DB_USERNAME", getenv('DB_USERNAME') ?: "root");

// Contraseña del usuario de la base de datos
define("DB_PASSWORD", getenv('DB_PASSWORD') ?: "");

// Codificación de caracteres
define("DB_ENCODE", "utf8");

// Nombre del proyecto
define("PRO_NOMBRE", "Proyecto_QR");

// Zona horaria
define("ZONA_HORARIA", "America/Mexico_City");
