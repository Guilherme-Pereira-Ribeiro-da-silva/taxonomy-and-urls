<h2>Taxonomias</h2>

<table class="table table-responsive">
  <thead>
    <tr>
      <th scope="col">Nome</th>
      <th scope="col">Título</th>
      <th scope="col">É hierárquica?</th>
      <th scope="col">Ação</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($objects as $object): ?>
        <tr>
        <td><?php echo $object->taxonomy_name ?></td>
        <td><?php echo $object->label ?></td>
        <td><?php echo $object->is_hierarchical ? "Sim" : "Não" ?></td>
        <td>
            <?php echo "<a href='http://localhost/seox/wp-admin/admin.php?page=mvc_taxonomies-edit&id=$object->id'>Editar</a>" ?>
            |
            <?php echo "<a href='http://localhost/seox/wp-admin/admin.php?page=mvc_taxonomies-delete&id=$object->id'>Excluir</a>" ?>
        </td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>