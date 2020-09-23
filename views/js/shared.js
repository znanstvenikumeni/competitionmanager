function continueToContestantDataInNewApplication(){
    $('.applicationData').css('display', 'none');
    $('.contestantData').css('display', 'block');
}
function continueToMentorDataInNewApplication() {
    $('.contestantData').css('display', 'none');
    $('.mentorData').css('display', 'block');
}
function age(comp) {
    if ($('#age' + comp).val() < 16) {
        $('#agehelp' + comp).css('display', 'block')
    }
    else {
        $('#agehelp' + comp).css('display', 'none')
    }
}
function aai(comp) {
    $('.multiCompetitorHelp').css('display', 'block');
    var aaiVal = $('#aai'+comp).val();
    if(aaiVal.indexOf('@skole.hr') != -1){
        fetch("/accountAPI/"+aaiVal)
            .then(response => response.json())
            .then(data => aaihints(comp, data));

    }
    else{
        $('#aaiData' + comp).html('upisani AAI@EduHR email');

    }
    /*
    var aaiVal = $('#aai'+comp).val();
    if($('#name'+comp).val() == "" || $('#name'+comp).val() == " "){
    var jqxhr = $.ajax()
        .done(function () {
            var data = JSON.parse(jqxhr.responseText);
            if (data.name == "" || data.name == " ") {
                $('#aaiHelp' + comp).css('display', 'block');
                if($('#name'+comp).val() == "" || $('#name'+comp).val() == " ") {
                    $('#name' + comp).val(data.name);
                    $('#aaiData' + comp).html(aaiVal);
                }
            } else {
                $('#aaiHelp' + comp).css('display', 'none');
            }
        }
        )}};*
     */
}
function aaihints(comp, _data){
    var aaiVal = $('#aai'+comp).val();
    if($('#name'+comp).val() == "" || $('#name'+comp).val() == " ") {
        $('#name' + comp).val(_data.name);
        if(_data.name == "" || _data.name == " "){
            $('#aaiData' + comp).html(aaiVal);
             $('#aaiHelp' + comp).css('display', 'block');
        }

    }
}

