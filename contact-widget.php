<?php

function register_map_contact_detail(){
	register_widget('show_map');
	// register_widget('show_contact');
} 
add_action('widgets_init','register_map_contact_detail');

class show_map extends WP_Widget {
	function __construct() {
	  parent::__construct(
	   // base ID of the widget
	   'show_map',
	   // name of the widget
	   __('Show Map', 'map' ),
	   // widget options
	   array (
	       'description' => __( 'Display Map', 'map' )
	   )
	  );
	}
	 
	function form( $instance ) {
	  $defaults = array(
  		  'street' => '',
		  'city' => '',
		  'state' => '',
		  'country' => '',
	      'width' => '100%', 
	      'height' => '500px',
	      'block_type' => '#',
	      'block' => 'mapsetting'
	  );
	  $street = $instance[ 'street' ];
	  $city = $instance[ 'city' ];
	  $state = $instance[ 'state' ];
	  $country = $instance[ 'country' ];
	  
	  $width = ($instance['width']!='')?$instance[ 'width' ]:$defaults['width'];
	  $height = ($instance['height']!='')?$instance[ 'height' ]:$defaults['height'];
	  $block_type = ($instance['block_type']!='')?$instance[ 'block_type' ]:$defaults['block_type'];
	  $block = ($instance['block']!='')?$instance[ 'block' ]:$defaults['block'];
	  // markup for form 
	  ?>
	  <p>
	      <label for="<?php echo $this->get_field_id( 'street' ); ?>">Street:</label>
	      <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'street' ); ?>" name="<?php echo $this->get_field_name( 'street' ); ?>" value="<?php echo esc_attr( $street ); ?>">	
	  </p>
	  <p>
	      <label for="<?php echo $this->get_field_id( 'city' ); ?>">City:</label>
	      <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" value="<?php echo esc_attr( $city ); ?>">	
	  </p>
	  <p>
	      <label for="<?php echo $this->get_field_id( 'state' ); ?>">State:</label>
	      <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'state' ); ?>" name="<?php echo $this->get_field_name( 'state' ); ?>" value="<?php echo esc_attr( $state ); ?>">	
	  </p>
	  <p>
	      <label for="<?php echo $this->get_field_id( 'country' ); ?>">Country:</label>
	      <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'country' ); ?>" name="<?php echo $this->get_field_name( 'country' ); ?>" value="<?php echo esc_attr( $country ); ?>">	
	  </p>

	  <p>
	      <label for="<?php echo $this->get_field_id( 'width' ); ?>">Width:<span>Default : 100%</span></label>
	      <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo esc_attr( $width ); ?>">	
	  </p>
	  <p>
	      <label for="<?php echo $this->get_field_id( 'height' ); ?>">Height :<span>Default: 500px</span></label>
	      <input class="widefat" type="text" id="<?=$this->get_field_id('height')?>" name="<?=$this->get_field_name('height')?>" value="<?=esc_attr($height)?>" />
	   </p> 
	   <p>
	    <label for="<?php echo $this->get_field_id( 'block_type' ); ?>">Identifier/class : <span>Default: #</span></label>
	    <input class="widefat" type="text" id="<?=$this->get_field_id('block_type')?>" name="<?=$this->get_field_name('block_type')?>" value="<?=esc_attr($block_type)?>" />
	   </p> 
	   <p>
	        <label for="<?php echo $this->get_field_id( 'block_type' ); ?>">Identifier/class Name :<span>Default: mapsetting</span></label>
	    <input class="widefat" type="text" id="<?=$this->get_field_id('block')?>" name="<?=$this->get_field_name('block')?>" value="<?=esc_attr($block)?>" />	    
	   </p>
	     
	<?php
	}
	 
	function update( $new_instance, $old_instance ) {
	  $instance = $old_instance;
	  // $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
	  $instance['street'] = strip_tags( $new_instance['street'] );
	  $instance['city'] = strip_tags( $new_instance['city'] );
	  $instance['state'] = strip_tags( $new_instance['state'] );
	  $instance['country'] = strip_tags( $new_instance[ 'country'] );

	  $instance['width'] = strip_tags( $new_instance['width'] );
	  $instance['height'] = strip_tags( $new_instance['height'] );	 
	  $instance['block_type'] = strip_tags( $new_instance['block_type'] );
	  $instance['block'] = strip_tags( $new_instance['block'] );
	 
	  return $instance;
	}
	 
	function widget( $args, $instance ) {
	     // kick things off 
		if(!wp_script_is('jquery')) {
		    // do nothing 
		    wp_enqueue_script( 'jquery' );
		}
	  	if(!wp_script_is('google-map')){
	  		wp_enqueue_script('google-map','http://maps.google.com/maps/api/js?sensor=false');
	  	}

	  	if(!wp_script_is('jquery-map')){
	  		wp_enqueue_script('jquery-map',plugins_url().'/'.DIRNAME.'/js/jquery.gomap-1.3.2.min.js');	  		
	  	}
		extract( $args );
		echo $before_widget;

		$defaults = array(
  		  'street' => '',
		  'city' => '',
		  'state' => '',
		  'country' => '',
	      'width' => '100%', 
	      'height' => '500px',
	      'block_type' => '#',
	      'block' => 'mapsetting'
	  );		


		$loc = $instance['street'].", ".$instance['city'].", ".$instance['state'].", ".$instance['country'];
		$width = ($instance['width']!='')?$instance[ 'width' ]:$defaults['width'];
		$height = ($instance['height']!='')?$instance[ 'height' ]:$defaults['height'];
		$blockType = ($instance['block_type']!='')?$instance[ 'block_type' ]:$defaults['block_type'];	  
		$blockName = ($instance['block']!='')?$instance[ 'block' ]:$defaults['block'];		
    	$block = $blockType.$blockName;
    
    	$map = " <script type='text/javascript'>
		            //<![CDATA[
		          jQuery(document).ready(function() {

		             jQuery('".$block."').goMap({
		                  address: '".$loc."',
		                  zoom: 16,
		                  scaleControl: true,
		                  scrollwheel: false,
		                  navigationControl: true,
		                  mapTypeControl: true, 
		                  maptype: 'ROADMAP'
		              });
		              jQuery.goMap.createMarker({
		                        address: '".$loc."'
		                      });
		          jQuery('".$block."')
		              .css({
		                'height':'".$height."',
		                'width':'".$width."'  
		                  })
		            });
		          //]]>
		          </script>    

		        <div id='".$blockName."'>         
		        </div>";
        	echo $map;
	        echo $after_widget;      
	}

}
