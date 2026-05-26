1. La Base de Datos (`database.sql`)
¿Qué hace?** Es el "cerebro" donde se almacena toda la información de forma persistente.
- Tomé el esquema de tu diagrama y lo convertí en tablas de MySQL (`cliente`, `productos`, `trabajador`, `venta`, `delivery`, etc.).
- Las tablas están conectadas mediante **Llaves Foráneas** (Foreign Keys). Por ejemplo, la tabla `delivery` sabe qué trabajador está entregando el paquete porque guarda su `idMotorizado`.
- Agregué credenciales (Usuario y Contraseña) a los trabajadores para que el sistema sepa quién entra a la plataforma.

2. La Conexión (`config.php`)
¿Qué hace?** Es el puente de comunicación entre la página web (PHP) y la base de datos (MySQL).
- Contiene los datos de acceso a tu servidor WAMP (`localhost`, usuario `root`, sin contraseña).
- Todas las demás páginas incluyen este archivo secreto. Si el sistema no puede conectarse a la base de datos, este archivo detiene la ejecución y muestra un error de conexión.

3. La Estética (`style.css`)
¿Qué hace?** Es el archivo que contiene todas las reglas de diseño visual (colores, tamaños, animaciones).
- Utiliza variables CSS (ej. `--primary`) para mantener los colores consistentes (tonos azules, oscuros y vibrantes).
- Implementa un estilo llamado **Glassmorphism**, que le da a las tarjetas un efecto de "vidrio esmerilado" mediante desenfoques (`backdrop-filter: blur`) y fondos semitransparentes.
- Define la Cuadrícula (*Grid*) que usamos para que las tarjetas de los motorizados se acomoden bien tanto en celulares como en pantallas grandes.

 4. La Puerta de Entrada (`index.php`)
¿Qué hace?** Es la primera pantalla que ve cualquier persona (El Login).
- Contiene el formulario HTML diseñado con los íconos dinámicos y el botón con efecto de brillo.
- En la parte superior de su código en PHP, revisa si ya hay una "sesión" abierta (si alguien ya inició sesión antes). Si es así, no te pide contraseña de nuevo, sino que te envía directamente a tu panel (Admin o Motorizado).

 5. El Portero (`login_process.php`)
¿Qué hace?** Es un archivo invisible para el usuario; procesa la información que envía el Login.
- Recibe el usuario y la contraseña desde `index.php`.
- Encripta la contraseña usando `MD5` (para igualar el formato de la base de datos de prueba) y hace una consulta SQL (`SELECT ... FROM trabajador`) buscando si las credenciales coinciden.
- Si coinciden:** Crea una `Sesión` en PHP (guarda tu ID, nombre y rol en la memoria del servidor) y, dependiendo de tu rol (`puesto`), te redirige:
- Si eres 'Motorizado' -> Te envía a `rider.php`.
- Si eres cualquier otra cosa ('Caja', 'Admin') -> Te envía a `admin.php`.
- Si no coinciden:** Te devuelve a `index.php` enviando un mensaje de error por la URL (`?error=Usuario o contraseña incorrectos`).

6. El Panel de Control (`admin.php`)
¿Qué hace?** Es el tablero central para los administradores o cajeros.
- Al cargar, lo primero que hace es validar que quien está intentando entrar *no sea un Motorizado* y sí haya iniciado sesión. Si falla esa regla de seguridad, lo expulsa.
- Hace una consulta SQL compleja usando `JOIN` para unir datos de 4 tablas a la vez (`delivery`, `venta`, `cliente`, `trabajador`).
- Dibuja una tabla HTML interactiva listando todas las entregas que están activas, quién es el cliente, su número, dirección, a qué motorizado se le asignó y el estado actual del pedido.

 7. La App del Trabajador (`rider.php`)
¿Qué hace?** Es el panel móvil para el repartidor.
- Verifica por seguridad que la persona que entra tenga estrictamente el rol de `'Motorizado'`.
- Hace una consulta a la base de datos filtrando **exclusivamente las entregas asignadas a él (`WHERE d.idMotorizado = $rider_id`).
- El Mapa interactivo:** Por cada entrega, lee las coordenadas `ubicacionGPS` (ej. `-17.7833,-63.1821`) e inyecta un pequeño código JavaScript usando la librería de código abierto Leaflet.js. Esto genera un mapa interactivo mostrando un marcador en la ubicación del cliente.
- Acciones:** Incluye botones (formularios ocultos) que, al presionarlos, recargan la página enviando una orden a la base de datos (`UPDATE delivery SET estadoEntrega = ...`) para cambiar el estado del pedido de Pendiente -> En Camino -> Entregado.

 8. La Salida (`logout.php`)
¿Qué hace?** Destruye el acceso.
- Simplemente inicia la herramienta de sesiones de PHP y ejecuta `session_destroy()`. Esto borra toda la memoria de "quién eres", efectivamente cerrando tu sesión. Luego te redirige de vuelta al Login. 

Todo este flujo forma una aplicación web segura, dinámica y que se conecta a datos reales simulados, cubriendo perfectamente el núcleo de tu diagrama de flujo original. ¿Tienes alguna duda sobre alguna de estas partes?
