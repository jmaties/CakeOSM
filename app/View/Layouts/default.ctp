<html lang="es">
    <head>
        <title>OSM CakePHP
            | <?php echo $title_for_layout ?></title>


        <?php echo $this->Html->css('estilos', null, $options = array('media' => 'screen')); ?>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
        <?php
        echo $scripts_for_layout;
        ?>

    </head>
    <body onload="init();">

        <?php echo $content_for_layout; ?>


    </body>
</html>
