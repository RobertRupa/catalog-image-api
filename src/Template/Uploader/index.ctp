<!-- File: src/Template/Uploader/index.ctp -->

<?= $this->Html->css('dropzone/dropzone.min.css') ?>
<?= $this->Html->script('dropzone.js') ?>
<?= $this->Html->script('dropzone-custom.js') ?>

<p>You can upload multiple multiple files by drag & drop or click on dropzone to chose an image.</p>
<p>Files with the same name will be repleaced in dropzone.</p>
<p>After save old images with the same name and same unique ID will be moved to Archive and actual files will take their places.</p>
<?php echo $this->Form->create($uploader, [
    'type' => 'file',
    'url' => ['action' => 'save'],
    'class' => 'dropzone'
]); ?>
<div class="form-group">
<?php echo $this->Form->control('unique_id', [
    'type' => 'text',
    'label' => 'Unique ID',
    'class' => 'form-control',
    'required' => true
    ]); ?>
    <?php echo $this->Form->control('comment', [
        'type' => 'text',
        'label' => 'Additional informatin',
        'class' => 'form-control'
        ]); ?>
    <?php echo $this->Form->control('alt', [
        'type' => 'text',
        'label' => 'Img Alt',
        'class' => 'form-control'
        ]); ?>
<?php echo $this->Form->control('files', [
    'type' => 'text',
    'class' => 'files-to-upload',
    'hidden' => true
    ]);  ?>
    <?php echo $this->Form->submit('Save', [
        'class' => 'btn btn-primary float-right'
    ]); ?>
</div>
<?php echo $this->Form->end(); ?>