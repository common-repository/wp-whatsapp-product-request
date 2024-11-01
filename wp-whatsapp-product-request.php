<?php
/*
Plugin Name: Product Request by Chat
Plugin URI: https://danielesparza.studio/wp-whatsapp-product-request/
Description: Product Request by Chat (antes Whatsapp Product Request), es un Plugin para WordPress que agrega un botón en cada página de los productos para poder realizar consultas vía WhatsApp. Este Plugin hace uso de la API de WhatsApp para el envío de mensajes.
Version: 1.0
Author: Daniel Esparza
Author URI: https://danielesparza.studio/
License: GPL v3

Product Request by Chat
©2020 Daniel Esparza, inspirado por #openliveit #dannydshore | Consultoría en servicios y soluciones de entorno web - https://danielesparza.studio/

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if(function_exists('admin_menu_desparza')) { 
    //menu exist
} else {
	add_action('admin_menu', 'admin_menu_desparza');
	function admin_menu_desparza(){
		add_menu_page('DE Plugins', 'DE Plugins', 'manage_options', 'desparza-menu', 'wp_desparza_function', 'dashicons-editor-code', 90 );
		add_submenu_page('desparza-menu', 'Sobre Daniel Esparza', 'Sobre Daniel Esparza', 'manage_options', 'desparza-menu' );
	
    function wp_desparza_function(){  	
	?>
		<div class="wrap">
            <h2>Daniel Esparza</h2>
            <p>Consultoría en servicios y soluciones de entorno web.<br>¿Qué tipo de servicio o solución necesita tu negocio?</p>
            <h4>Contact info:</h4>
            <p>
                Sitio web: <a href="https://danielesparza.studio/" target="_blank">https://danielesparza.studio/</a><br>
                Contacto: <a href="mailto:hi@danielesparza.studio" target="_blank">hi@danielesparza.studio</a><br>
                Messenger: <a href="https://www.messenger.com/t/danielesparza.studio" target="_blank">enviar mensaje</a><br>
                Información acerca del plugin: <a href="https://danielesparza.studio/wp-whatsapp-product-request/" target="_blank">sitio web del plugin</a><br>
                Daniel Esparza | Consultoría en servicios y soluciones de entorno web.<br>
                ©2020 Daniel Esparza, inspirado por #openliveit #dannydshore
            </p>
		</div>
	<?php }
        
    }	
}


if ( ! function_exists( 'product_request_chat_add' ) ) {

add_action( 'admin_menu', 'product_request_chat_add' );
function product_request_chat_add() {
    add_submenu_page('desparza-menu', 'Product Request Chat', 'Product Request Chat', 'manage_options', 'product-request-chat-settings', 'product_request_chat_how_to_use' );
}

function product_request_chat_how_to_use(){  	

    if(isset($_POST['hidden_update']) == 'update'){
		if ( ! isset( $_POST['name_of_nonce_field'] ) || ! wp_verify_nonce( $_POST['name_of_nonce_field'], 'name_of_my_action' ) ) {
	   		exit;
		} else {
			update_option('wpwpr_phone', sanitize_text_field($_POST['phone']));
			update_option('wpwpr_message', sanitize_text_field($_POST['message']));
			update_option('wpwpr_buttontext', sanitize_text_field($_POST['buttontext']));
			?>
				<div id="message" class="updated">Los cambios han sigo guardados correctamente</div>
			<?php
		}
	}
	?>
		
    <div class="wrap">
        <h2>Product Request by Chat</h2>
        <p>Product Request by Chat (antes Whatsapp Product Request), es un Plugin para WordPress que agrega un botón en cada página de los productos para poder realizar consultas vía WhatsApp. Este Plugin hace uso de la API de WhatsApp para el envío de mensajes.</p>
        <h2>Product Request by Chat, ¿Como utilizar el Plugin?</h2>
            <ul>
                <li>1. <strong>(Requerido)</strong> Llena el campo "Número de WhatsApp" con el número de teléfono que utilizarás para recibir los mensajes (no es necesario agregar el signo +). <br>Ejemplos:<br>México: 5215500000000.<br>España: 34000000000.
                </li>
                <li>2. <strong>(Opcional)</strong> Cambia el texto que aparece antes de los detalles del producto en el campo "Mensaje antes del producto".</li>
                <li>3. <strong>(Opcional)</strong> Cambia el texto del botón en el campo "Texto del botón".</li>
            </ul>
        <form action="" method="post" id="wpwpr-options-form">
            <label>Número de WhatsApp (prefijo + número)*:</label> 
            <input type="number" id="phone" name="phone" pattern="[0-9]{1,18}" value="<?php esc_attr_e(get_option('wpwpr_phone')); ?>" placeholder="Ej. 00000000000" required/>
            <label>Mensaje antes del producto:</label>
            <input type="text" id="message" name="message" value="<?php esc_attr_e(get_option('wpwpr_message')); ?>" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
            <label>Texto del botón:</label>
            <input type="text" id="buttontext" name="buttontext" value="<?php esc_attr_e(get_option('wpwpr_buttontext')); ?>" placeholder="Consultas por WhatsApp" />
            <button type="submit"  name="submit_form"  form="wpwpr-options-form" value="Submit">Guardar datos</button>
            <input type="hidden" name="hidden_update" value="update" />
			<?php wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' ); ?>
        </form>
		 <h4>Más información sobre el uso de la API de WhatsApp:</h4>
			<ul>
				<li>API de WhatsApp: https://developers.facebook.com/docs/whatsapp</li>
				<li>Preguntas frecuentes: https://developers.facebook.com/docs/whatsapp/faq</li>
				<li>Cómo usar Clic para chatear: https://faq.whatsapp.com/es/android/26000030/</li>
				<li>Añadir un número de teléfono de otro país: https://faq.whatsapp.com/es/general/21016748</li>
			</ul>
    </div>
    <?php
}



// Add style and scripts
add_action( 'wp_enqueue_scripts', 'product_request_chat_register_style' );
function product_request_chat_register_style() {
    //css
    wp_register_style( 'product_request_chat_register_style_css', plugin_dir_url( __FILE__ ) . 'css/product-request-chat-style.css', array(), '1.0' );
    wp_enqueue_style( 'product_request_chat_register_style_css' );
    //scripts
}

add_action( 'admin_enqueue_scripts', 'product_request_chat_register_adminstyle' );
function product_request_chat_register_adminstyle() {
    wp_register_style( 'product_request_chat_register_adminstyle_css', plugin_dir_url( __FILE__ ) . 'css/product-request-chat-admin.css', array(), '1.0' );
    wp_enqueue_style( 'product_request_chat_register_adminstyle_css' );
}

add_action( 'woocommerce_single_product_summary', 'product_request_chat_button', 30 );
function product_request_chat_button() {
    global $product, $_REQUEST;
    $icon = plugin_dir_url( __FILE__ ) . 'img/product-request-chat.svg';
    ?>    
        
    <a class="prc-button" href="https://api.whatsapp.com/send?phone=<?php esc_html_e(get_option('wpwpr_phone')); ?>&text=<?php esc_html_e(get_option('wpwpr_message')); ?><?php esc_html_e(' Nombre: ' . $product->get_name() . ', '); ?><?php esc_html_e('Precio: ' . $product->get_price() . ' '); ?><?php esc_html_e(get_permalink( $product->get_id() )); ?>" rel="noopener noreferrer" target="_blank"><img src="<?php esc_html_e( $icon ); ?>"><?php esc_html_e(get_option('wpwpr_buttontext')); ?></a>
    <?php
}
}