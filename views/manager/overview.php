<table class="default">
    <tbody>
    <tr>
        <td><?= _("Trefferquotient") ?></td>
        <td><?
            $letzterMonat = Bombe::countBySQL("from_user = ? AND mkdate > UNIX_TIMESTAMP() - 86400 * 30", array($user_id));
            $trefferLetzterMonat = Bombe::countBySQL("from_user = ? AND hit = '1' AND mkdate > UNIX_TIMESTAMP() - 86400 * 30", array($user_id));
            ?>
            <? if ($letzterMonat > 0) : ?>
                <?= ($trefferLetzterMonat / $letzterMonat * 100) ?>%
            <? else : ?>
                0%
            <? endif ?>
        </td>
    </tr>
    <tr>
        <td><?= _("Verteidigungsquotient") ?></td>
        <td><?
            $letzterMonat = Bombe::countBySQL("user_id = ? AND mkdate > UNIX_TIMESTAMP() - 86400 * 30", array($user_id));
            $verteidigtLetzterMonat = Bombe::countBySQL("user_id = ? AND (hit = '0' OR deactivated = '1') AND mkdate > UNIX_TIMESTAMP() - 86400 * 30", array($user_id));
            ?>
            <? if ($letzterMonat > 0) : ?>
                <?= ($verteidigtLetzterMonat / $letzterMonat * 100) ?>%
            <? else : ?>
                0%
            <? endif ?>
        </td>
    </tr>
    <tr>
        <td><?= _("Verteilte Bomben") ?></td>
        <td><?= Bombe::countBySQL("from_user = ?", array($user_id)) ?></td>
    </tr>
    <tr>
            <td><?= _("Erfolgreich gezündete Bomben") ?></td>
            <td><?= Bombe::countBySQL("from_user = ? AND hit = '1' ", array($user_id)) ?></td>
        </tr>
        <tr>
            <td><?= _("Ziel verfehlt") ?></td>
            <td><?= Bombe::countBySQL("from_user = ? AND hit = '0' AND mkdate < UNIX_TIMESTAMP() - 2 * 60", array($user_id)) ?></td>
        </tr>
        <tr>
            <td><?= _("Selbst getroffen") ?></td>
            <td><?= Bombe::countBySql("user_id = ? AND hit = 1", array($user_id))?></td>
        </tr>
        <tr>
            <td><?= _("Entschärfte Bomben") ?></td>
            <td><?= Bombe::countBySql("user_id = ? AND deactivated = 1", array($user_id))?></td>
        </tr>
    </tbody>
</table>

<?

Sidebar::Get()->setImage($plugin->getPluginURL()."/assets/bomb-sidebar.png");

$actions = new ActionsWidget();
$actions->addLink(_("Jetzt eine Bombe legen"), PluginEngine::getURL($plugin, array(), "manager/set_bomb"), null, array("data-dialog" => "1"));
Sidebar::Get()->addWidget($actions);