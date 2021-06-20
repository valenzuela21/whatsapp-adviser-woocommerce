(function ($) {
    
    let select_input_data = [];
    
    
    reset();

    $('#clean-attribute').click(function () {
        reset();
        select_input_data = []
    })


    let id_product = $('#id_product').val();
    let respuesta_end = [];
    let respuesta_final = [];
    let select_data = [];


    $(".select-adviser").change(function (i) {
         $(this).prop( "disabled", true );
         
         $('.attribute-select').show();
         $('.select-attr-adv').hide();
         
        let value = $(this).val();
        let id_select = $(this).attr('id');
        
        
        if (!value) {
            $('.attribute-woocommerce').hide('fast');
            $('.price').html('');
            reset();
        } else {
            let elements = $(".select-adviser");
            let array_attributes = [];
            elements.each(function () {
                let attributes = $(this).attr('id');
                array_attributes.push(attributes)
            });

            let datos = {
                action: 'adviser_result_whatsapp_select',
                respuesta: [id_product, value]
            }
            //Consult AJAX URL
            $.ajax({
                url: object_data.ajax_url,
                type: 'post',
                data: datos,
                beforeSend: function () {
                    $('.attribute-woocommerce').hide();
                    $('#clean-attributes').hide();
                    $(".loader-adviser").show();
                },
                success: function (respuesta) {
                    select_option_attributes(respuesta, id_select, value);
                },
                complete: function () {
                    $(".loader-adviser").hide();
                    $('.attribute-woocommerce').show();
                    $('#clean-attributes').show();
                }
            })
        }
        

    });


    $('.attribute-select').change(function () {
        
  
        $('#clean-attributes').show();

        let value = $(this).val();
        let id_select = $(this).attr('id');
        let result = [];
        let result_name = [];
        let array_value = [];
        let array_name_select = [];
        
        get_input_data(id_select, value);

        select_data.map(item => {
            let attributeName = item[1];
            let attributeString = item[0].toString();
            if (attributeString.includes(value)) {
                result.push(attributeString);
                result_name.push(attributeName);
            }
        });

        $(".attribute-select option").remove();

      
        result.forEach((value, index) => {
            if (!array_value.includes(value)) {
                array_value.push(value)
                array_name_select.push(result_name[index]);
            }
        })
        
        
        let Obj = {};
    
        array_value.forEach((item, index) => {
            let value = item.split(',');
            Obj['select' + index] = value.slice(1);
        })

        let values_array = [];
        
        let i= 0;
        
        for (const property in Obj) {
            //console.log(`${property}: ${Obj[property][0]} - ${Obj[property][1]}`);
 
            let name = array_name_select[i].slice(1);
            $('.attribute-select').each(function (index) {
                let value = Obj[property][index];
              
                if (!values_array.includes(Obj[property][index])) {
                    $('#' + this.id).append('<option value="' + Obj[property][index] + '">' + name[index] + '</option>');
                    
                    values_array.push(Obj[property][index]);
                }
            });
            i++;
        }


        let final = result[0].split(',');
      
        //Capture Input Select
        var arrVal= new Array();
        $('.inputs_options_adv').each(function(){
                 arrVal.push($(this).val());
            })
                
        
        //End Answer Final
        respuesta_end.map((item, index) => {
            item[index].forEach(item => {
                let obj_value = Object.values(item[1]);
                let string_attributes = obj_value.toString();
                
                if(string_attributes === arrVal.toString()){
                       get_price(item);
                }else{
                    if (string_attributes === final.toString()) {
                        //console.log(item);
                        get_price(item);
                    } 
                }                
                
            })
        })
        
        
        function get_price(item){
             respuesta_final = [];
             respuesta_final.push(item);
             $('.price').html(item[3])
             $('#id_variable').val(item[0])
             $('#button_payment_answer').show('fast');
        }
        
        
       let elements = $(".attribute-select");
            elements.each(function () {
                let attributes = $(this).attr('id');
                let text = $(this).text();
           
                let count = $('#'+attributes+' > option').length;
                if(count <= 1){
                    $(`#${attributes}_adv`).show();
                    $(`#${attributes}_adv`).html(text);
                    $(`#${attributes}`).hide();
                }
             
            });
        
    })

    $('#answer-whatsapp').click(function () {
        $('#whatsapp-adv-form').hide('fast')
        $('#adv-whatsapp-adviser').html(`
                <div class="whatsapp-voral">
                    <div class="select-adviser">
                        <h4 class="title-adviser">${object_data.subtitle}</h4>
                        <p class="txt-parrafo">${respuesta_final[0][2]}</p>
                        <div class="result-whatsapp"></div>
                     </div>
                </div>`);


        let object = respuesta_final[0][4][0];
        let obj = {};
        for(const property in object){
            obj[property] = object[property];
        }

        let name_whatsapp = obj.name_whatsapp;
        let position_whatsapp = obj.position_whatsapp;
        let phone_whatsapp = obj.phone_whatsapp;
      

    let result_list;
    phone_whatsapp.forEach((item, i) => {
        if(phone_whatsapp[i].length > 0){
        result_list = `<div class="row-voral">
                        <div class="column-voral-1">
                            <h4 class="title">${name_whatsapp[i]}</h4>
                            <p class="sub-title">${position_whatsapp[i]}</p>
                        </div>
                        <div class="column-voral-2">
                            <i class="phone-call click-call-adviser"
                               phone="${item}"
                               option="${respuesta_final[0][2]}"
                               title="${respuesta_final[0][6]}"
                               link="${respuesta_final[0][5]}"></i>
                        </div>
                    </div>`;

            $('.result-whatsapp').append(result_list)
        }else{
             $('.result-whatsapp').html(`<div class='adviser-not-found'>${object_data.no_found}</div>`);
             return;
        }
    })
    });


    $(document).on('click','.click-call-adviser', function(){
        let phone_adv =$(this).attr('phone');
        let title_adv =$(this).attr('title');
        let link_adv =$(this).attr('link');
        let option_link =$(this).attr('option');

        let url = `https://api.whatsapp.com/send?phone=${phone_adv}&text=Hola,%20interesado%20en%20este%20producto:%20${title_adv}%20${option_link}%20${link_adv}`;
        window.location = url;
    });


    function select_option_attributes(respuesta, id_select, value_select) {
        respuesta_end = [];
        respuesta_end.push(respuesta);
        $('.attribute-woocommerce').slideDown('fast')
        $(".attribute-select option").remove();
        $('.attribute-select').append('<option value=""> Seleccione </option>')

        let values = [];
        select_data = [];
        respuesta[0].forEach(item => {
          
            let name = get_atributtes_name(item);

            //Result select auto
            let obj_key = Object.keys(item[1]);
            let obj_value = Object.values(item[1]);
            let object_name_value = Object.values(name);

            obj_key.map((item, index) => {
                if (obj_value[index]) {
                    if (!values.includes(obj_value[index])) {
                        $('#attribute-' + item).append('<option value="' + obj_value[index] + '">' + object_name_value[index] + '</option>')
                        values.push(obj_value[index]);
                    }
                      select_data.push([obj_value, object_name_value]);
                }
            })
        })

        if(values.length === 1){
            $('#button_payment_answer').show();
        }
        
       get_input_data(id_select, value_select);
    }
    
    function get_atributtes_name(item){
          let name_attribute = item[2].split(', ');
            let obj = {};
            for (let entry of name_attribute) {
                let pair = entry.split(":");
                    obj[pair[0]] = pair[1];
                }
          
          return obj;
    }
    
    
    function get_input_data(id_select, value_select){
     
            if(!select_input_data.includes(id_select)){
                        $('#input-file-adv').append(`<input name="${id_select}" type="text" class="inputs_options_adv" value="${value_select}">`);
            }
          
             select_input_data.push(id_select);
    }


    function reset() {
        $('.select-adviser').prop( "disabled", false );
        $('.select-adviser').val('');
        $('.attribute-woocommerce').hide();
        $('#clean-attributes').hide();
        $('#button_payment_answer').hide();
        $('#id_variable').val('')
        $('.attribute-select').show();
        $('.select-attr-adv').hide();
        clean_select_data(select_input_data);
    }
    
    function clean_select_data(select_input_data){
          $('.inputs_options_adv').remove();
    }


})(jQuery)