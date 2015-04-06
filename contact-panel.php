<?php
DEFINE('DIRNAME',basename(dirname(__FILE__)) );
/**
 * Callback function to the add_theme_page
 * Will display the theme options page
 */ 
function contact_page() {
?>
    <div class="section panel">
      <h1>Contact Details</h1>
      <form method="post" enctype="multipart/form-data"  action="options.php">
        <?php 
          settings_fields('contact_options'); 
        
          do_settings_sections('show_contact');
        ?>
        <p>Paste shortcode "<b>[showContact]</b>" in your post or page to get contact details.</p>
         <table>
          <tr>
            <th>Parameters</th>
            <th>Default</th>
            <th>Options</th>
          </tr>
          <tr>
            <th>show</th>
            <td>'all'</td>
            <td>'street','city','state','country','email','phone'</td>
          </tr>
        </table>        
        
        <p>Paste shortcode "<b>[goMap]</b>" in your post or page to get map.</p>        
        <p><b>Available Parameters for map: </b></p>
        <table>
          <tr>
            <th>Parameters</th>
            <th>Default</th>
            <th>Options</th>
          </tr>
          <tr>
            <th>block_type</th>
            <td>'.'</td>
            <td>'#'</td>
          </tr> <tr>
            <th>block</th>
            <td>'mapsetting'</td>
            <td>as per your wish</td>
          </tr> <tr>
            <th>width</th>
            <td>'100%'</td>
            <td>as per your wish</td>
          </tr> <tr>
            <th>height</th>
            <td>'500px'</td>
            <td>as per your wish</td>
          </tr>
        </table>       
        
            <p class="submit">  
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
            </p>  
            
      </form>
    </div>
    <?php
}

/**
 * Register the settings to use on the theme options page
 */
add_action( 'admin_init', 'contact_register_settings' );

/**
 * Function to register the settings
 */
function contact_register_settings() {
    // Register the settings with Validation callback
    register_setting( 
      'contact_options',
      'show_contact',
     	'contact_validate_settings' 
 	);

    // Add settings section
    add_settings_section( 
    	'contact_text_section',
     	'Contact Setting',
     	'contact_display_section',
     	'show_contact' 
 	);

    // Create textbox field
    $street = array(	    	
		      'type'      => 'text',
		      'id'        => 'contact_street',
		      'name'      => 'contact_street',
		      'desc'      => 'Enter Street Address',
		      'std'       => '',
		      'label_for' => 'contact_street',
		      'class'     => ''
    );

    add_settings_field( 'contact_street_address',
     	'Street Address',
     	'contact_display_setting',
     	'show_contact',
     	'contact_text_section',
     	$street
 	);

    // Create textbox field
    $city = array(	    	
		      'type'      => 'text',
		      'id'        => 'contact_city',
		      'name'      => 'contact_city',
		      'desc'      => 'Enter City',
		      'std'       => '',
		      'label_for' => 'contact_city',
		      'class'     => ''
    );

    add_settings_field( 'contact_city',
     	'City Address',
     	'contact_display_setting',
     	'show_contact', 
     	'contact_text_section', 
     	$city
 	);

 	// Create textbox field
    $state = array(	    	
		      'type'      => 'text',
		      'id'        => 'contact_state',
		      'name'      => 'contact_state',
		      'desc'      => 'Enter State/Province',
		      'std'       => '',
		      'label_for' => 'contact_state',
		      'class'     => ''
    );

    add_settings_field( 'contact_state_address',
     	'State',
     	'contact_display_setting',
     	'show_contact', 
     	'contact_text_section', 
     	$state
 	);

 	// Create textbox field
    $country = array(	    	
		      'type'      => 'text',
		      'id'        => 'contact_country',
		      'name'      => 'contact_country',
		      'desc'      => 'Enter Country',
		      'std'       => '',
		      'label_for' => 'contact_country',
		      'class'     => ''
    );

    add_settings_field( 'contact_country_address',
     	'Country',
     	'contact_display_setting',
     	'show_contact', 
     	'contact_text_section', 
     	$country
 	);

      // Create textbox field
    $email = array(       
          'type'      => 'email',
          'id'        => 'contact_email',
          'name'      => 'contact_email',
          'desc'      => 'Enter email Address',
          'std'       => '',
          'label_for' => 'contact_email',
          'class'     => ''
    );

    add_settings_field( 'contact_email',
      'Email',
      'contact_display_setting',
      'show_contact', 
      'contact_text_section', 
      $email
  );

      // Create textbox field
    $phone = array(       
          'type'      => 'text',
          'id'        => 'contact_phone',
          'name'      => 'contact_phone',
          'desc'      => 'Enter Phone number',
          'std'       => '',
          'label_for' => 'contact_phone',
          'class'     => ''
    );

    add_settings_field( 'contact_phone',
      'Phone',
      'contact_display_setting',
      'show_contact', 
      'contact_text_section', 
      $phone
  );
}

/**
 * Function to add extra text to display on each section
 */
function contact_display_section($section){ 

}

/**
 * Function to display the settings on the page
 * This is setup to be expandable by using a switch on the type variable.
 * In future you can add multiple types to be display from this function,
 * Such as checkboxes, select boxes, file upload boxes etc.
 */
function contact_display_setting($args) {
    extract( $args );

    $option_name = 'show_contact';

    $options = get_option( $option_name );
    switch ( $type ) {  
          case 'text':  
              $options[$id] = isset($options[$id])?$options[$id]:'';
              $options[$id] = stripslashes($options[$id]);  
              $options[$id] = esc_attr( $options[$id]);  
              echo "<input class='regular-text $class' type='text' id='$id' name='" . $option_name . "[$id]' value='".$options[$id]."' />";  
              echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
          break;

          case 'email':
            $options[$id] = isset($options[$id])?$options[$id]:'';
            $options[$id] = stripslashes($options[$id]);  
            $options[$id] = esc_attr( $options[$id]);  
            echo "<input class='regular-text $class' type='email' id='$id' name='" . $option_name . "[$id]' value='".$options[$id]."' />";  
            echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
          break;
    }
}

/**
 * Callback function to the register_settings function will pass through an input variable
 * You can then validate the values and the return variable will be the values stored in the database.
 */
function contact_validate_settings($input) {
  // print_r($input);die;
  foreach($input as $k => $v) {
    $newinput[$k] = trim($v);
    
    // Check the input is a letter or a number
    if(!preg_match('/^[A-Z0-9 _]*$/i', $v)) {
      $newinput[$k] = '';
    }
  }

  return $input;
}






function showContactShortCode($atts){
  $param = shortcode_atts(
        array(
          'show'=>'all',
          ),$atts
      );

    $option_name = 'show_contact';
    $options = get_option( $option_name );
    $loc = '';
    if($param['show']=="all"){
    $loc = $options['contact_street'].", ".$options['contact_city'].", ".$options['contact_state'].", ".$options['contact_country'];
    }else {
      $loc = $options['contact_'.$param['show']];
    }
    $contact = $loc;
     return $contact;
  }
  add_shortcode('showContact','showContactShortCode'); 

//displaying map

function contact_include_scripts(){
  if(!wp_script_is('jquery')) {
      // do nothing 
      wp_enqueue_script( 'jquery' );
  }
    wp_enqueue_script('google-map','http://maps.google.com/maps/api/js?sensor=false');
    wp_enqueue_script('jquery-map',plugins_url().'/'.DIRNAME.'/js/jquery.gomap-1.3.2.min.js');
}
add_action( 'wp_enqueue_scripts', 'contact_include_scripts' );

function goMapShortCode($atts){
    $param = shortcode_atts(
          array(
            'width'=>'100%',
            'height'=> '500px',
            'block_type'=>'#',
            'block' => 'mapsetting',
            ),$atts
        );
    $option_name = 'show_contact';
    $options = get_option( $option_name );
    
    $width = $param['width'];
    $height = $param['height'];
    $blockType = ($param['block_type']==".")?'.':'#';
    $block = $blockType.$param['block'];


    $loc = $options['contact_street'].", ".$options['contact_city'].", ".$options['contact_state'].", ".$options['contact_country'];
    
    $map = " <script type='text/javascript'>
          jQuery(document).ready(function() {

             jQuery('".$block."').goMap({
                  address: '".$loc."',
                  zoom: 16,
                  scaleControl: true,
                  scrollwheel: false, 
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

          </script>    

        <div id='mapsetting'>         
        </div>";
     return $map;
  }

  add_shortcode('goMap','goMapShortCode');