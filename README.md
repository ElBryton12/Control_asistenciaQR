# 📌 Control de Asistencia con Código QR

Sistema web que permite **registrar entradas y salidas de empleados** mediante escaneo de códigos QR, ideal para empresas que desean control preciso, rápido y automatizado.

---

## 🚀 Características principales

- ✅ **Control de asistencia en tiempo real** mediante códigos QR.  
- ✅ **Generación automática de códigos QR** al registrar un nuevo empleado.  
- ✅ **Escáner QR integrado** (solo accesible para guardias y administradores).  
- ✅ **Panel administrativo completo** (solo para administrador):  
  - Gestión de empleados  
  - Gestión de usuarios/guardias  
  - Control de roles y permisos  
- ✅ **Reportes descargables** por rango de fechas.  
- ✅ **Modo oscuro / modo claro** moderno y adaptable.  
- ✅ Interfaz rediseñada, moderna y responsiva.

---

## 🧩 Roles del sistema

### 👑 Administrador
Tiene acceso completo:
- CRUD de empleados  
- CRUD de usuarios/guardias  
- Panel de control  
- Listas de asistencia  
- Reportes  
- Escáner QR  

### 🛡️ Guardia
Solo puede acceder a:
- Escáner QR  
- Listas de asistencia  
- Reportes por fecha  
- Panel principal  

No tiene acceso a la administración de empleados o usuarios.

---

## 📂 Estructura importante del sistema

### 📁 `/admin/libs/phpqrcode/`
Contiene la librería **phpqrcode**, utilizada para generar automáticamente códigos QR al registrar un empleado.

### 📁 `/admin/files/qrcodes/`  
📌 **Esta carpeta NO viene en el repositorio.**  
Debes crearla manualmente


Aquí se almacenarán los códigos QR generados para cada empleado.

### 📁 `/admin/files/usuarios/`
Contiene las fotos de los usuarios del sistema (administrador o guardias).

---

## ⚙️ Requisitos

- PHP 7.4+  
- MySQL / MariaDB  
- Servidor Apache (XAMPP recomendado)  
- Extensiones GD y MBstring habilitadas

---

## 🧪 Funciones destacadas

### 🔹 Registro de empleados
Al registrar un empleado:
- Se genera automáticamente un QR usando PHPQRCODE  
- Se asigna un código único  
- Se almacena en `/admin/files/qrcodes/`

### 🔹 Escaneo de QR
El guardia o administrador escanea un QR para registrar:
- Entrada  
- Salida  

Todo queda guardado en la tabla `asistencias`.

### 🔹 Gestión avanzada de roles
Desde el panel:
- El administrador puede crear guardias  
- Cada guardia tendrá acceso limitado automáticamente  

---

## 📝 Notas adicionales

- En el archivo `.gitignore` se excluye la carpeta `/admin/files/qrcodes/`  
  (por seguridad, ya que contiene datos internos de empleados).  
- Si deseas usar tus propios QR, solo coloca los archivos PNG en esa carpeta.

---

## 🎯 ¿Por qué este sistema?

Porque convierte un flujo manual y propenso a errores en un proceso **rápido, seguro y automático**.  
Además, la interfaz está diseñada pensando en guardias y administradores, con un estilo moderno, intuitivo y práctico.
