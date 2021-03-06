<?php

class Logo_Centre_Widget extends WP_Widget {

    // Create widget
    public function __construct() {
        parent::__construct(
                'logo_centre_widget', // Base ID
                'Fitxa del centre', // Name
                array('description' => 'Mostra les dades i, opcionalment, el logotip del centre. La informació es defineix a Aparença -> Personalitza -> Identificació del centre')
        );
    }

    // Front-End Display of the Widget
    public function widget($args, $instance) {

        // Saved widget options
        $title = $instance['title'];
        echo $args['before_widget'];

        if (!empty($title)) {
            echo '<h4 class="widget-title">' . $title . '</h4>';
        }

        $contacte = (strstr(reactor_option('emailCentre'), '@')) ? "mailto:" . reactor_option('emailCentre') : reactor_option('emailCentre');
        ?>
        <div class="targeta_id_centre row">
            <?php
            if (reactor_option('logo_image')) {
                if (reactor_option('logo_inline')) {
                    $class_logo = "logo_inline";
                    $class_addr = "addr-centre";
                    $amplada = "6";
                } else {
                    $class_logo = "logo_clear";
                    $class_addr = "logo_clear";
                    $amplada = "12";
                }
                ?>
                <div class="<?php reactor_columns(array($amplada, 12));
                echo " " . $class_logo; ?> hide-for-small"> 
                    <img src="<?php echo reactor_option('logo_image'); ?>">					
                </div> 
            <?php
            } else {
                $amplada = "12";
                $class = "no_logo";
            }
            ?>

        <?php list($postal_code, $locality) = explode(" ", reactor_option("cpCentre"), 1); ?>

            <div class="<?php reactor_columns($amplada); echo ' ' . $class_addr; ?> ">
                <div class="vcard">
                    <span id="tar-nomCentre"><?php echo reactor_option('nomCanonicCentre'); ?></span>
                    <div class="adr">
                        <span class="street-address"><?php echo reactor_option('direccioCentre'); ?></span><br>
                        <span class="postal-code"><?php echo trim($postal_code); ?></span> 
                        <span class="locality"><?php echo trim($locality); ?></span>  
                        <span class="region" title="Catalunya">Catalunya</span>
                        <span class="country-name">Espanya</span>
                        <div class="tel">
                            <span><?php echo reactor_option('telCentre'); ?></span>
                        </div>
                        <a id="tar-mapa" href="<?php echo reactor_option('googleMaps'); ?>">mapa</a> 
                        <span class="pipe" >|</span> 
                        <a id="tar-contacte" href="<?php echo $contacte; ?>">contacte</a>

                    </div>		 
                </div>	
            </div>		 
        </div>
        <?php echo $args['after_widget']; ?>
        <?php
    }

    // End function widget
    // Back-end form of the Widget
    public function form($instance) {

        // Check for values
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Títol:</label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>

        <?php
    }

    // Sanitize and return the safe form values
    public function update($new_instance, $old_instance) {
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

// Register widget
add_action('widgets_init', function() {
    register_widget('logo_centre_widget');
}
);
