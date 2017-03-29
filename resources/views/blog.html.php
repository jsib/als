<?php $this->extend('base') ?>

<?php $this->start('body') ?><br/>
    <h1>I'm test template</h1>
    Posts:<br/>
    <?php if (count($this->posts) == 0): ?>
        There are no posts yet.
    <?php else: ?>
        <?php foreach ($this->posts as $post): ?>
            <h4><?php echo $post['user_id'] ?></h4>
        <?php endforeach ?>
    <?php endif ?>
<?php $this->stop('body') ?>