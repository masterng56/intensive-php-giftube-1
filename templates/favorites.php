<div class="content__main-col">
    <header class="content__header">
        <h2 class="content__header-text">Избранные гифки</h2>
        <a class="button button--transparent button--transparent-thick
                    content__header-button" href="/add.php">Загрузить свою</a>
    </header>

    <?php if (count($gif_list)): ?>
    <ul class="gif-list">
        <?php foreach($gif_list as $gif): ?>
            <?=include_template('_gif.php', ['gif' => $gif]); ?>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <p class="error">У вас нет гифок в избранном</p>
    <?php endif; ?>
</div>
