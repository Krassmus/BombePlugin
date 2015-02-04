

STUDIP.Bombe = {
    getHit: function (bombe) {
        if (bombe) {
            jQuery("#bombe_sound")[0].play();
            jQuery("#bombe #bombe_from_user").text(bombe.from_user_name);
            jQuery("#bombe").dialog({'title': jQuery("#bombe").text(), 'show': "fade", 'hide': "fade"});
        }
    }
};