Adminwebmail
============
La idea de este proyector es mostrar mi experiencia como programador.

Sobre todo, mi intención ante todo era de generar el código más limpio posible entendible y seguro.

La idea de esta aplicación es acceder a la gestión de nuestro servidor webmail preparado en: 
http://sefirosweb.es/ubuntu/mailserver/

Solo debes cambiar los parámetros en relación a tu servidor y listo

// app/cofig/parameters.yml

Para acceder el usuario es admin, y la contraseña que indicéis en parameters.yml.

El modelo de la Base de datos está basado en doctrine, así que con tan solo actualizar las tablas con el siguiente comando es suficiente:

php bin/console doctrine:schema:update --force --full-database
