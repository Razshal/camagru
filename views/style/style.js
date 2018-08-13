const errorField = document.getElementById("errorPlace");
if (errorField && errorField.children.length < 1)
    errorField.style.display = "none";

const emptyCanvas = document.getElementById("capture");
if (emptyCanvas)
    emptyCanvas.style.display = "none";
