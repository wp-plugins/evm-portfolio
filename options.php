<?php $direct_path =  get_bloginfo('wpurl')."/wp-content/plugins/evm-portfolio";  ?>
<div class="wrap"> 
	<h2>Portfolio Settings</h2>	
	<div style="margin-left:0px; float: left; width:100%;">
    <div class="inside">
		<form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>
			
            	<div class="social"><h3>Add social sharing buttons on your portfolio items</h3><br/> You can select which sharing icon you want to enable.</div>
				<table class="form-table">                
                	<tr>
						<th><label for="evm_fb">Facebook:</label></th>
						<td><select name="evm_fb" id="evm_fb">

								<option value="true" <?php if(get_option('evm_fb') == "true") {echo "selected='selected'";}?>>Yes</option>

								<option value="false" <?php if(get_option('evm_fb') == "false") {echo "selected='selected'";}?>>No</option>

							</select></td>
					</tr>  
                    <tr>
						<th><label for="evm_twitter">Twitter:</label></th>
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
						<td><p class="submit"><input class="submit_button" type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p></td>   
					</tr>  
				</table>               
                <p>To show the portfolio on your website, use the shortcode or php code provided here:	<br/>
                    
					Shortcode to add in post/page editor or widgets - <b>[evm-portfolio]</b><br/>
                    
					Phpcode to add in template php files - <b>evm_portfolio();</b></p>			
			
		</form>
        </div>
        <div class="right_section"> 
        <h3 class="title"><span>About <span style="float:right;">Version <b>1.2</b></span></span></h3>       
         <div class="title_block">EVM Portfolio Plugin by Expert Village Media. If you have any issue regarding the plugin then email us.
<br /><br />If you need any customizations in your wordpress theme or need a completely new wordpress theme design then feel free to contact us here: <a href="mailto:info@expertvillagemedia.com">info@expertvillagemedia.com</a>
	
         </div>
                	<a href="http://www.expertvillagemedia.com" target="_blank"><img src="<?php echo $direct_path ?>/img/banner.jpg"/></a>
        </div>
	</div>
	</div>
<style type="text/css">
.form-table{ float:left; width:400px;color:#222;}
.inside{ float:left; width:40%;}
.inside p{ float:left;}
.right_section{ float:right; width:50%; color:#222;}
.right_section img{ max-width:100%;}
.right_section .title{ background-color:#3A8BDE; color:#fff; padding:10px; margin:0; font-weight:bold; font-size:16px; border-radius:5px 5px 0px 0;}
.right_section .title span{font-weight:bold;}
.title_block{ border:1px solid #3A8BDE; padding:10px;}


</style>