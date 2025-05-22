# API REST PETS

API REST creada con Laravel 11 para gestionar usuarios y mascotas. Esta API forma parte del proyecto de examen de UF4 (DAW).

## Funcionalidades

- Registro y login con JWT
- CRUD de usuarios (solo admins)
- CRUD de mascotas (por usuario autenticado)
- Rutas protegidas por roles

---

## Autenticación

Se usa JWT para proteger las rutas. Cuando haces login recibes un token que tienes que enviar en todas las peticiones protegidas usando el header:

## Que es JWT

JWT es como un carnet digital que sirve para decirle a una web quién eres y qué puedes hacer ahí. Está hecho en formato JSON y va todo junto en un mensaje que lleva una firma para que nadie lo pueda cambiar. Así, cuando entras a una web, en vez de pedirte usuario y contraseña cada vez, te dan un JWT y ya saben que eres tú y qué permisos tienes.


## Funcionalidades

- Registro y login con token
- CRUD de mascotas (usuarios)
- CRUD de usuarios (admin)
- Rutas protegidas por rol

---

## Usuario de prueba

```
{
  "email": "ericsaez13@gmail.com",
  "password": "123456"
}
```

## Endpoints

### Rutas públicas

POST /register - Registrar usuario  
POST /login - Hacer login

---

### Rutas privadas (usuario autenticado)

POST /logout - Cerrar sesión  
GET /pets - Ver mis mascotas  
POST /pets - Crear mascota  
GET /pets/{id} - Ver una mascota concreta  
PUT /pets/{id} - Actualizar mascota completa  
PATCH /pets/{id} - Actualizar mascota parcial  
DELETE /pets/{id} - Eliminar una mascota propia

---

### Rutas de administrador

GET /users - Ver todos los usuarios  
GET /users/{id} - Ver usuario concreto  
PUT /users/{id} - Actualizar usuario  
DELETE /users/{id} - Eliminar usuario  
GET /users/{id}/pets - Ver mascotas de un usuario

## Link de despliegue

Haz clic aquí para ver(https://m7-laravel-saezeric-production-691f.up.railway.app/)
