<div class="wrap"> 
	<h2>Portfolio Settings</h2>	
	<div style="margin-left:0px; float: left; width:800px;">
		<form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>
			<div class="inside">
            	<div class="social"><h3>Social icons on portfolios</h3></div>
				<table class="form-table">
                	<tr>
						<th><label for="evm_fb">Facebook:</label></th>
						<td><select name="evm_fb" id="evm_fb">

								<option value="true" <?php if(get_option('evm_fb') == "true") {echo "selected='selected'";}?>>Yes</option>

								<option value="false" <?php if(get_option('evm_fb') == "false") {echo "selected='selected'";}?>>No</option>

							</select></td>
					</tr>  
                    <tr>
						<th><label for="evm_twitter">Twiiter:</label></th>
						<td><select name="evm_twitter" id="evm_social">

								<option value="true" <?php if(get_option('evm_twitter') == "true") {echo "selected='selected'";}?>>Yes</option>

								<option value="false" <?php if(get_option('evm_twitter') == "false") {echo "selected='selected'";}?>>No</option>

							</select></td>
					</tr>           
                    <tr>
						<th><label for="evm_linkedin">Linkedin:</label></th>
						<td><select name="evm_linkedin" id="evm_social">

								<option value="true" <?php if(get_option('evm_linkedin') == "true") {echo "selected='selected'";}?>>Yes</option>

								<option value="false" <?php if(get_option('evm_linkedin') == "false") {echo "selected='selected'";}?>>No</option>

							</select></td>
					</tr>                             
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="page_options" value="evm_fb,evm_twitter,evm_linkedin" />
					<tr>
						<td><p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p></td>   
					</tr>  
				</table>
                <p>To show the portfolio on your website, use the shortcode or php code provided here:	<br/>
                    Shortcode to add in post/page editor or widgets - [evm-portfolio]<br/>
                    Phpcode to add in template php files - evm_portfolio();<br/>
                </p>
			</div>
		</form>
	</div>
	</div>