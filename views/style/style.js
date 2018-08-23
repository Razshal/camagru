const errorPlace = document.getElementById("errorPlace");

errorPlace.onclick = () =>
{
    if (errorPlace && !errorPlace.children)
        errorPlace.style.display = "none";
};

if (errorPlace && !errorPlace.children)
    errorPlace.style.display = "none";

function userLog(type, message)
{
    let errorPlace = document.getElementById("errorPlace");
    let errorElem = document.createElement('p');

    errorPlace.style.display = "block";
    errorElem.innerHTML = message.toString();
    errorElem.classList.add(type);
    errorElem.onclick = () =>
        errorElem.parentNode.removeChild(errorElem);
    errorPlace.appendChild(errorElem);
}