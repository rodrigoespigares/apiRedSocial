<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Twitagram</title>
        <link rel="stylesheet" href="<?=BASE_URL?>public/css/style.css">
            <!--*-*-*-*-*-*-*-*-*-*-*-*-*-* CDN *-*-*-*-*-*-*-*-*-*-*-*-*-*-->
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>  <!-- VUE JS -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet"> <!-- Iconos remix icon -->
        <script src="https://kit.fontawesome.com/e161f36ce9.js" crossorigin="anonymous"></script> <!-- Iconos fontawesome -->
        <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- Iconos ed phosphor icon -->
        <script src="<?=BASE_URL?>public/js/index.js"></script>
    </head>
    <body id="body">
    
    <header>
        <div>
            <a href="<?=BASE_URL?>"><h1>Twitagram</h1></a>
            <nav>
                <h2>Publicaciones</h2>
                <a :href="'#'+item.id" v-for="item in endpoints">{{item.method}} {{item.name}}</a>
            </nav>
        </div>
        <div>
            <?php if(!isset($_SESSION['identity'])):?>
                <nav>
                    <a href="<?=BASE_URL?>login">Inicio Sesión</a>
                    <a href="<?=BASE_URL?>signup">Registro</a>
                </nav>
            <?php else: ?>
                <nav>
                    <a href="<?=BASE_URL?>logout">Cerrar sesión</a>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    
    <main>