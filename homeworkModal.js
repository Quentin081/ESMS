var homeworkModal = document.getElementById("homeworkModal");
var openhwModalBtn = document.getElementById("openhwModalBtn");
var closehwModalBtn = document.getElementById("closehwModalBtn");

openhwModalBtn.onclick = function() {
    homeworkModal.style.display = "block";
}

closehwModalBtn.onclick = function() {
    homeworkModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == homeworkModal) {
        homeworkModal.style.display = "none";
    }
}
