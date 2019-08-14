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


const element = document.querySelector('form');
element.addEventListener('submit', event => {
    event.preventDefault();
    console.log('Form submission cancelled.');
});