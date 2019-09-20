<div class="content__main-col">
    <header class="content__header">
        <h2 class="content__header-text"><?=htmlspecialchars($gif['title']);?></h2>
        <label for="gifControl">click</label>
    </header>

    <div class="gif gif--large">
        <div class="gif__picture">
            <input type="checkbox" name="" id="gifControl" value="1" class="hide">
            <label for="gifControl">Проиграть</label>
            <img src="uploads/<?= $gif['path']; ?>" alt="" class="gif_img main hide">
            <img src="uploads/<?= $gif['path']; ?>" alt="" class="gif_img preview">
        </div>

        <div class="gif__desctiption">
            <div class="gif__description-data">
                <span class="gif__username">@<?= esc($gif['name']); ?></span>

                <span class="gif__views"><?= $gif['show_count']; ?></span>
                <span class="gif__likes"><?= $gif['like_count']; ?></span>
            </div>
            <div class="gif__description">
                <p><?= esc($gif['description']); ?></p>
            </div>
            <?php if (isset($_SESSION['user']['id'])): ?>
                <div class="gif__controls">
                    <?php $likeClass = $is_liked ? 'gif__control--active' : ''; ?>
                    <a class="button gif__control <?=$likeClass;?>" href="/addlike.php?id=<?=$gif['id'];?>">Мне нравится</a>
                    <?php $favClass = $is_fav ? 'gif__control--active' : ''; ?>
                    <a class="button gif__control <?=$favClass;?>" href="/addfav.php?id=<?=$gif['id'];?>">В избранное</a>
                </div>
            <?php endif; ?>
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
    <?php if (isset($_SESSION['user']['id'])): ?>
        <form class="comment-form" action="" method="post">
            <label class="comment-form__label" for="comment">Добавить комментарий:</label>
            <textarea class="comment-form__text form__input--error" name="comment[content]" id="comment" rows="8" cols="80" placeholder="Помните о правилах и этикете. "></textarea>
                <div class="error-notice">
                    <span class="error-notice__icon"></span>
                    <span class="error-notice__tooltip">Это поле должно быть заполнено</span>
                </div>
            
            <input type="hidden" name="comment[gif_id]" value="11">
            <input class="button comment-form__button" type="submit" name="" value="Отправить">
        </form>    
    <?php endif; ?>
</div>

<aside class="content__additional-col">
    <h3 class="content__additional-title">Похожие гифки:</h3>

    <ul class="gif-list gif-list--vertical">
        <?php foreach ($sim_gifs as $rel_gif): ?>
            <li class="gif gif--small gif-list__item">
                <div class="gif__picture">
                    <a href="/view.php?id=<?= $rel_gif['id']; ?>" class="gif__preview">
                        <img src="uploads/<?= $rel_gif['path']; ?>" alt="" width="200" height="200">
                    </a>
                </div>
                <div class="gif__desctiption">
                    <h3 class="gif__desctiption-title">
                        <a href="/view.php?id=<?= $rel_gif['id']; ?>"><?= esc($rel_gif['title']); ?></a>
                    </h3>

                    <div class="gif__description-data">
                        <span class="gif__username">@<?= esc($rel_gif['name']); ?></span>
                        <span class="gif__likes"><?= $rel_gif['like_count']; ?></span>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>
