
<?php

$location = $options_page; // Form Action URI

 $direct_path =  get_bloginfo('wpurl')."/wp-content/plugins/evm-portfolio";

?>

<div class="wrap"> 
	<h2>Portfolio Settings</h2>	
	<div style="margin-left:0px; float: left; width:100%;">
    <div class="inside">
		<form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>		
          
				<table class="form-table">                
                    
                     <tr>
						<th><label for="evm_color"> </label></th>
						<td>                            
    <input type="hidden" name="evm_color" value="<?php $evm_color = get_option('evm_color'); if(!empty($evm_color)) {echo $evm_color;} else {echo "#fff";}?>" />
                            </td>
					</tr>
                    
              <tr>
						<th><label for="evm_width">Width:</label></th>
						<td>                            
    <input type="text" name="evm_width" value="<?php $evm_width = get_option('evm_width'); if(!empty($evm_width)) {echo $evm_width;} else {echo "250px";}?>" />
                            </td>
					</tr>
                    
                    <tr>
						<th><label for="evm_height">Height:</label></th>
						<td>                            
    <input type="text" name="evm_height" value="<?php $evm_height = get_option('evm_height'); if(!empty($evm_height)) {echo $evm_height;} else {echo "350px";}?>" />
                            </td>
					</tr>
                    
               <tr>
						<th><label for="evm_tcolor">Title Color:</label></th>
						<td>                            
 <input type="text" name="evm_tcolor" value="<?php $evm_tcolor = get_option('evm_tcolor'); if(!empty($evm_tcolor)) {echo $evm_tcolor;} else {echo "#888";}?>" />
                            </td>
					</tr>
                    
                 <tr>
						<th><label for="evm_htcolor">Hover Title Color:</label></th>
						<td>                            
<input type="text" name="evm_htcolor" value="<?php $evm_htcolor = get_option('evm_htcolor'); if(!empty($evm_htcolor)) {echo $evm_htcolor;} else {echo "#fff";}?>" /> 
                            </td>
					</tr>
                                         
                    
                      <tr>
						<th><label for="evm_htbcolor">Hover Title Background Color:</label></th>
						<td>                            
<input type="text" name="evm_htbcolor" value="<?php $evm_htbcolor = get_option('evm_htbcolor'); if(!empty($evm_htbcolor)) {echo $evm_htbcolor;}
 else {echo "#289DCC";}?>" />   
                            </td> 
					</tr>
                                                
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="evm_color,evm_width,evm_height,evm_tcolor,evm_htcolor,evm_htbcolor" /> 
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