<!-- File: src/Template/Uploader/archive.ctp -->

<?= $this->Html->css('bootstrap/extensions/filter-control/bootstrap-table-filter-control.css') ?>
<?= $this->Html->css('bootstrap/dataTables.bootstrap4.min.css') ?>
<?= $this->Html->script('bootstrap/extensions/filter-control/bootstrap-table-filter-control.js') ?>
<?= $this->Html->script('jquery/jquery.dataTables.min.js') ?>
<?= $this->Html->script('bootstrap/dataTables.bootstrap4.min.js') ?>

<h1>list of all files</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Unique ID</th>
    </tr>
  </thead>
  <?php foreach ($uploader as $file): ?>
  <tr>
    <td>
      <?= $this->Html->link($file->unique_id, ['action' => 'view_unique_id', $file->unique_id,  '?' => ['unique_id' => $file->unique_id]]) ?>
    </td>
  <?php endforeach; ?>
</table>
<script>
$(document).ready(function() {
    $('.table').DataTable();
} );
</script>