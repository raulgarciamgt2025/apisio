# PeriodoAreaProceso API Documentation

## Overview
The PeriodoAreaProceso API manages the configuration relationships between periods, areas, and processes within companies.

## Table Structure
- **id_configuracion**: Primary key (auto-increment)
- **id_periodo**: Foreign key to periodo table
- **id_area**: Foreign key to area table  
- **id_proceso**: Foreign key to proceso table
- **id_usuario_asigno**: Foreign key to users table (who assigned)
- **fecha_asigno**: DateTime when assigned
- **id_empresa**: Foreign key to empresa table

## API Endpoints

### Base URL: `/api/periodo-area-proceso`

### Authentication
All endpoints require authentication via JWT token in the Authorization header:
```
Authorization: Bearer {your-jwt-token}
```

### 1. Get All Configurations
**GET** `/api/periodo-area-proceso`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id_configuracion": 1,
      "id_periodo": 1,
      "id_area": 1,
      "id_proceso": 1,
      "id_usuario_asigno": 1,
      "fecha_asigno": "2025-07-13T08:59:50.000000Z",
      "id_empresa": 1,
      "empresa": {...},
      "periodo": {...},
      "area": {...},
      "proceso": {...},
      "usuarioAsigno": {...}
    }
  ]
}
```

### 2. Create New Configuration
**POST** `/api/periodo-area-proceso`

**Request Body:**
```json
{
  "id_periodo": 1,
  "id_area": 1,
  "id_proceso": 1,
  "id_empresa": 1
}
```

**Response:**
```json
{
  "success": true,
  "message": "Configuración creada exitosamente",
  "data": {
    "id_configuracion": 1,
    "id_periodo": 1,
    "id_area": 1,
    "id_proceso": 1,
    "id_usuario_asigno": 1,
    "fecha_asigno": "2025-07-13T08:59:50.000000Z",
    "id_empresa": 1
  }
}
```

### 3. Get Configuration by ID
**GET** `/api/periodo-area-proceso/{id}`

**Response:**
```json
{
  "success": true,
  "data": {
    "id_configuracion": 1,
    "id_periodo": 1,
    "id_area": 1,
    "id_proceso": 1,
    "id_usuario_asigno": 1,
    "fecha_asigno": "2025-07-13T08:59:50.000000Z",
    "id_empresa": 1,
    "empresa": {...},
    "periodo": {...},
    "area": {...},
    "proceso": {...},
    "usuarioAsigno": {...}
  }
}
```

### 4. Update Configuration
**PUT/PATCH** `/api/periodo-area-proceso/{id}`

**Request Body:**
```json
{
  "id_periodo": 2,
  "id_area": 2
}
```

### 5. Delete Configuration
**DELETE** `/api/periodo-area-proceso/{id}`

**Response:**
```json
{
  "success": true,
  "message": "Configuración eliminada exitosamente"
}
```

## Additional Endpoints

### Get by Periodo
**GET** `/api/periodo-area-proceso/periodo/{id_periodo}`

### Get by Area
**GET** `/api/periodo-area-proceso/area/{id_area}`

### Get by Proceso
**GET** `/api/periodo-area-proceso/proceso/{id_proceso}`

### Get by Empresa
**GET** `/api/periodo-area-proceso/empresa/{id_empresa}`

## Validation Rules

### Create/Update:
- `id_periodo`: required, integer, must exist in periodo table
- `id_area`: required, integer, must exist in area table
- `id_proceso`: required, integer, must exist in proceso table
- `id_empresa`: required, integer, must exist in empresa table

## Error Responses

### 422 Validation Error:
```json
{
  "success": false,
  "message": "Datos de validación incorrectos",
  "errors": {
    "id_periodo": ["The id_periodo field is required."]
  }
}
```

### 404 Not Found:
```json
{
  "success": false,
  "message": "Configuración no encontrada"
}
```

### 409 Conflict (Duplicate):
```json
{
  "success": false,
  "message": "Esta configuración ya existe"
}
```

### 500 Server Error:
```json
{
  "success": false,
  "message": "Error al crear la configuración: {error details}"
}
```

## Models and Relationships

### PeriodoAreaProceso Model
- **Belongs to:** Empresa, Periodo, Area, Proceso (TipoProceso), User (usuarioAsigno)
- **Primary Key:** id_configuracion
- **Timestamps:** false (uses fecha_asigno instead)

## Repository Pattern
The API uses the Repository pattern with:
- `PeriodoAreaProcesoRepositoryInterface`
- `PeriodoAreaProcesoRepository`

## Testing
Run tests with:
```bash
php artisan test --filter=PeriodoAreaProcesoTest
```

## Sample Usage

### Creating a configuration:
```bash
curl -X POST http://localhost:8000/api/periodo-area-proceso \
  -H "Authorization: Bearer your-jwt-token" \
  -H "Content-Type: application/json" \
  -d '{
    "id_periodo": 1,
    "id_area": 1,
    "id_proceso": 1,
    "id_empresa": 1
  }'
```

### Getting configurations by empresa:
```bash
curl -X GET http://localhost:8000/api/periodo-area-proceso/empresa/1 \
  -H "Authorization: Bearer your-jwt-token"
```
