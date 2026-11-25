# Sistema Web de Gestión Veterinaria

Desarrollado con Laravel 12 (compatible con Laravel 13), PHP, MySQL, Blade, Bootstrap 5.

## Requisitos
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js (opcional, assets ya compilados)

## Instalación
1. Copiar `.env.example` a `.env` o usar el `.env` incluido.
2. Configurar base de datos MySQL:
   - Crear BD `veterinaria`.
   - Ajustar `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
3. Instalar dependencias:
   ```bash
   composer install
   ```
4. Generar key:
   ```bash
   php artisan key:generate
   ```
5. Migrar y sembrar datos:
   ```bash
   php artisan migrate --seed
   ```
6. Enlace de storage:
   ```bash
   php artisan storage:link
   ```
7. Ejecutar:
   ```bash
   php artisan serve
   ```

## Credenciales de prueba
- Administrador: admin@veterinaria.com / password
- Recepcionista: recepcion@veterinaria.com / password
- Veterinario: veterinario@veterinaria.com / password

## Notas
- El proyecto usa Bootstrap 5 vía CDN y Chart.js.
- Reportes exportables a PDF y Excel.
- Roles y permisos mediante middleware `role`.
