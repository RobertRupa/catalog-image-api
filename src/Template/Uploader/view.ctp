Unique ID: <?= $file->unique_id; ?>
<br>
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
<?= $this->Html->link(
    "delete", [
        'action' => 'delete',
        
        $file->id,
        'archive_all'
    ],["class" => "btn btn-danger float-right"]); ?>