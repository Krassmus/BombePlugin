<? foreach (PageLayout::getMessages() as $messageBox) : ?>
    <?= $messageBox ?>
<? endforeach ?>

<form action="<?= PluginEngine::getLink($plugin, array(), "manager/set_bomb") ?>" method="post" data-dialog>
    <div style="margin: 60px;">
        <?= QuickSearch::get("user_id", new StandardSearch("user_id"))->setInputStyle("width: 100%;")->render() ?>
    </div>
    <div data-dialog-button style="text-align: center;">
        <?= \Studip\Button::create(_("Bombardieren!")) ?>
    </div>
</form>

<?
$words = array(
    0   => _("Was sich liebt, das neckt sich."),
    1   => _("Eine Bombe zu legen tut nicht weh - jedenfalls nicht einem selbst."),
    2   => _("Man kann Bomben nur entschärfen, indem man etwas blubbert, eine Datei hochlädt oder etwas für seinen Stud.IP-Score tut, bevor die Bombe bei einem eintrifft."),
    3   => _("Lass die Bombe platzen!"),
    4   => _("Granatenstark!"),
    5   => _("Gelegte Bomben zünden nur, wenn die Person in den nächsten zwei Minuten in Stud.IP online ist."),
    6   => _("Dieses Feature schlägt ein wie eine Bombe."),
    7   => _("Heute ist wieder ein Bombenwetter!"),
    8   => _("Bombardieren kostet zwar nichts, aber wer wahllos bzw. zu unpräzise bombardiert, hat einen schlechten Trefferquotienten."),
    9   => _("Die Onlineliste in Stud.IP eignet sich gut, um neue Opfer zu finden."),
    'a' => _("Eine Bombe ist nur die moderne Variante 'Ich denk an Dich' zu sagen."),
    'b' => _("Die erste Bombe ist gratis. Und die zweite auch. Und die dritte."),
    'c' => _("Eine Bombe in Ehren kann niemand verwehren."),
    'd' => _("A bomb a day keeps the PHD away."),
    'e' => _("Dieses Feature schlägt ein wie eine Bombe."),
    'f' => _("Heute ist wieder ein Bombenwetter!"),
) ?>

<p class="info" style="font-style: italic; font-size: 1.3em;">
    <? $hash = md5(round(time() / 86400) . $GLOBALS['user']->id) ?>
    <?= htmlReady($words[$hash[0]]) ?>
</p>