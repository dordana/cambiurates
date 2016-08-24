$.validator.addMethod(
    "regex",
    function(value, element, regexp) {
      var re = new RegExp(regexp);
      return this.optional(element) || re.test(value);
    },
    "Please check your input."
);

$.validator.methods.required = function(value, element, param) {
  if ($(element).attr('type') == 'checkbox') {
    return $(element).parent().hasClass('checkbox_checked');
  }
  return value != '';
}

var validator = $(".collection_orders_details").bind("invalid-form.validate", function() {
}).validate({
  rules: {
    title: {
      required: true
    },
    first_name: {
      required: true
    },
    last_name:{
      required: true
    },
    phone:{
      required: true
    },
    email:{
      required: true
    },
    postcode: {
      required: true
    },
    city: {
      required: true
    },
    country: {
      required: true
    },
    address_name: {
      required: true
    },
    tandc: {
      required: true
    }
  },
  onkeyup: false,
  onfocusout: false,
  ignore: '',
  highlight: function(element, errorClass, validClass) {
    if($(element).is(':checkbox')){
      if($(element).is(':checked')){
        $(element).parent().removeClass(errorClass).addClass(validClass);
      }else{
        $(element).parent().removeClass(validClass).addClass(errorClass);
      }
    }else{
      $(element).removeClass(validClass).addClass(errorClass);
    }
  },
  unhighlight: function(element, errorClass, validClass) {
    if($(element).is(':checkbox')){
      if($(element).is(':checked')){
        $(element).parent().removeClass(errorClass).addClass(validClass);
      }else{
        $(element).parent().removeClass(validClass).addClass(errorClass);
      }
    }else{
      $(element).removeClass(errorClass).addClass(validClass);
    }
  }
});