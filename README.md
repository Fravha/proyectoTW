La Base de Datos (`database.sql`)
¿Qué hace?** 

Es el "cerebro" donde se almacena toda la información de forma persistente.
- El esquema del diagrama son en tablas de MySQL (`cliente`, `productos`, `trabajador`, `venta`, `delivery`, etc.).
- Las tablas están conectadas mediante **Llaves Foráneas** (Foreign Keys). Por ejemplo, la tabla `delivery` sabe qué trabajador está entregando el paquete porque guarda su `idMotorizado`.
- Agregué credenciales (Usuario y Contraseña) a los trabajadores para que el sistema sepa quién entra a la plataforma.

La Conexión (`config.php`)
¿Qué hace?** Es el puente de comunicación entre la página web (PHP) y la base de datos (MySQL).
- Contiene los datos de acceso a tu servidor WAMP (`localhost`, usuario `root`, sin contraseña).
- Todas las demás páginas incluyen este archivo secreto. Si el sistema no puede conectarse a la base de datos, este archivo detiene la ejecución y muestra un error de conexión.