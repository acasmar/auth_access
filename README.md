
# Configuraciones
    - Importante adaptar el archivo conection_example.php
    - En la carpeta Configuraciones, se encuentran dos archivos php.ini configurados para modo producción o modo develop, sería recomendable usar uno u otro en función de las necesidades.

# Mejoras
    - Separar el proyecto por directorios
    - Crear gestor de rutas
    - Script para creación de base de datos inicial
    - PhpMyAdmins solo en develop
    - Migrar proyecto a docker


# Instrucciones Inicio
    - Configurar conection_example.php y renombrarlo a conection.php
    - Instalar apache2
    - Instalar php8.2 o 8.3
    - Sustituir el archivo ini por el archivo ya configurado en ./Configuraciones/php.ini.dev|.prod

# Instrucciones Uso app

# Estructura web:
    index.phtml
        |
        ----- join.html
            |
            |
            ----- login.phtml---     |--- index.phtml (ROLE_USER AND ROLE_ADMIN)
            |                   |____|
            |                   |    |--- dashboard.phtml (ROLE_ADMIN)
            ----- sign.phtml ---


- Si visitamos el dominio asignado, nos aparecen dos opciones a elegir, "login" o "registrarse".
    
    # Primera página si no estamos logeados (sign.html)
    # Si estamos logeados - LOGIN (login.html)
    - Si clicamos en login, habrá una comprobación de sesión, para saber si ya estamos logeados, en caso afirmativo, nos redirige a la página correspondiente según el rol del usuario. Si no estamos logeados, nos redirige a la página de login.
        # dashboard.phtml (ROLE_ADMIN)
        # index.phtml (ROLE_USER)
    # Registrarse
    - Nos redirige a la página de registro.
    - Al registrar usuario, nos redirige a la página de login
