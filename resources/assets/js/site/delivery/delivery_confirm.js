$(document).ready(function() {
    DeliveryPicker.create( $("#devlivery_date") );
});

var cp_access_token = "b5aa9-76e3a-d47c7-00503", // ***** DON'T FORGET TO PUT YOUR ACCESS TOKEN HERE IN PLACE OF X's !!!! *****
    cp_obj_1 = CraftyPostcodeCreate();

cp_obj_1.set("access_token", cp_access_token);
cp_obj_1.set("debug_mode", "0");
cp_obj_1.set("first_res_line", "----- please select your address ----");
cp_obj_1.set("res_autoselect", "0");
cp_obj_1.set("result_elem_id", "crafty_postcode_result_display");
cp_obj_1.set("form", "orderform");
cp_obj_1.set("elem_company","house_name");
cp_obj_1.set("elem_street1"  , "address_name_1");
cp_obj_1.set("elem_street2"  , "address_name_2");
cp_obj_1.set("elem_town"     , "city");
cp_obj_1.set("elem_county"   , "region"); // optional
cp_obj_1.set("elem_search_house" , "address_number");
cp_obj_1.set("elem_postcode" , "postcode");
cp_obj_1.set("single_res_autoselect" , 1); // don't show a drop down box if only one matching address is found
cp_obj_1.set("on_result_ready",cc_gotData);
cp_obj_1.set("single_res_notice" , "");
cp_obj_1.set("on_result_selected",addressSelected);
cp_obj_1.set("busy_img_url","/images/crafty_clicks_loading.gif");
cp_obj_1.set("on_error",cc_error);

function cc_gotData() {
    $('#house-number').hide();
    $(".find-address").hide();
    var address1 = $("#address_name_1");
    address1.attr("data-full-address",address1.val());

    $('#crafty_postcode_result_display select').select2({
        minimumResultsForSearch: Infinity
    });
}

function addressSelected() {
    $("#house-number").hide();
    $("#crafty_postcode_result_display").hide();
    $("#full-address").removeClass('hide');
    if($("#house_name").val() == '') {
        $("#house-name").hide();
    }
    var address1 = $("#address_name_1");
    address1.attr("data-full-address",address1.val());
}

function cc_error(err) {
    $('#crafty_postcode_result_display').delay('5000').fadeOut();
    $('#full-address').removeClass('hide');
    $('.find-address').hide();
}