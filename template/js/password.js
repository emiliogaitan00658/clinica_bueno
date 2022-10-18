//FUNCION MOSTRAR CARCATERES DE PASSWORD
function MostrarPassword(){
    var cambio = document.getElementById("txtPassword");
    if(cambio.type == "password"){
      cambio.type = "text";
      $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }else{
      cambio.type = "password";
      $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }
  } 
  
  $(document).ready(function () {
  //CheckBox mostrar contraseña
  $('#show_password').click(function () {
    $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
  });
});
