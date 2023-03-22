var hoursLabel = document.getElementById("hours");
var minutesLabel = document.getElementById("minutes");
var secondsLabel = document.getElementById("seconds");
var totalSeconds = 0;




//start intervall for counter function
ar_startTS = JSON.parse(localStorage.getItem("timestamp_start"));
ar_stopTS = JSON.parse(localStorage.getItem("timestamp_stop"));
if(ar_startTS){ // only start after ts is set
  setInterval(setTime, 500);
}

// calc total time
function totalTime() {
  var sumTS = 0;
  if(!ar_stopTS) {
    return 0;
  }

  ar_startTS.forEach(function callback(value, index) {
    if(index === ar_startTS.length-1){
      return;
    }
    sumTS += ar_stopTS[index] - ar_startTS[index];
  });
  return sumTS;
}




//calc time and set timer
function setTime() {
  stopVar = localStorage.getItem("stopVar");
  if(!stopVar){
    if(ar_startTS !== 0){
      var referenceTS = ar_startTS.at(-1);
      totalSeconds = totalTime() + parseInt(new Date().getTime()) - referenceTS;
    } 
    totalHours = Math.floor((totalSeconds % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    totalMinutes = Math.floor((totalSeconds % (1000 * 60 * 60)) / (1000 * 60));
    secondsLabel.innerHTML = pad(Math.floor((totalSeconds % (1000 * 60)) / 1000));
    minutesLabel.innerHTML = pad(parseInt(totalMinutes));
    hoursLabel.innerHTML = pad(parseInt(totalHours));
  }
}

//write to document
function pad(val) {
  var valString = val + "";
  if (valString.length < 2) {
    return "0" + valString;
  } else {
    return valString;
  }
}



