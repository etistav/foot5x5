class PlayersFilter {

    /**
     * Get checkbox value
     */
    static getCheckboxValue() {
        var playersFilterCheckbox = document.getElementsByClassName("activePlayersCheckbox");
        var checkedValue = playersFilterCheckbox[0].checked;
        return checkedValue;
    }

    /**
     * Change display of inactive players
     * @param {boolean} value 
     */
    static filter(value) {
        var i;
        var allInactivePlayers = document.getElementsByClassName("inactivePlayer");
        // console.log("Clic sur playersFilterCheckbox : " + value);
        for (i = 0; i < allInactivePlayers.length; i++) {
            if (value) {
                // console.log("Masquer les joueurs inactifs");
                allInactivePlayers[i].style.display = 'none';
            } else {
                allInactivePlayers[i].style.removeProperty('display');
            }
        }
    }
}

$(document).ready(function() {
    // Apply filter once the page is loaded
    var checkedValue = PlayersFilter.getCheckboxValue();
    PlayersFilter.filter(checkedValue);

    // Apply filter once the checkbox is clicked
    var playersFilterCheckbox = document.getElementsByClassName("activePlayersCheckbox");
    playersFilterCheckbox[0].addEventListener("click", function(e) {
        var checkedValue = this.checked;
        PlayersFilter.filter(checkedValue);
    });

    // Apply filter once a sortable table is reset
    $('#notes-table').on('reset-view.bs.table', function(){
        var checkedValue = PlayersFilter.getCheckboxValue();
        PlayersFilter.filter(checkedValue);
    });
});