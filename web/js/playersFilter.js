class PlayersFilter {

    /**
     * Change display of inactive players
     * @param {boolean} value 
     */
    static filter(value) {
        var i;
        var allInactivePlayers = document.getElementsByClassName("notes-inactivePlayer");
        console.log("Clic sur playersFilterCheckbox : " + value);
        for (i = 0; i < allInactivePlayers.length; i++) {
            if (value) {
                console.log("Masquer les joueurs inactifs");
                allInactivePlayers[i].style.display = 'none';
            } else {
                allInactivePlayers[i].style.removeProperty('display');
            }
        }
    }
}

$(document).ready(function() {
    var playersFilterCheckbox = document.getElementById("notes-form-activePlayers");
    var checkedValue = playersFilterCheckbox.checked;
    PlayersFilter.filter(checkedValue);

    playersFilterCheckbox.addEventListener("click", function(e) {
        var checkedValue = this.checked;
        PlayersFilter.filter(checkedValue);
    });
});