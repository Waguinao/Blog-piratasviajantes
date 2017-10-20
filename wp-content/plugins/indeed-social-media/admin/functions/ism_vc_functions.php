<?php
function ism_checkbox_icons_settings_field($settings, $value){
	$str = '';
	$str .= '<div class="ism_wrap ism_template_admin">
	<div style="display:inline-block;vertical-align: top;margin-top: 20px;">';
	$i = 1;
	foreach ($settings['ism_items'] as $k=>$v){
		if ($i%15==0){
			$str .= '</div>
			<div class="ism_social_list_column" style="">';
		}
		$i++;
		$checked = (strpos($value, $k)!==FALSE) ? 'checked="checked"' : '';
		$extra_class = (strpos($value, $k)!==FALSE) ? 'ism_item_selected' : '';
		$icon = $k;
		if ($v['long_key']=='google_plus'){
	    	$v['long_key'] = 'google';
	    }
		$str .= '<div class="ism_social_list_box">
		<div class="ism_item_wrapper">
		<div class="ism_item ism_box_' . $v['long_key'] .' ' . $extra_class . '">
		<div class="ism_social_list_check">
		<input type="checkbox" value="' . $v . '" id="" onClick="make_inputh_string(this, \'' . $k . '\', \'#sm_items\');ism_select_sm_icon(this);" class="" ' . $checked . '/>
                                <label for="ism_social_list_check"></label>
							</div>';
		if (!empty($v['font']) && $v['font']=='socicon'){
			$str .= '<i class="ism-sc-icon ism-socicon-' . $v['long_key'] . '"></i>';
		} else {
			$str .= '<i class="fa-ism fa-' . $v['long_key'] . '-ism"></i>';
		}
		$str .= '<span class="ism_share_label">' . $v['label'] . '</span>
				<div class="clear"></div>
				</div>
				</div>
				<div class="ism_clear"></div>
        </div>';
    }//end foreach
    $str .= '</div>';
    $str .= '<input type="hidden" value="'.$value.'" name="'.$settings['param_name'].'" id="sm_items" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" />';
    $str .= '</div>';
	return $str;
}
add_shortcode_param('ism_checkbox_icons', 'ism_checkbox_icons_settings_field');

function ism_dropdown_picture_settings_field( $settings, $value ){
    $str = '';
    $str .= '<select id="'.$settings['ism_select_id'].'" name="'.$settings['param_name'].'" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" onChange="'.$settings['onchange'].'" >';
    foreach($settings['ism_items'] as $k=>$v){
        $selected = '';
        if($value==$k) $selected = 'selected="selected"';
        $str .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
    }
    $str .= "</select>";
    $str .= "<div id='ism_preview' style='display: inline-block;padding: 5px 0px;'></div>";
    $str .= '<div class="ism-info">'.$settings['aditional_info'].'</div>';
    $str .= '<script>'.$settings['onload_script'].'</script>';
    return $str;
}
add_shortcode_param('ism_dropdown_picture', 'ism_dropdown_picture_settings_field');

function ism_return_radio_settings_field( $settings, $value ){
    $str = '';
    $str .= '<div style="margin-bottom:10px; font-weight:bold;">' . $settings['ism_label'] . '</div>';
    foreach($settings['ism_items'] as $k=>$v){
        $selected = '';
        if( $value==$k ) $selected = 'checked="checked"';
        $str .= '<div style="margin:5px;"><input type="radio" value="'.$k.'" '.$selected.' onClick="jQuery(\'#'.$settings['id_hidden'].'\').val(this.value);" name="'.$settings['param_name'].'" style="width: initial;">  '.$v.'</div>';
	}
    $str .= '<input type="hidden" value="'.$value.'" name="'.$settings['param_name'].'" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" id="'.$settings['id_hidden'].'" />';
    $str .= '<div class="ism-info">'.$settings['aditional_info'].'</div>';

    return $str;
}
add_shortcode_param('ism_return_radio', 'ism_return_radio_settings_field');

function ism_return_checkbox_settings_field( $settings, $value ){
    $str = '';
    $checked = '';
    if(isset($settings['title_before_field']) && $settings['title_before_field']!='') $str .= $settings['title_before_field'];
    if($value=='true' || $value==1) $checked = 'checked="checked"';
    $str .= '<span style="font-weight:bold; padding-right:10px;">' .$settings['ism_label']. '</span>';
    $str .= '<input type="checkbox" name="'.$settings['param_name'].'" onClick="'.$settings['onClick_function'].'(this, \'#'.$settings['id_hidden'].'\');" '.$checked.' id="'.$settings['checkbox_id'].'"/>';
    $str .= '<input type="hidden" value="'.$value.'" name="'.$settings['param_name'].'" id="'.$settings['id_hidden'].'" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" />';
    $str .= '<div class="ism-info">'.$settings['aditional_info'].'</div>';

    return $str;
}
add_shortcode_param('ism_return_checkbox', 'ism_return_checkbox_settings_field');

function ism_return_number_settings_field( $settings, $value ){
    $str = '';
    $str .= '<span style="font-weight:bold; padding-right:10px;">' .$settings['ism_label']. '</span>';
    $str .= '<input type="number"  value="'.$value.'" name="'.$settings['param_name'].'" min="0" id="'.$settings['ism_input_id'].'" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" /> '.$settings['count_type'];
    $str .= '<div class="ism-info">'.$settings['aditional_info'].'</div>';
    return $str;
}
add_shortcode_param('ism_return_number', 'ism_return_number_settings_field');


function ism_return_dropdown_settings_field( $settings, $value ){
	$str = '';
	if (isset($settings['ism_label'])) $str .= "<b>".$settings['ism_label']."</b>";
	$str .= '<select id="'.$settings['ism_select_id'].'" name="'.$settings['param_name'].'" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" onChange="'.$settings['onchange'].'" >';
	foreach ($settings['ism_items'] as $k=>$v){
		$selected = '';
		if($value==$k) $selected = 'selected="selected"';
		$str .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
	}
	$str .= "</select>";
	return $str;
}
add_shortcode_param('ism_return_dropdown', 'ism_return_dropdown_settings_field');

function ism_on_off_settings_field( $settings, $value ){
	$str = '';
	$checked = ($value==1) ? 'checked' : '';
	$str .= '<span style="font-weight:bold; padding-right:10px;">' . $settings['ism_label'] . '</span>';
	$str .= '<label><input type="checkbox" ' . $checked . ' class="ism-switch" onClick="check_and_h(this, \'#'.$settings['id_hidden'].'\');" /><div class="switch" style="display:inline-block;"></div></label>';
	$str .= '<input type="hidden" id="' . $settings['id_hidden'] . '" value="' . $value . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" />';
	return $str;
}
add_shortcode_param('ism_on_off', 'ism_on_off_settings_field');

function ism_show_hide_settings_field( $settings, $value ){
	$str = '';
	$checked = ($value=='show') ? 'checked' : '';
	$str .= '<span style="font-weight:bold; padding-right:10px;">' . $settings['ism_label'] . '</span>';
	$str .= '<label><input type="checkbox" ' . $checked . ' class="ism-switch2" onClick="check_and_h_sh(this, \'#'.$settings['id_hidden'].'\');" /><div class="switch" style="display:inline-block;"></div></label>';
	$str .= '<input type="hidden" id="' . $settings['id_hidden'] . '" value="' . $value . '" name="' . $settings['param_name'] . '" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" />';
	$str .= '<div style="border-bottom: 1px solid #c3c3c3; margin-top: 5px;"></div>';
	return $str;
}
add_shortcode_param('ism_show_hide', 'ism_show_hide_settings_field');

function ism_roles_select_settings_field( $settings, $value ){
	$str = '';
	global $wp_roles;
	foreach ($wp_roles->roles as $k=>$v){
		$roles[$k] = $v['name'];
	}
	unset($roles['administrator']);
	$values = array();
	if ($value){
		$values = explode(",", $value);
	}
	$str .= '<span style="font-weight:bold; padding-right:10px;">' . $settings['ism_label'] . '</span>';
	$str .= '<select multiple onChange="ism_vc_write_data_from_multiselect(this, \'#ism_role_h\');">'; 
	foreach ($roles as $k=>$v){
		$selected = (in_array($k, $values)) ? "selected" : "";
		$str .= '<option value="' . $k . '" ' . $selected . '>' . $v . '</option>';
	}
    $str .= '</select>';
    $str .= '<input type="hidden" name="' . $settings['param_name'] . '" value="' . $value . '" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" id="ism_role_h"/>';
	return $str;
}
add_shortcode_param('ism_roles_select', 'ism_roles_select_settings_field');

function ism_select_referers_settings_field( $settings, $value ){
	
	$selected_arr = array();
	if ($value){
		$selected_arr = explode(",", $value);
	}
	$values = array("google"=>"Google", "yahoo"=>"Yahoo", "bing"=>"Bing");
	$str = '';
	foreach ($values as $k=>$v){
		$checked = '';
		if (in_array($k, $selected_arr)){
			$key = array_search($k, $selected_arr);
			unset($selected_arr[$key]);
			$checked = 'checked';
		}
		$str .= '<div>';
		$str .= '<input type="checkbox" ' . $checked . ' id="referer_' . $k . '" onClick="ism_vc_write_ref();"/><label>' . $v . '</label>';		
		$str .= '</div>';
	}
	$str .= '<div><textarea id="ism_vc_custom_refs" onKeyup="ism_vc_write_ref();">' . implode(',', $selected_arr) . '</textarea></div>';
	$str .= '<input type="hidden" name="' . $settings['param_name'] . '" id="referer_values" value="' . $value . '" class="wpb_vc_param_value  '.$settings['param_name'].' '.$settings['type'].'_field" />';
	return $str;
}
add_shortcode_param('ism_select_referers', 'ism_select_referers_settings_field');

