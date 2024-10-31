var cms_upload_image_button=false;

jQuery(document).ready(function() {
    
     jQuery('.postbox').each(function(){
        var id = jQuery(this).attr('id');
    
    if(typeof id != 'undefined') {
       
        if(id.indexOf('db_panel') != -1){
            jQuery.post(siteurl.ajax, {
                action: 'get_db_panel_content',
                id: id
            }, function (response){
                jQuery('#'+id).children('.inside').html(response);
            }, 'html');
        }
}
    });
    
    jQuery('#tabs-pands-script').tabs({
        active: jQuery('#current_tab').val()
    });
                                                    
    jQuery('#pands-tab-list li').click(function(){
        var index = jQuery('#tabs-pands-script').tabs('option','active');
        jQuery('#current_tab').val(index);
    });
    
    jQuery('.cms_upload_image_button').click(function() {
        cms_upload_image_button =true;
        var formfieldID=jQuery(this).prev().attr("id");
        var formfield = jQuery("#"+formfieldID).attr('name');
        
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        if(cms_upload_image_button==true){

            var oldFunc = window.send_to_editor;
            window.send_to_editor = function(html) {

                var imgurl = jQuery('img', html).attr('src');
                jQuery("#"+formfieldID).val(imgurl);
                jQuery("#"+formfieldID).siblings('img.img_prev').remove();
                jQuery("#"+formfieldID).parent().append('<img src="'+imgurl+'" class="img_prev" style="max-width: 100%" />');
                tb_remove();
                window.send_to_editor = oldFunc;
            }
        }
        cms_upload_image_button=false;
    });

    jQuery('.img-prev-container a.del-icon').click(function(){
        if(confirm('Are you sure?')){
            var parent = jQuery(this).parent('.img-prev-container');
            parent.siblings('input[type=hidden]').val('');
            parent.remove();
        }
    });
    
    jQuery('.cms_panel_container a.del_panel').click(function(){
        var $this = jQuery(this);
        
        if(confirm('Are you sure?')){
            $this.parent('td.cms_panel_container').remove();
        }
    });

});

function addDBPanel(elem){
    jQuery.post(siteurl.ajax, {
        action: 'add_db_panel'
    }, function (response){
        window.location.reload(false);
    }, 'html');
}

function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}