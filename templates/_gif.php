<li class="gif gif-list__item">
    <div class="gif__picture">
        <a href="view.php?id=<?= $gif['id']; ?>" class="gif__preview">
            <img src="uploads/<?= $gif['path']; ?>" width="260" height="260">
        </a>
    </div>
    <div class="gif__desctiption">
        <h3 class="gif__desctiption-title">
            <a href="view.php?id=<?= $gif['id']; ?>"><?= esc($gif['title']); ?></a>
        </h3>

        <div class="gif__description-data">
            <span class="gif__username">@<?= esc($gif['name']); ?></span>
            <span class="gif__likes"><?= $gif['like_count']; ?></span>
        </div>
    </div>
</li>
