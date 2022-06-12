<h2>Editar Url</h2>

<?php echo $this->form->create($model->name, array('is_admin' => $this->is_admin)); ?>
<?php echo $this->form->open_admin_table(); ?>
<?php echo $this->form->input('archive_permalink_suffix', array('label' => 'Sufixo da página geral')); ?>
<?php echo $this->form->input('single_permalink_suffix', array('label' => 'Sufixo da página única')); ?>
<?php echo $this->form->close_admin_table(); ?>
<?php echo $this->form->end('Editar Url'); ?>