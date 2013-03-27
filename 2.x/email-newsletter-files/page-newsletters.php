<?php
	global $email_builder;

    $newsletters = $this->get_newsletters();

    //Display status message
    if ( isset( $_GET['updated'] ) ) {
        ?><div id="message" class="updated fade"><p><?php echo urldecode( $_GET['dmsg'] ); ?></p></div><?php
    }

?>

    <div class="wrap">
        <h2>
        	<?php _e( 'Newsletters', 'email-newsletter' ) ?>
        	<a href="<?php echo $email_builder->generate_builder_link('new'); ?>" class="add-new-h2"><?php _e('Create New','email-newsletter'); ?></a>
        </h2>
        <p><?php _e( 'This page contains the list of all Newsletters.', 'email-newsletter' ) ?></p>
        <table id="newsletterList" class="widefat post">
            <thead>
                <tr>
                    <th class="subjectCol">
                        <?php _e( 'Email Subject', 'email-newsletter' ) ?>
                    </th>
                    <th>
                        <?php _e( 'Template', 'email-newsletter' ) ?>
                    </th>
                    <th>
                        <?php _e( 'Bounced', 'email-newsletter' ) ?>
                    </th>
                    <th>
                        <?php _e( 'Sent To', 'email-newsletter' ) ?>
                    </th>
                    <th>
                        <?php _e( 'Opened', 'email-newsletter' ) ?>
                    </th>
                    <th class="actionCol">
                        <?php _e( 'Actions', 'email-newsletter' ) ?>
                    </th>
                </tr>
            </thead>
        <?php
		global $email_builder;
        $i = 0;
		$template_query = array();
        if ( $newsletters )
            foreach( $newsletters as $key => $newsletter ) {
            	$template_id = $this->get_newsletter_meta($newsletter['newsletter_id'],'plugin_template_id');
				
				if($template_id != false) {
					$template_query[$template_id] = $newsletter;
					unset($newsletters[$key]);
					continue;
				}
				
                if ( $i % 2 == 0 )
                    echo "<tr class='alternate'>";
                else
                    echo "<tr class='' >";

                $i++;
        ?>
                <td class="subjectCol" style="vertical-align: middle;">
                    <?php echo $newsletter['subject']; ?><br />
                    <span class="description"><?php echo date( $this->settings['date_format'] . " h:i:s", $newsletter['create_date'] ); ?></span>
                </td>
                <td style="vertical-align: middle;">
                    <?php echo $newsletter['template']; ?>
                </td>
                <td style="vertical-align: middle;">
                    <?php echo $this->get_count_bounced( $newsletter['newsletter_id'] ); ?> <?php _e( 'members', 'email-newsletter' ) ?>
                </td>
                <td style="vertical-align: middle;">
                    <?php echo $this->get_count_sent( $newsletter['newsletter_id'] ); ?> <?php _e( 'members', 'email-newsletter' ) ?>
                </td>
                <td style="vertical-align: middle;">
                    <?php echo $this->get_count_opened( $newsletter['newsletter_id'] ); ?> <?php _e( 'members', 'email-newsletter' ) ?>
                </td>
                <td class="actionCol">
                    <a class="deleteNewsletter button button-secondary" href="?page=newsletters&newsletter_action=delete_newsletter&newsletter_id=<?php echo $newsletter['newsletter_id'];?>">
                        <?php _e( 'Delete', 'email-newsletter' ) ?>
                    </a>
                    <a class="button button-secondary" href="<?php echo $email_builder->generate_builder_link($newsletter['newsletter_id'],'admin.php?page=newsletters') ?>">
                        <?php _e( 'Edit', 'email-newsletter' ) ?>
                    </a>
                    <a class="button button-primary"  href="?page=newsletters&newsletter_action=send_newsletter&newsletter_id=<?php echo $newsletter['newsletter_id'];?>">
                        <?php _e( 'Send', 'email-newsletter' ) ?>
                    </a>
                </td>
            </tr>
        <?php
            }
        ?>
        </table>
		
    </div><!--/wrap-->
    <style type="text/css">
    	#newsletterList tbody td {
    		vertical-align: middle;
    	}
    	td.subjectCol,
    	th.subjectCol {
    		width: 350px;
    	}
    	td.actionCol,
    	th.actionCol {
    		width: 161px;
    	}
    	#newsletterList thead th.actionCol {
    		text-align: center;
    	} 
    </style>
    <script type="text/javascript">
    	jQuery(document).ready( function($) {
    		$('.deleteNewsletter').on('click', function() {
    			var choice = confirm("<?php _e('Are you sure you want to delete this newsletter?','email-newsletter'); ?>");
    			if(choice)
    				return true;
    			else
    				return false;
    		});
    	});
    </script>
