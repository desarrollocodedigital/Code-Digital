# Bitácora de Versionamiento - Code-Digital

Este archivo contiene el registro de todos los cambios realizados en el proyecto (archivos y base de datos) después del despliegue de la versión pública.

## [Pendiente] - Cambios por Proyectar a Producción

### 📁 Cambios en Archivos
*   `views/admin.php` (Lógica y HTML del módulo de Métricas)
*   `includes/admin_sidebar.php` (Acceso al nuevo módulo)
*   `views/admin.php` (Lógica de gráficas, métricas reales y biblioteca Chart.js)
*   `api/track_event.php` (Nuevo Endpoint para registro de eventos y visitas [NEW])
*   `assets/js/main.js` (Motor de analítica frontend, rastreo de formularios y lógica de iconos de tema)
*   `views/proyecto_detalle.php` (Sincronización de Footer y Chat de Soporte)
*   `config/db.php` (Validación de conexión para migraciones)
*   `includes/admin_header.php` (Implementación de script anti-flash para persistencia de Modo Oscuro [NEW])
*   `views/admin.php` (Rediseño de Dashboard v2.1: Layout de 2 filas, gráficas Lima de conversión omnicanal y tarjetas compactas)


### 🗄️ Cambios en Base de Datos
*   Añadir campos y nueva tabla para Casos de Estudio (`proyectos`, `proyecto_imagenes`).
```sql
ALTER TABLE proyectos 
ADD COLUMN problema TEXT NULL AFTER descripcion,
ADD COLUMN funcionalidades TEXT NULL AFTER problema;

CREATE TABLE IF NOT EXISTS proyecto_imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proyecto_id INT NOT NULL,
    imagen_url VARCHAR(255) NOT NULL,
    orden INT DEFAULT 0,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE
);
```

#### 📊 Analítica y Tracking de Conversiones
*   Estructura para rastreo de eventos y visitas únicas.
```sql
-- Tabla para rastreo de clics y acciones (CTAs)
CREATE TABLE IF NOT EXISTS eventos_tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evento_tipo VARCHAR(50) NOT NULL,
    pagina_origen VARCHAR(255) NOT NULL,
    metadata TEXT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para rastreo de tráfico único (Visitas)
CREATE TABLE IF NOT EXISTS visitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    pagina_visitada VARCHAR(255) NOT NULL,
    ip_hash VARCHAR(64) NULL,
    fecha DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(fecha),
    INDEX(session_id)
);
```

---

## [Historial de Versiones]

### v1.0.0 (2026-04-08) - Versión Pública Inicial
* Se ha subido el proyecto a su versión pública.
* Inicio del seguimiento de cambios en este archivo.
* **Base de Datos**: Estructura inicial sincronizada (Usuarios, Proyectos, CRM, Ajustes, Plantillas).
* **Seguridad**: Autenticación BCRYPT implementada.
