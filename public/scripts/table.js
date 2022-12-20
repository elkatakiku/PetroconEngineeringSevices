function viewData(dataUrl) { 
    console.log("View project");
    console.log(dataUrl);
    window.location.href = dataUrl;
 }

 let chartRows = $(".chart-row");

 if (chartRows.length > 0) {
     for (let i = 0; i < chartRows.length; i++) {
         if (i % 2===0 && i !== 0) {
            $(chartRows[i]).css("background-color", "#EEF4ED");
            $(chartRows[i]).find(".chart-row-item").css("background-color", "#EEF4ED");
         }
     }
 }