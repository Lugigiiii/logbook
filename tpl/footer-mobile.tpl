</body>
<script src="../resources/js/timer.js"></script>
<script src="../resources/js/main-functions.js"></script>
{literal}
<script>
    // loading items from browser
    if(localStorage.getItem("savedComplete")){
        loadDefault();
    }

    // start main function
    loadView();

    // jQuery to adjust input format
    $(function() {
        an = new AutoNumeric('#numeric', {currencySymbol :' km', allowDecimalPadding:"false",currencySymbolPlacement:'s',digitGroupSeparator:"'"});
    });
    $(function() {
        an2 = new AutoNumeric('#numeric-2', {currencySymbol :' km', allowDecimalPadding:"false",currencySymbolPlacement:'s',digitGroupSeparator:"'"});
    });

    // get km after car ist selected
    $('#car-selector').change(function(){
        aj_getKM();
        // get location and write to input and localStorage. Get from Storage if already set
        if(!localStorage.getItem("apiRequest")){     
            window.onpaint = getLocation();
        } else {
            document.getElementById("input-loc").value = localStorage.getItem("apiRequest");
        }
    })

    if (typeof navigator.serviceWorker !== 'undefined') {
        navigator.serviceWorker.register('/sw.js')
    }

    // date time picker
    const dateInput = document.getElementById("man-start");
    dateInput.showPicker();
    const dateInput2 = document.getElementById("man-end");
    dateInput2.showPicker();
</script>
{/literal}
</html>