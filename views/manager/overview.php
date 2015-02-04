<table class="default">
    <tbody>
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
            <td></td>
        </tr>
    </tbody>
</table>

<?

Sidebar::Get()->setImage("sidebar/medal-sidebar");

$actions = new ActionsWidget();
$actions->addLink(_("Jetzt eine Bombe legen"), PluginEngine::getURL($plugin, array(), "manager/set_bomb"), null, array("data-dialog" => "1"));
Sidebar::Get()->addWidget($actions);