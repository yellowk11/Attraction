
    <?php 
    if ( ! defined( 'ABSPATH' ) ) exit;
    $shopid = sanitize_text_field(get_option('accessibility_shopid'));
    $token = get_option('accessibility_tokken');
    $accessibility_url = get_option('accessibility_url');
    $data = array('shopid' => $shopid,);
    $content = assistant_api_call('/getShopData', $data,'get');
    if(empty($accessibility_url))
    {
    update_option('accessibility_url',sanitize_text_field($content['data']['url']));
    }

    if(isset($_POST['btnAdd']))
    {
    if ( ! isset( $_POST['accessibility_nonce'] ) || ! wp_verify_nonce( $_POST['accessibility_nonce'], 'accessibility_nonce' ) ) {
     
       print 'Sorry, You can not update....';
       exit;
     
    } else {
     
        $widget_enable =0;
        $position = $paddingrangeInput = $backgroundcolor = $fontcolor = $iconcolor = $keybaord_nav = $curson = $big_curson = $reading_guide = $desaturate = $contrast = $invert_contrast = $dark_contrast = $light_contrast= $bigger_text = $highlight_links = $reset_all = "";
        $error = array();
        $jsChecked = "off";
        if(isset($_POST['jsChecked']))
        {
        $widget_enable = sanitize_text_field($_POST['jsChecked']);
        if ($widget_enable == 1) {
            $jsChecked = "on";
        }
        }
        $position = sanitize_text_field($_POST['position']); if(empty($position)){ $error[] = "Position shoud not empty."; }
        $paddingrangeInput = sanitize_text_field($_POST['bottom_padding']); //if(is_numeric($paddingrangeInput)){ $error[] = "Padding shoud be number."; }
        $backgroundcolor = sanitize_hex_color($_POST['backgroundcolor']); if(empty($backgroundcolor)){ $error[] = "Background Color shoud not empty."; }
        $fontcolor = sanitize_hex_color($_POST['fontcolor']); if(empty($fontcolor)){ $error[] = "Front Color shoud not empty."; }
        $iconcolor = sanitize_hex_color($_POST['iconcolor']); if(empty($iconcolor)){ $error[] = "Icon Color shoud not empty."; }
        $keybaord_nav = sanitize_text_field($_POST['keybaord_nav']); if(empty($keybaord_nav)){ $error[] = "Keybaord shoud not empty."; }
        $curson = sanitize_text_field($_POST['curson']); if(empty($curson)){ $error[] = "Cursor shoud not empty."; }
        $big_curson = sanitize_text_field($_POST['big_curson']); if(empty($big_curson)){ $error[] = "Big Cursor shoud not empty."; }
        $reading_guide = sanitize_text_field($_POST['reading_guide']);if(empty($reading_guide)){ $error[] = "Reading Guide Color shoud not empty."; }
        $desaturate = sanitize_text_field($_POST['desaturate']);if(empty($desaturate)){ $error[] = "Desaturate shoud not empty."; }
        $contrast = sanitize_text_field($_POST['contrast']);if(empty($contrast)){ $error[] = "Contrast shoud not empty."; }
        $invert_contrast = sanitize_text_field($_POST['invert_contrast']);if(empty($invert_contrast)){ $error[] = "Invert Colors shoud not empty."; }
        $dark_contrast = sanitize_text_field($_POST['dark_contrast']);if(empty($dark_contrast)){ $error[] = "Dark Contrast shoud not empty."; }
        $light_contrast = sanitize_text_field($_POST['light_contrast']);if(empty($light_contrast)){ $error[] = "Light Contrast shoud not empty."; }
        $bigger_text = sanitize_text_field($_POST['bigger_text']);if(empty($bigger_text)){ $error[] = "Bigger Text shoud not empty."; }
        $highlight_links = sanitize_text_field($_POST['highlight_links']);if(empty($highlight_links)){ $error[] = "Highlight Links shoud not empty."; }
        $reset_all = sanitize_text_field($_POST['reset_all']);if(empty($reset_all)){ $error[] = "Reset all shoud not empty."; }

        if($backgroundcolor == $iconcolor )
        {
            $error[] = "Background Color and Icon Color should not same.";
        }

        if(empty($error))
        {
            $send_data = array(
                'shopid' => $shopid,
                'position' => $position,
                'jsChecked' => $jsChecked,
                'backgroundcolor' => $backgroundcolor,
                'fontcolor' => $fontcolor,
                'iconcolor' => $iconcolor, 
                'bottom_padding' => $paddingrangeInput,
                'keybaord_nav' => $keybaord_nav,
                'curson' => $curson,
                'big_curson' => $big_curson,
                'reading_guide' => $reading_guide,
                'desaturate' => $desaturate, 
                'contrast' => $contrast,
                'invert_contrast' => $invert_contrast,
                'dark_contrast' => $dark_contrast,
                'light_contrast' => $light_contrast,
                'bigger_text' => $bigger_text,
                'highlight_links' => $highlight_links,
                'reset_all' => $reset_all,
                );
        }else{
            echo '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error! </strong>';
            foreach($error as $err)
            {
            echo ' '.$err.', ' ;
            }  
          	echo '</div>';
        }

        $returnsenddata = assistant_api_call('/updateShopData', $send_data,'post');
        if($returnsenddata['status'] == 200){
            echo '<div  class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success! </strong> </div>';
            $data = array('shopid' => $returnsenddata['data']['shopid'],);
            $content = assistant_api_call('/getShopData', $data,'get');
        }else{
            echo '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error! </strong>';
            echo $returnsenddata['messages'];
            echo '</div>';
        } 
    }
}
 
    ?>
<div class="accessibility_dashboard">
<form method="post" id="accessibility_dashboard_form" >
<?php wp_nonce_field( 'accessibility_nonce', 'accessibility_nonce' ); ?>
<input id="shopid" type="hidden" name="shopid" class="form-control" value="<?php echo $shopid; ?>">
    <div class="widget_section">
        <h3 class="medium-heading">Widget Optinon</h3>

            <div class="row align-center">                                 
                <div class="col-sm-4">
                    <div class="widgetenable">
                        <label class="switch">Enable/Disable
                        <input type="checkbox" name="jsChecked" id="widget_enable" <?php if($content['data']['status'] == 1){ echo "checked"; } ?> value="1">
                        <span class="slider round"></span>
                        </label> 
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                    <label>Position</label>
                    <select id="position" name="position" class="form-control" aria-invalid="false">
                    <option value="1" <?php if($content['data']['position'] == 1){ echo "selected"; } ?> >Top Left </option>
                    <option value="2" <?php if($content['data']['position'] == 2){ echo "selected"; } ?>  >Top Right </option>
                    <option value="3" <?php if($content['data']['position'] == 3){ echo "selected"; } ?>  >Middle Left </option>
                    <option value="4" <?php if($content['data']['position'] == 4){ echo "selected"; } ?>  >Middle Right </option>
                    <option value="5" <?php if($content['data']['position'] == 5){ echo "selected"; } ?>  >Bottom Left </option>
                    <option value="6" <?php if($content['data']['position'] == 6){ echo "selected"; } ?> >Bottom Right </option>
                    </select>   
                    </div>
                </div>
                                    
                <div class="col-sm-4">
                    <div id="cont">
                    <span id="zero">0</span>
                    <div class="flex-top">
                        <input name = 'bottom_padding' id='rangeInput' type=range min=0 max=100 value=<?php echo $content['data']['bottom_padding']; ?> step=1 list="numbers" oninput="amount.value=rangeInput.value" class="form-control" />
                        <datalist id="numbers">
                            <option value="0" label="0"></option>
                            <option value="10"></option>
                            <option value="20"></option>
                            <option value="30"></option>
                            <option value="40"></option>
                            <option value="50" label="50"></option>
                            <option value="60"></option>
                            <option value="70"></option>
                            <option value="80"></option>
                            <option value="90"></option>
                            <option value="100" label="100"></option>
                        </datalist>
                        <output id="amount" name="amount" for="rangeInput"><?php echo $content['data']['bottom_padding']; ?></output>  
                    </div>
                    <span class="note">This will be only Works on Position for "Bottom Left" and "Bottom Right"</span>
                    </div>
                </div>

            </div>

        </div>
<hr>

    <div class="color_section">
        <h3 class="medium-heading">Color Schema</h3>                       
            <div class="row form-inline">
                                    
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Background Color</label> 
                        <input type="color" maxlength="50" id="backgroundcolor" name="backgroundcolor" class="form-control" value="#<?php echo $content['data']['shopbgcolor']; ?>" >
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                    <label>Font Color</label> 
                    <input type="color" id="fontcolor" maxlength="50" name="fontcolor" class="form-control" value="#<?php echo $content['data']['shoptextcolor']; ?>" >
                    </div>
                </div>
                                    
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Logo Color</label> 
                        <input type="color" id="iconcolor" maxlength="50" name="iconcolor" class="form-control" value="#<?php echo $content['data']['iconcolor']; ?>" >
                    </div>
                </div>

            </div>

    </div>
<hr>
            <div class="text_section">
                <h3 class="text-section-heading">Text Schema</h3>
                
                <div class="row">                    
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Keyboard Nav</label> 
                        <input type="text" id="keybaord_nav" maxlength="50" name="keybaord_nav" class="form-control valid" placeholder="Keybaord Nav" aria-required="true" aria-invalid="false" value="<?php echo $content['data']['shop_text']['keybaord_nav']?>">
                        </div>
                    </div>
                                    
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Cursor</label> 
                        <input type="text" id="curson" name="curson" maxlength="50" class="form-control valid" placeholder="Cursor" aria-required="true" aria-invalid="false" value="<?php echo $content['data']['shop_text']['curson']; ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Big Cursor</label> 
                        <input type="text" id="big_curson" name="big_curson" maxlength="50" class="form-control valid" placeholder="Big Cursor" aria-required="true" aria-invalid="false" value="<?php echo $content['data']['shop_text']['big_curson']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Reading Guide</label> 
                        <input type="text" id="reading_guide" name="reading_guide" maxlength="50" class="form-control valid" placeholder="Reading Guide" aria-required="true" aria-invalid="false" value="<?php echo $content['data']['shop_text']['reading_guide']; ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Desaturate</label> 
                        <input type="text" id="desaturate" name="desaturate" maxlength="50" class="form-control valid" placeholder="Desaturate" aria-required="true" aria-invalid="false" value="<?php echo $content['data']['shop_text']['desaturate']; ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Contrast</label> 
                        <input type="text" id="contrast" name="contrast" maxlength="50" class="form-control valid" placeholder="Contrast +" aria-required="true" aria-invalid="false" value="<?php echo $content['data']['shop_text']['contrast']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Invert Colors</label> 
                        <input type="text" id="invert_contrast" name="invert_contrast" maxlength="50" class="form-control placeholder" value="Invert Colors" aria-required="true" aria-invalid="false" value="<?php echo $content['data']['shop_text']['invert_contrast']; ?>">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Dark Contrast</label> 
                            <input type="text" id="dark_contrast" name="dark_contrast" maxlength="50" class="form-control" placeholder="Dark Contrast" value="<?php echo $content['data']['shop_text']['dark_contrast']; ?>" >
                            </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Light Contrast</label> 
                            <input type="text" id="light_contrast" name="light_contrast" maxlength="50" class="form-control" placeholder="Light Contrast" value="<?php echo $content['data']['shop_text']['light_contrast']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Bigger Text</label> 
                         <input type="text" id="bigger_text" name="bigger_text" class="form-control" maxlength="50" placeholder="Bigger Text" value="<?php echo $content['data']['shop_text']['bigger_text']; ?>" >
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Highlight Links</label> 
                        <input type="text" id="highlight_links" name="highlight_links" class="form-control" maxlength="50" placeholder="Highlight Links" value="<?php echo $content['data']['shop_text']['highlight_links']; ?>" >
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Reset all</label> 
                        <input type="text" id="reset_all" name="reset_all" class="form-control" placeholder="Reset All" maxlength="50" value="<?php echo $content['data']['shop_text']['reset_all']; ?>">
                         </div>
                    </div>

                </div>


                <fieldset>
                                
                <div class="row">
                <div class="col-sm-4">
                </div>
                <div class="col-xs-12 col-sm-4">
                <div class="clsSubmitButtons">
                <button id="btnAdd" class="btn btn-success" name="btnAdd" type="submit">Save</button>
                <a id="preview_data" class="btn btn-preview" href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Preview</a> 
                
                </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                </div>
                </div>
                                
                                
                </fieldset>

            </div> <!-- text Section  --> 
        </form>
    </div>