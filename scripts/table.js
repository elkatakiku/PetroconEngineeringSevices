function viewData() { 
    console.log("View project");
    window.location.href = "projectganttchart.html";
}

function openTask() {
    console.log("Clicked");
    $("#taskBar").load("data.txt", {
        firstName: "Eli",
        lastName: "Lamzon"
    }, () => {
        console.log("Clicked");
        $("#taskBar").toggleClass("hide");
    });
}