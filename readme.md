# Giftube

Учебный проект "GifTube" для базового PHP-интенсива.

## Этапы сборки проекта с нуля

### 1 этап. Подготовка.

- добавить формирование категорий и гифок из массива;
- реализовать возможность переключения режимов сайта - работает/не работает;
- разнести верстку по отдельным шаблонам и показывать в своих сценариях;
- добавить в массив гифок дату добавления (в формате timestamp) и добавить вывод на страницу;
- реализуем страницу просмотра гифки с выводом комментариев;

### 2 этап. Подключение базы данных.

- создание схемы базы данных;
- подключаем базу данных и берем категории из базы данных;
- настроим вывод гифок из базы данных;
- реализуем поиск гифок по названию и описанию;
- реализуем страницу показа гифки;

Step 1: From your project repository, bring in the changes and test.

```
git fetch origin
git checkout -b adding-database origin/adding-database
git merge master
```

Step 2: Merge the changes and update on GitHub.

```
git checkout master
git merge --no-ff adding-database
git push origin master
```

### 3 этап. Работа с формами.

- сделаем сортировку гифок на главной - топовые/свежачок;
- подключаем форму добавления гифки;
- реализуем механизм добавления гифки;


На будущее:
- сделать