(function($) {
 
    $('.button_action').on('click', function(){
        $('.whatsapp-sopport-adviser .box-cloud-whatsapp').fadeOut("slow");
        let id_product = $(this).attr('id-product');
        let id_variation = $(this).attr('id-variation');
        
        let datos = {
                action: 'adviser_result_whatsapp',
                respuesta: [id_product, id_variation]
        }
        
        
        $.ajax({
            url: admin_url.ajax_url,
            type: 'post',
            data: datos,
            beforeSend: function() {
              $(".loader-adviser").show();
            },
            success: function(respuesta) {
                console.log(respuesta)
            let attributs = Object.values(respuesta[1]).toString();
            let product_attribute = attributs.replace(/-/g, " ");
            let image = (respuesta[3])? respuesta[3] : 'https://placeholder.com/150' ;
            let description = respuesta[4];
            
            $('#header_html').html(`<div class="header">
            <div style="display: flex">
                <div class="img-product">
                    <img src="${image}" alt="${respuesta[0]}" />
                </div>
                <div class="desc-product">
                <h3>${respuesta[0]}</h3>
                <p>${product_attribute} ${description}</p>
                <p id="price-molda-html" style="text-align:right"></p>
                </div>
            </div>
        </div>`);
        
            $('#price-molda-html').html(respuesta[2]);
            $('.phone-call').attr('attributs', attributs + description);
            $(".support-product-chat").fadeIn("slow");
            
             $(".loader-adviser").hide();
           }
        })      
        
    });
    
    
    $('.close-modal-support').on('click', function(){
        $(".support-product-chat").fadeOut("slow");
        $(".box-cloud-whatsapp").hide();
    })



    $('.phone-call').on('click', function(){
        let options;
        let phone =$(this).attr('phone');
        let title =$(this).attr('title');
        let link =$(this).attr('link');
        
        let array_value = [];
        $('#form-adviser .adviser-input').each(function (){
            let select_value = $(this).val();
            array_value.push(select_value);
        })
        
        if($(this).attr('attributs')){
            options = $(this).attr('attributs');
        }else{
            options = array_value.toString()
        }
    
        let url = `https://api.whatsapp.com/send?phone=${phone}&text=Hola,%20interesado%20en%20este%20producto:%20${title}%20${options}%20${link}`;
        window.location = url;
    })




})(jQuery);