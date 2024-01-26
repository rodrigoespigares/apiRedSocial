<section id="main">
    <h2>Documentación de la API REST</h2>
    <p>Twitagram es una api con capacidad de gestión de la base de datos para cursos y gestion de publicaciones devuelto en JSON.</p>
    <p>¿Quieres diseñar una red social de forma rápdia? Esta es tu api para empeza</p>
    <p>Puedes ver más información de los datos en los ejemplos siguientes de la en la aplicación</p>
    <h3>End point</h3>
    <section :id="item.id" v-for="item in endpoints">
        <h4><span :class="item.method">{{item.method}}</span> {{item.name}} <button @click="click(item.id)"><i class="ph ph-caret-down"></i></button></h4>
        <article v-if="item.show">
            <p>{{item.description}}</p>
            <h4>Ejemplo:</h4>
            <?php if(isset($_SESSION['identity'])) :?>
                <button @click="peticion(item.name)">Hacer peticion</button>
            <?php endif;?>
            <h4>Respuestas</h4>
            <table>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                </tr>
                <tr v-for="respuesta,key in item.respuestas">
                    <td>{{key}}</td>
                    <td>{{respuesta}}</td>
                </tr>
            </table>
        </article>
    </section>
</section>