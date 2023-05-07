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
        $("#car-selector").hide();
        $("#timer").hide();
        $("#pause-view").hide();
        $("#btn-back").hide();
        $("#left").hide();
        $("#right").hide();
        $("#btn-pause").hide();
        $("#stretch").show();
        $("#btn-save").show();
        $("#form").show();

        // show title
        document.getElementById("title-top").textContent= 'Fahrt beendet';

        // get location and write to input and localStorage. Get from Storage if already set
        if(!localStorage.getItem("apiRequest")){     
            window.onpaint = getLocation();
        } else {
            document.getElementById("input-loc").value = localStorage.getItem("apiRequest");
        }

        return;
    }
    if(stopVar && locStart && kmStart){
        // pause interface
        /* hide some stuff */
        $("#car-selector").hide();
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
        // counting interface
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
        $("#car-selector").show();

        // add new title
        document.getElementById("title-top").textContent= 'Unterwegs';
        return;
    }
    // starting screen
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
    var car = document.forms["meta"]["car"].value;
    var locStart = document.forms["meta"]["loc"].value;
    var kmStart = document.forms["meta"]["km"].value;
    if (car == "") {
        alert("Bitte Fahrzeug wählen");
        return false;
    }
    if (locStart == "") {
        alert("Bitte Startort eingeben");
        return false;
    }
    if(kmStart == ""){
        alert('Bitte KM vor der Fahrt eingeben');
        return false;
    }

    var ts = parseInt(new Date().getTime());
    var ar_tsStart = [];
    var ar_locStart = [];
    ar_tsStart[0] = ts;
    ar_locStart[0] = locStart;
    var fKmStart = kmStart.replace(/\D/g, "");
    localStorage.setItem("timestamp_start", JSON.stringify(ar_tsStart));
    localStorage.setItem("car", car);
    localStorage.setItem("locStart", JSON.stringify(ar_locStart));
    localStorage.setItem('kmStart', fKmStart);

    // remove api pause
    localStorage.removeItem("apiRequest");

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
    var ts = parseInt(new Date().getTime()); /* gets current ts */
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

    var ts = parseInt(new Date().getTime());

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
    var car = localStorage.getItem('car');
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

    // remove api pause
    localStorage.removeItem("apiRequest");
    



    // the following vars are only meant to be displayed to the user
    
    // calc driven km
    var kmDiff = kmStop - kmStart;

    // calc total time
    var sumTS = 0;
    ar_tsStop.forEach(function callback(value, index) {
      sumTS += ar_tsStop[index] - ar_tsStart[index];
    });
    totalHours = parseInt(Math.floor((sumTS % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
    totalMinutes = parseInt(Math.floor((sumTS % (1000 * 60 * 60)) / (1000 * 60)));
    totalSeconds = parseInt(Math.floor((sumTS % (1000 * 60)) / 1000));


    // get starting time
    var timeStart = new Date(ar_tsStart[0]);
    var options = {
        hour: "2-digit",
        minute: "2-digit",
    };
    strStart = timeStart.toLocaleString("de-DE",options)+" Uhr";

    // end time
    var timeStop = new Date(ar_tsStop.at(-1));
    var options = {
        hour: "2-digit",
        minute: "2-digit",
    };
    strStop = timeStop.toLocaleTimeString("de-DE",options)+" Uhr";

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
                <li><span class="fa-li"><i class="fa-solid fa-car"></i></span>${car}</li>
                <li><span class="fa-li"><i class="fa-solid fa-route"></i></span>${locStr}</li>
                <li><span class="fa-li"><i class="fa-solid fa-play"></i></span>${strStart}</li>
                <li><span class="fa-li"><i class="fa-solid fa-flag-checkered"></i></span>${strStop}</li>
                <!--<li><span class="fa-li"><i class="fa-solid fa-clock"></i></span>${totalHours}h ${totalMinutes}min ${totalSeconds}s</li>-->
                <li><span class="fa-li"><i class="fa-solid fa-road"></i></span>${kmDiff} km</li>
            </ul>
        </div>
    `;

    $("#btn-save").hide();
    $("#btn-back").show();
    // add new title
    document.getElementById("title-top").textContent= 'Letzte Fahrt';
    document.getElementById("subtitle-top").innerHTML= 'Wird gespeichert <span><i class="fa-solid fa-loader"></i></span>';
    // end dashboard stuff



    /*  call php to upload data
        including:
            car
            ar_locStart
            ar_tsStart
            ar_tsStop
            kmStart
            kmStop
    */
    
    // send as json string
    ar_locStartUP = JSON.stringify(ar_locStart);
    ar_tsStartUP = JSON.stringify(ar_tsStart);
    ar_tsStopUP = JSON.stringify(ar_tsStop);
    

    // perform ajax call
    $.ajax({
        type: 'POST',
        url: 'resources/php/functions/main-functions.php?',      
        data: "carUP=" + car + "&ar_locStartUP=" + ar_locStartUP + "&ar_tsStartUP=" + ar_tsStartUP + "&ar_tsStopUP=" + ar_tsStopUP + "&kmStartUP=" + kmStart + "&kmStopUP=" + kmStop,  
        success: function (response) {
          document.getElementById("subtitle-top").innerHTML= 'Gespeichert <span><i class="fa-solid fa-check"></i></span>';
          return;
        },
        error: function () {
            alert("Fehler: Ajax Fehler. Bitte Screenshot machen und manuell nachtragen.");
            return;

        }
    });

    
    

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



// get user location for spots
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(parsePosition);
  } else {
    return
  }
}

function parsePosition(position) {
  var lat = position.coords.latitude;
  var lon = position.coords.longitude;

    $.ajax({
        type: 'POST',
        url: 'resources/php/functions/parseLocation.php',      
        data: "lat=" + lat+ "&lon=" +  lon,  
        success: function (response) {
            var response = JSON.parse(response);
            var town = response.address.town;
            var village = response.address.village;
            // debugging stuff
            console.log(response);

            console.log(town);
            console.log(village);
            
            if(town){
                document.getElementById("input-loc").value = town;
                // set item to not repeat request
                localStorage.setItem("apiRequest", town);
            } else if(village){
                document.getElementById("input-loc").value = village;
                // set item to not repeat request
                localStorage.setItem("apiRequest", village);
            }
            
        },
        error: function () {
            //$("#loader").show();
            console.log("error in parsePosition()");
            return;

        }
    });

}



function aj_getKM() {
      var car = document.forms["meta"]["car"].value;
      $.ajax({
          type: 'POST',
          url: 'resources/php/functions/main-functions.php?',      
          data: "carSelected=" + car,  
          success: function (response) {
            //document.forms["meta"]["km"].value = response;
            an.set(response);
            return;
          },
          error: function () {
              return;
  
          }
      });
  
  }



  // log out function after button press
  function logOut(){
    $.ajax({
        type: 'POST',
        url: 'resources/php/functions/main-functions.php?',      
        data: "logout=True",  
        success: function (response) {
            loadDefault(); // delete all cookies
            return;
        },
        error: function () {
            location.reload(); // reload to get to login page
            return;

        }
    });
  }