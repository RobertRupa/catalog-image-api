<?php echo $this->Form->create($demo, [
    'type' => 'file',
    'url' => ['action' => 'demo']
]); ?>
<div class="form-group">
<?php echo $this->Form->control('unique_id', [
    'type' => 'text',
    'label' => 'Unique ID',
    'class' => 'form-control',
    'required' => true
    ]); ?>
    <?php echo $this->Form->submit('Show', [
        'class' => 'btn btn-primary float-right'
    ]); ?>
</div>
<?php echo $this->Form->end(); ?>

<?php 
if ($demo){
?>
<?php foreach ($demo as $file): ?>
Created: <?= $file->created; ?>
<br>
Comment: <p><?= $file->comment; ?></p>
<br>
URL:<br><span><?= "https://" . $_SERVER['SERVER_NAME'].$file->url; ?></span><br>
<?= $this->Html->image($file->url,[
          'height' => '500',
          'alt' => $file->alt
        ]); ?>
<br>
<?= $file->alt; ?>
<br>
<?php endforeach; ?>
<?php
}