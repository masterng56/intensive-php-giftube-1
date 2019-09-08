<div class="content__main-col">
    <header class="content__header">
        <h2 class="content__header-text">Кот-прачка</h2>
    </header>

    <div class="gif gif--large">
        <div class="gif__picture">
            <input type="checkbox" name="" id="gifControl" value="1" class="hide">
            <img src="uploads/gif1.gif" alt="" class="gif_img preview">
        </div>

        <div class="gif__desctiption">
            <div class="gif__description-data">
                <span class="gif__username">@fignam</span>
            </div>
            <div class="gif__description">
                <p>Кот-прачка</p>
            </div>
        </div>
    </div>

    <div class="comment-list">
        <h3 class="comment-list__title">Комментарии:</h3>
        <?php foreach ($comments as $comment) : ?>
            <article class="comment">
                <div class="comment__data">
                    <div class="comment__author">аноним</div>
                    <p class="comment__text"><?=esc($comment);?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
