<li class="gif gif-list__item">
    <div class="gif__picture">
        <a href="" class="gif__preview">
            <img src="uploads/<?=$gif['gif']; ?>" width="260" height="260">
        </a>
    </div>
    <div class="gif__desctiption">
        <h3 class="gif__desctiption-title">
            <a href="view.php"><?=$gif['title']; ?></a>
        </h3>

        <div class="gif__description-data">
            <span class="gif__username"><?=$gif['author'];?>
                от <small><?=show_date($gif['dt']); ?></small>
            </span>
            <span class="gif__likes"><?=$gif['likes_count']; ?></span>
        </div>
    </div>
</li>
