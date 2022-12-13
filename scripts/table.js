function viewData() { 
    console.log("View project");
    window.location.href = "projectganttchart.html";
}

function openTask(row, event) {
    console.log("Clicked open task");
    let selectedRow = $(row);
    let taskBar = $("#taskBar");

    if(!selectedRow.hasClass("active")) {
        let hasActiveRow = selectedRow.siblings(".active");
        if (hasActiveRow) {
            console.log(hasActiveRow.removeClass("active"));
            console.log("A row is active");
        }

        if (taskBar.hasClass("hide")) {
            console.log("Taskbar is inactive");
            console.log(selectedRow.addClass("active"));
            taskBar.removeClass("hide");
        }

        console.log("Showing");
        taskBar.load("data.txt", {
            firstName: "Eli",
            lastName: "Lamzon"
        }, () => {
            console.log("Open Task/Row Clicked");
            console.log(selectedRow.addClass("active"));
        });
        
    } else {
        console.log("Hiding");
        console.log(selectedRow.removeClass("active"));
        taskBar.addClass("hide");
    }

    // console.log(event);
    // event.stopPropagation();
}