

STUDIP.Bombe = {
    getHit: function (data) {
        if (data.bomb) {
            jQuery("#bombe_sound")[0].play();
            jQuery("#bombe #bombe_from_user").text(data.bomb.from_user_name);
            jQuery("#bombe").dialog({'title': jQuery("#bombe").text(), 'show': "fade", 'hide': "fade"});
        }
        if (data.deactivated > 0) {
            if (data.deactivated > 1) {
                alert("Juhu! " + data.deactivated + " Bomben von " + data.deactivated_by + " entschärft.");
            } else {
                alert("Juhu! Eine Bombe von " + data.deactivated_by + " entschärft.");
            }
        }
    }
};