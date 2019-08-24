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
function aai(comp){
    $('.multiCompetitorHelp').css('display', 'block');
    var aaiVal = $('#aai'+comp).val();
    var jqxhr = $.ajax("/accountAPI/"+aaiVal)
        .done(function () {
           var data = JSON.parse(jqxhr.responseText);
           $('#name'+comp).val(data.name);
           if(data.name == "" || data.name == " "){
               $('#aaiHelp'+comp).css('display', 'block');
               $('#aaiData' + comp).html(aaiVal);
           }
           else{
               $('#aaiHelp' + comp).css('display', 'none');
           }
        });

}