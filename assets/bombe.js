

STUDIP.Bombe = {
    getHit: function (bomben) {
        if (bomben.length > 0) {
            jQuery("#bombe_sound")[0].play();
        }
    }
};