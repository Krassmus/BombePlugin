<? foreach (PageLayout::getMessages() as $messageBox) : ?>
    <?= $messageBox ?>
<? endforeach ?>

<form action="<?= PluginEngine::getLink($plugin, array(), "manager/set_bomb") ?>" method="post" data-dialog>
    <div style="margin: 60px;">
        <?= QuickSearch::get("user_id", new StandardSearch("user_id"))->setInputStyle("width: 100%;")->render() ?>
    </div>
    <div data-dialog-button style="text-align: center;">
        <?= \Studip\Button::create(_("bombardieren!")) ?>
    </div>
</form>