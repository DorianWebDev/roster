//Javascript & jQuery

$(document).ready(function() {

    $('.count').on('click', function(){

        var usersMon=0;
        var usersTue=0;
        var usersWed=0;
        var usersThu=0;
        var usersFri=0;
        var usersSat=0;
        var usersSun=0;

        $('tr.calcContainer').each(function(){
            var monF = $(this).find('.monF').val();
            var monS = $(this).find('.monS').val();
            var mon = monF - monS;
            if(isNaN(mon)){mon = 0;}
            if(mon > 0){ usersMon++; }

            var tueF = $(this).find('.tueF').val();
            var tueS = $(this).find('.tueS').val();
            var tue = tueF - tueS;
            if(isNaN(tue)){tue = 0;}
            if(tue > 0){ usersTue++; }

            var wedF = $(this).find('.wedF').val();
            var wedS = $(this).find('.wedS').val();
            var wed = wedF - wedS;
            if(isNaN(wed)){wed = 0;}
            if(wed > 0){ usersWed++; }

            var thuF = $(this).find('.thuF').val();
            var thuS = $(this).find('.thuS').val();
            var thu = thuF - thuS;
            if(isNaN(thu)){thu = 0;}
            if(thu > 0){ usersThu++; }

            var friF = $(this).find('.friF').val();
            var friS = $(this).find('.friS').val();
            var fri = friF - friS;
            if(isNaN(fri)){fri = 0;}
            if(fri > 0){ usersFri++; }

            var satF = $(this).find('.satF').val();
            var satS = $(this).find('.satS').val();
            var sat = satF - satS;
            if(isNaN(sat)){sat = 0;}
            if(sat > 0){ usersSat++; }

            var sunF = $(this).find('.sunF').val();
            var sunS = $(this).find('.sunS').val();
            var sun = sunF - sunS;
            if(isNaN(sun)){sun = 0;}
            if(sun > 0){ usersSun++; }

            var total = mon + tue + wed + thu + fri + sat + sun;

            $(this).find('.hours').val(total);
        });

        $('#usersMon').val(usersMon);
        $('#usersTue').val(usersTue);
        $('#usersWed').val(usersWed);
        $('#usersThu').val(usersThu);
        $('#usersFri').val(usersFri);
        $('#usersSat').val(usersSat);
        $('#usersSun').val(usersSun);
    });

    //Show save button after hours counting
    $('#countHours').on('click', function(){
        $('#saveRoster').prop('disabled', false);
    });

    //Hide save button on reset
    $('#resetHours').on('click', function(){
        $('#saveRoster').prop('disabled', true);
    });

    //Hide save button on hours change
    $('table select').on('change', function(){
        $('#saveRoster').prop('disabled', true);
    });

    //Expand shrinked sections
    $('h2').on('click', function(){
        $(this).parent('section').toggleClass('shrinked');
    });

});
