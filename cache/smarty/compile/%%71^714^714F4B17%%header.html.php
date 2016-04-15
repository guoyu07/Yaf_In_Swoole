<?php /* Smarty version 2.6.28, created on 2016-04-15 10:09:22
         compiled from header.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'header.html', 5, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<?php if (isset ( $this->_tpl_vars['meta_title'] ) && $this->_tpl_vars['meta_title']): ?>
	<title><?php echo ((is_array($_tmp=$this->_tpl_vars['meta_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'htmlall', 'UTF-8') : smarty_modifier_escape($_tmp, 'htmlall', 'UTF-8')); ?>
</title>
	<?php endif; ?>
	<?php if (isset ( $this->_tpl_vars['meta_description'] ) && $this->_tpl_vars['meta_description']): ?>
	<meta name="description" content="<?php echo ((is_array($_tmp=$this->_tpl_vars['meta_description'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html', 'UTF-8') : smarty_modifier_escape($_tmp, 'html', 'UTF-8')); ?>
"/>
	<?php endif; ?>
	<?php if (isset ( $this->_tpl_vars['meta_keywords'] ) && $this->_tpl_vars['meta_keywords']): ?>
	<meta name="keywords" content="<?php echo ((is_array($_tmp=$this->_tpl_vars['meta_keywords'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html', 'UTF-8') : smarty_modifier_escape($_tmp, 'html', 'UTF-8')); ?>
"/>
	<?php endif; ?>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<?php if (isset ( $this->_tpl_vars['css_files'] )): ?>
	<?php $_from = $this->_tpl_vars['css_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['css_uri']):
?>
	<link href="<?php echo $this->_tpl_vars['css_uri']; ?>
" rel="stylesheet" type="text/css" media="all"/>
	<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
	<?php if (isset ( $this->_tpl_vars['js_files'] )): ?>
	<?php $_from = $this->_tpl_vars['js_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js_uri']):
?>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['js_uri']; ?>
"></script>
	<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
</head>
<body>