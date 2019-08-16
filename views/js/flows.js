function validateAAI(){
    var aai = $('#aai').val();
    var domain = aai.slice(-9);
    console.log(aai, domain);
    if(domain != '@skole.hr'){
        $('#aai').addClass('is-invalid');
        $('.aaiHelp').css('display', 'block');

    }
    else{
        $('.stepTwo').css('display', 'block');
        $('.stepOne').css('display', 'none');
    }
}
function continueToPersonal(){
    if(!($('#email').val() && $('#phone').val())){
        $('#email').addClass('is-invalid');
        $('#phone').addClass('is-invalid');
        $('.phoneHelp').css('display', 'block');
    }
    else{
        $('.stepThree').css('display', 'block');
        $('.stepTwo').css('display', 'none');
    }
}
function continueSave() {
    if (!($('#firstName').val() && $('#lastName').val() && $('#password').val())) {
        $('#firstName').addClass('is-invalid');
        $('#lastName').addClass('is-invalid');
        $('#password').addClass('is-invalid');
        $('.dataHelp').css('display', 'block');
    } else {
        $('#signup').submit();
    }
}

const element = document.querySelector('form');
element.addEventListener('submit', event => {
    event.preventDefault();
    console.log('Form submission cancelled.');
});