<?php
    require './includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor">
        <h1>Contacto</h1>
        <picture>
            <source srcset="build/img/destacada3.webp" type="webp">
            <source srcset="build/img/destacada3.jpg" type="jpeg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="Texto entrada blgo">
        </picture>

        <h2>Llene el formulario de contacto</h2>
        <form class="formulario">
            <fieldset>
                <legend>Informacion personal</legend>
                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Tu nombre" id="nombre">

                <label for="email">E-Mail</label>
                <input type="email" placeholder="Tu email" id="email">

                <label for="telefono">Telefono</label>
                <input type="tel" placeholder="Tu telefono" id="telefono">

                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje"></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion sobre la propiedad</legend>
                <label for="opciones">Vende o Compra: </label>
                <select id="opciones">
                    <option value="" disabled selected>Seleccione</option>
                    <option value="compra">Compra</option>
                    <option value="vende">Vende</option>
                </select>

                <label for="presupuesto">Precio o presupuesto</label>
                <input type="number" placeholder="Tu precio o presupuesto" id="presupuesto">
            </fieldset>

            <fieldset>
                <legend>Informacion sobre la propiedad</legend>
                <p>Como desea ser contactado</p>

                <div class="forma-contacto">
                    <label for="contactar-telefono">Telefono</label>
                    <input name="contacto" type="radio" value="telefono" id="contactar-telefono">

                    <label for="contactar-email">Email</label>
                    <input name="contacto" type="radio" value="email" id="contactar-email">
                    
                </div>

                <p>Si eligio telefono, elija la fecha y la hora</p>

                <label for="fecha">Fecha</label>
                <input type="date" id="fecha">

                <label for="hora">Hora</label>
                <input type="time" id="hora" min="09:00" max="18:00">
            </fieldset>

            <input type="submit" value="Enviar" class="boton-verde">
            
        </form>
    </main>
    
<?php
    incluirTemplate('footer');
?>