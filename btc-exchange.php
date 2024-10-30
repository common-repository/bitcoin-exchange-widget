<?php
/**
 * @package btc-exchange
 * @version 1.15
 */
/*
Plugin Name: BTC Exchange Rate Widget
Plugin URI: http://wordpress.org/plugins/btc-exchange-widget/
Description: Show BTC exchange rates in sidebar widgets. Rates shown in 16 different international currencies.
Author: Bradford Knowton
Version: 1.15
Author URI: http://bradknowlton.com/
License: GPLv2 or later

*/

define('BLOCKCHAIN_TICKET_URL','http://blockchain.info/ticker');

/**
 * Adds Btc_Exchange_Widget widget.
 */
class Btc_Exchange_Widget extends WP_Widget {
	// property declaration
    protected $url = BLOCKCHAIN_TICKET_URL; 
    protected $displayed_values = array();
    
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Btc_Exchange_widget', // Base ID
			__('Btc Exchange Widget', 'text_domain'), // Name
			array( 'description' => __( 'A Btc_Exchange Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		$json = $this->load_json($this->url);
		
		echo '<ul class="bitcoin-widget-list">';
		foreach($json as $key => $value){
			
			if(in_array($key, $instance['displayed_values'])){
				echo sprintf("<li>1 BTC = %s %.2f %s</li>", $value->symbol, $value->{'15m'}, $key);	
			}
			
		}
		echo '</ul>';
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		
		if ( isset( $instance ) ) {
			$title = esc_attr($instance[ 'title' ]);
			$displayed_values = $instance['displayed_values'];
		}
		else {
			$title = __( 'New title', 'text_domain' );
			$displayed_values = array();
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'displayed_values' ); ?>"><?php _e( 'Currencies to Display in Widget:' ); ?></label> 
		<ul>
		<?php
		$json = $this->load_json($this->url);
				
		echo '<ul class="bitcoin-widget-list">';
		foreach($json as $key => $value){
			?>	
				<li>
				<label for="displayed_values_<?php echo $key; ?>">
				<input class="" id="displayed_values_<?php echo $key; ?>" name="<?php echo $this->get_field_name('displayed_values'); ?>[]" type="checkbox" value="<?php echo esc_attr( $key ); ?>"
					<?php if(in_array($key, $displayed_values)){echo ' checked="checked" '; } ?>
				 /> <?php echo $key; ?></label>
				</li>
			<?php
		}
		?>
		</ul>
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
	
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['displayed_values'] = ( ! empty( $new_instance['displayed_values'] ) ) ? $new_instance['displayed_values'] : array();

		return $instance;
	}
	
	/**
	 * Load json url.
	 *
	 *
	 * @param string $url url to load.
	 *
	 * @return array json decoded values.
	 */
	public function load_json($url = ""){
		
		if(!$url){
			return;
		}
		
		// setup key to index cache
		$key = md5($url);
		
		// check cache, if it exists otherwise reload url
		$result = wp_cache_get( 'btc_exchange_widget_'.$key );
		if ( false === $result ) {
			$result = wp_remote_get($url);
			
			if ( is_wp_error( $result ) ) {
			   return "";
			} 
			
			wp_cache_set( 'btc_exchange_widget_'.$key, $result['body'], 'btc_exchange', 15*60 );
		} 
		// Do something with $result;
	
		// decode the response body
		$json = json_decode($result['body']);
	
		return $json;
		
	}

} // class Btc_Exchange_Widget

// $btc_exchange_widget = new Btc_Exchange_Widget();

// register Foo_Widget widget
function register_btc_exchange_widget() {
    register_widget( 'Btc_Exchange_Widget' );
}
add_action( 'widgets_init', 'register_btc_exchange_widget' );