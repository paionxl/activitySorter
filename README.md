Endpoints: (la colección de postman está en activitySorter.postman_collection.json)
        Find:
            Puedes filtrar por parte de nombre, parte de descripción, un tipo, un equipamiento, una plataforma y un tipo de deporte.
            Si no se selecciona un tipo busca en todas las actividades y aplica los filtros en todas.
        Add:
            Debe tener un tipo seleccionado. El equipamiento es opcional en el caso de aventura. En los otros dos, sus
            propiedades son obligatorias.

Como ejecutar:
        'docker-compose up -d' para levantar el proyecto.
        'docker exec -i app composer install' para las dependencias.
        'docker exec -i db mysql -u root -padmin < ./sqls.sql' para crear las tablas de base de datos.

Tests de ejemplo:
        Tests\Application\Activity\Adapter\ActivityCollectionAdapterTest
        Tests\Application\Activity\Add\AddActivityServiceTest
        Tests\Domain\Activity\OnlineGameActivity\OnlineGameActivityTest
        Tests\Application\Activity\OnlineGameActivity\Add\AddOnlineGameActivityServiceRequestTest
        Tests\Domain\Activity\ActivityTypeTest
