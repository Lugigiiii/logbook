/* load saved cookies equals user is currently driving */
function loadView(){
    var locStart = localStorage.getItem('locStart');
    var kmStart = localStorage.getItem('kmStart');
    var stopVar = localStorage.getItem('stopVar');
    var end = localStorage.getItem('end');
    if(end && locStart && kmStart) {
        // ending view where user adds last information
        document.forms["meta"]["loc"].placeholder = "Aktueller Standort...";
        document.forms["meta"]["km"].placeholder = "Aktueller KM Stand...";
        $("#timer").hide();
        $("#pause-view").hide();
        $("#btn-back").hide();
        $("#left").hide();
        $("#right").hide();
        $("#btn-pause").hide();
        $("#stretch").show();
        $("#btn-save").show();
        $("#form").show();
        return;
    }
    if(stopVar && locStart && kmStart){
        /* hide some stuff */
        $("#stretch").hide();
        $("#btn-start").hide();
        $("#btn-manual").hide();
        $("#form").hide();
        $("#timer").hide();
        $("#right").show();
        $("#left").show();
        $("#btn-resume").show();
        $("#btn-stop").show();
        $("#pause-view").show();
        return;
    }
    if(locStart && kmStart) {
        /* hide and show some stuff */
        $("#left").hide();
        $("#pause-view").hide();
        $("#right").hide();
        $("#btn-save").hide();
        $("#btn-back").hide();
        $("#form").hide();
        $("#timer").show();
        $("#stretch").show();
        $("#pause").show();

        // add new title
        document.getElementById("title-top").textContent= 'Unterwegs';
        return;
    }
    /*show default view */
    $("#left").show();
    $("#right").show();
    $("#stretch").hide();
    $("#btn-pause").hide();
    $("#btn-resume").hide();
    $("#btn-stop").hide();
    $("#btn-save").hide();
    $("#btn-back").hide();
    $("#timer").hide();
    $("#pause-view").hide();
    $("#btn-start").show();
    $("#btn-manual").show();
    $("#form").show();

    // add default title
    document.getElementById("title-top").textContent= 'Start';
    return;
}


/* run this function when start button is pressed. used to check input and then start everything */
function startFunc(){
    var locStart = document.forms["meta"]["loc"].value;
    var kmStart = document.forms["meta"]["km"].value;
    if (locStart == "") {
        alert("Bitte Startort eingeben");
        return false;
    }
    if(kmStart == ""){
        alert('Bitte KM vor der Fahrt eingeben');
        return false;
    }

    var ts = parseInt(new Date().getTime() / 1000);
    var ar_tsStart = [];
    var ar_locStart = [];
    ar_tsStart[0] = ts;
    ar_locStart[0] = locStart;
    var fKmStart = kmStart.replace(/\D/g, "");
    localStorage.setItem("timestamp_start", JSON.stringify(ar_tsStart));
    localStorage.setItem("locStart", JSON.stringify(ar_locStart));
    localStorage.setItem('kmStart', fKmStart);
    location.reload();
    return true;
}




/* pauseFunc() is used to pause current drive */
function pauseFunc() {
    /* stop timer */
    localStorage.setItem("stopVar", 1);

    // add new title
    document.getElementById("title-top").textContent= 'Pausiert';

    /* set current ts as cookie */
    var ts = parseInt(new Date().getTime() / 1000); /* gets current ts */
    if(localStorage.getItem("timestamp_stop")) {
        var ar_tsStop = JSON.parse(localStorage.getItem("timestamp_stop")); /* parses array of ts stop */
    }else {
        var ar_tsStop = [];
    }
    ar_tsStop.push(ts); /* adds current ts to array */
    localStorage.setItem("timestamp_stop", JSON.stringify(ar_tsStop)); /* stores array to browser */

    loadView();
}





/* run this function when start button is pressed. used to check input and then start everything */
function resumeFunc(){
    localStorage.removeItem("stopVar");

    // store location
    var locPause = document.forms["meta-pause"]["loc-pause"].value;
    if(locPause){
        var ar_locStart = JSON.parse(localStorage.getItem("locStart")); /* parses array of ts start */
        ar_locStart.push(locPause);

        localStorage.setItem("locStart", JSON.stringify(ar_locStart));
    }

    var ts = parseInt(new Date().getTime() / 1000);

    var ar_tsStart = JSON.parse(localStorage.getItem("timestamp_start")); /* parses array of ts start */
    ar_tsStart.push(ts);

    localStorage.setItem("timestamp_start", JSON.stringify(ar_tsStart));
    location.reload();
    loadView();
}


// function to stop recording
function stopFunc() {
    // store loc-pause if set
    var locPause = document.forms["meta-pause"]["loc-pause"].value;
    if(locPause){
        var ar_locStart = JSON.parse(localStorage.getItem("locStart")); /* parses array of ts start */
        ar_locStart.push(locPause);

        localStorage.setItem("locStart", JSON.stringify(ar_locStart));
    }

    localStorage.setItem("end", 1);
    loadView();
}

// function to stop recording
function saveFunc() {

    // get browser data
    var kmStart = localStorage.getItem('kmStart');
    var ar_tsStop = JSON.parse(localStorage.getItem("timestamp_stop"));
    var ar_tsStart = JSON.parse(localStorage.getItem("timestamp_start"));
    var ar_locStart = JSON.parse(localStorage.getItem("locStart"));

    // get form data
    var locStop = document.forms["meta"]["loc"].value;
    var locPause = document.forms["meta-pause"]["loc-pause"].value;
    var kmStop = document.forms["meta"]["km"].value;
    kmStop = kmStop.replace(/\D/g, ""); // remove string stuff

    // check if user fucked up
    if(locStop == "") {
        alert("Bitte Zielort eingeben");
        return false;
    }
    // check if stopover equals current stop
    if(locStop == locPause){
        ar_locStart.pop(); // removes last element since it is the same as the current one
    }
    if(kmStop == ""){
        alert('Bitte aktuellen Kilometerstand eingeben');
        return false;
    }
    if(kmStop <= kmStart){
        alert('Aktueller Kilometerstand kleiner als Anfangswert');
        return false;
    }

    // add new location for array
    ar_locStart.push(locStop); /* adds current ts to array */
    



    // the following vars are only meant to be displayed to the user
    
    // calc driven km
    var kmDiff = kmStop - kmStart;

    // calc total time
    var sumTS = 0;
    ar_tsStop.forEach(function callback(value, index) {
      sumTS += ar_tsStop[index] - ar_tsStart[index];
    });
    totalHours = parseInt(sumTS / 3600 % 60);
    totalMinutes = parseInt(sumTS / 60 % 60);
    totalSeconds = parseInt(sumTS % 60);

    // starting time
    hr = parseInt(ar_tsStart[0] / 3600 % 60 + 1); // get hours and parse as int to remove fractions. increase by 1 to get utc+1
    min = parseInt(ar_tsStart[0] / 60 % 60);
    strStart = `${hr}:${min}`;

    // end time
    hr = parseInt(ar_tsStop.at(-1) / 3600 % 60 + 1);
    min = parseInt(ar_tsStop.at(-1) / 60 % 60);
    strStop = `${hr}:${min}`;

    // loc string
    var locStr = '';
    ar_locStart.forEach(function callback(value, index) {
        locStr += `${value}`;
        if(index !== ar_locStart.length-1) {
            locStr += ' - ';
        }
    });

    // generate dashboard -> add button that restart everything
    document.getElementById("center").innerHTML = `
        <div id="stats">
            <ul id="stats-ul" class="fa-ul">
                <li><span class="fa-li"><i class="fa-solid fa-route"></i></span>${locStr}</li>
                <li><span class="fa-li"><i class="fa-solid fa-play"></i></span>${strStart}</li>
                <li><span class="fa-li"><i class="fa-solid fa-flag-checkered"></i></span>${strStop}</li>
                <li><span class="fa-li"><i class="fa-solid fa-clock"></i></span>${totalHours} Stunden ${totalMinutes} Minuten</li>
                <li><span class="fa-li"><i class="fa-solid fa-car"></i></span>${kmDiff} km</li>
            </ul>
        </div>
    `;

    $("#btn-save").hide();
    $("#btn-back").show();
    // add new title
    document.getElementById("title-top").textContent= 'Letzte Fahrt';
    // end dashboard stuff



    // call php to upload -> here

    // restart everything
    localStorage.setItem("savedComplete", 1);
    return; 
}


// function to return to home screen
function loadDefault(){
    localStorage.clear();
    location.reload();
    return;
}


// functions to check browser
function mobile(){
    window.mobileCheck = function() {
        let check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
      };
    if(window.mobileCheck()){
        alert("Bitte verwende hierzu dein Smartphone");
        return;
    }
}