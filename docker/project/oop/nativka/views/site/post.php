<h1>Список статей</h1>
<ol>
    <?php
    if (isset($posts)) {
        foreach ($posts as $post) {
            echo '<li>' . $post->title . '</li>';
        }
    } else {
        echo ('ы');
    }

    ?>
</ol>