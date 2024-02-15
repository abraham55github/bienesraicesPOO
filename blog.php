<?php
    require './includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor contenido-centrado">
        <h1>Nuestro Blog</h1>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="webp">
                    <source srcset="build/img/blog1.jpg" type="jpeg">
                    <img loading="lazy" src="build/img/blog1.jpg" alt="Texto entrada blgo">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Terraza en el techo de tu casa</h4>
                    <p class="informacion-meta">Escrito el :<span>20/10/2023</span> por: <span>Admin</span></p>
                    <p>
                        Consejos para contruir una terraza en el techo de tu casa
                        con los mejores materias y ahorrando dinero.
                    </p>
                </a>

            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="webp">
                    <source srcset="build/img/blog2.jpg" type="jpeg">
                    <img loading="lazy" src="build/img/blog2.jpg" alt="Texto entrada blgo">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Guia para decoracion de hogar</h4>
                    <p class="informacion-meta">Escrito el :<span>20/10/2023</span> por: <span>Admin</span></p>
                    <p>
                        Maximizar el espacio en tu hogar con esta guia,
                        aprende a combinar muebles y colores para darle vida a tu espacio
                    </p>
                </a>

            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog3.webp" type="webp">
                    <source srcset="build/img/blog3.jpg" type="jpeg">
                    <img loading="lazy" src="build/img/blog3.jpg" alt="Texto entrada blgo">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Guia para decoracion de hogar</h4>
                    <p class="informacion-meta">Escrito el :<span>20/10/2023</span> por: <span>Admin</span></p>
                    <p>
                        Maximizar el espacio en tu hogar con esta guia,
                        aprende a combinar muebles y colores para darle vida a tu espacio
                    </p>
                </a>

            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog4.webp" type="webp">
                    <source srcset="build/img/blog4.jpg" type="jpeg">
                    <img loading="lazy" src="build/img/blog4.jpg" alt="Texto entrada blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Guia para decoracion de hogar</h4>
                    <p class="informacion-meta">Escrito el :<span>20/10/2023</span> por: <span>Admin</span></p>
                    <p>
                        Maximizar el espacio en tu hogar con esta guia,
                        aprende a combinar muebles y colores para darle vida a tu espacio
                    </p>
                </a>

            </div>
        </article>
    </main>
    
<?php
    incluirTemplate('footer');
?>