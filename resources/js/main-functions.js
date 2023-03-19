/* load saved cookies equals user is currently driving */
function loadView(){
    var locStart = localStorage.getItem('locStart');
    var kmStart = localStorage.getItem('kmStart');
    var stopVar = localStorage.getItem('stopVar');
    var end = localStorage.getItem('end');
    if(end && locStart && kmStart) {
        // display new window
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
        $("#form").hide();
        $("#timer").show();
        $("#stretch").show();
        $("#pause").show();
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
    /*
    if(!confirm("Fahrt beenden?")){
        return;
    }
    */

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

    // get timestamp
    var ts = parseInt(new Date().getTime() / 1000);

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
    if(locStop === locPause){
        ar_tsStop.pop(); // removes last element since it is the same as the current one
    }
    if(kmStop == ""){
        alert('Bitte aktuellen Kilometerstand eingeben');
        return false;
    }
    if(kmStop <= kmStart){
        alert('Aktueller Kilometerstand kleiner als Anfangswert');
        return false;
    }

    // add new timestamp for stop
    if(!ar_tsStop) {
        var ar_tsStop = [];
    }
    ar_tsStop.push(ts); /* adds current ts to array */
    



    // the following vars are only meant to be displayed to the user
    
    // calc driven km
    var kmDiff = kmStop - kmStart;

    // calc total time
    var sumTS = 0;
    ar_tsStop.forEach(function callback(value, index) {
      sumTS += ar_tsStop[index] - ar_tsStart[index];
    });
    totalHours = sumTS / 3600 % 60;
    totalMinutes = sumTS / 60 % 60;
    totalSeconds = sumTS % 60;

    // starting time
    hr = ar_tsStart[0] / 3600 % 60;
    min = ar_tsStart[0] / 60 % 60;
    strStart = `${hr}:${min}`;

    // end time
    hr = ts / 3600 % 60;
    min = ts / 60 % 60;
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
            <ul>
                <li>${locStr}</li>
                <li>Start: ${strStart}</li>
                <li>Ende: ${strStop}</li>
                <li>Total: ${totalHours} h ${totalMinutes} min</li>
                <li>KM: ${kmDiff}</li>
            </ul>
        </div>
    `;

    $("#btn-save").hide();
    $("#btn-back").show();
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