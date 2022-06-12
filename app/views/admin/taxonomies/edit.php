<h2>Editar Taxonomia</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->input('taxonomy_name', array('label' => 'Nome da taxonomia','id' => 'taxonomy_name')); ?>
<?php echo $this->form->input('label', array('label' => 'Título da taxonomia','id' => 'taxonomy_label')); ?>
<?php echo $this->form->checkbox_input('is_hierarchical', array('label' => 'É hierárquica?','id' => 'is_hierarchical')); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Editar Taxonomia'); ?>