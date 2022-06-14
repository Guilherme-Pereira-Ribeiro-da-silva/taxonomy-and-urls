<h2>Urls</h2>

<table class="table table-responsive">
  <thead>
    <tr>
      <th scope="col">Nome da taxonomia</th>
      <th scope="col">Permalink em página uníca</th>
      <th scope="col">Permalink em página geral</th>
      <th scope="col">Ação</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $i = 0;
    foreach($objects as $object): 
    ?>
        <tr>
            <td>
                <?php
                $home_url = home_url();
                $id = $taxonomies[$i]->id;
                echo "<a href='$home_url/wp-admin/admin.php?page=mvc_taxonomies-edit&id=$id'>";
                echo $taxonomies[$i]->taxonomy_name; 
                echo "</a>";
                ?>
            </td>
            <td><?php echo $object->single_permalink_suffix ?></td>
            <td><?php echo $object->archive_permalink_suffix ?></td>
            <td>
                <?php echo "<a href='$home_url/wp-admin/admin.php?page=mvc_urls-edit&id=$object->id'>Editar</a>" ?>
            </td>
        </tr>
    <?php 
        $i += 1;
    endforeach; 
    ?>
  </tbody>
</table>

