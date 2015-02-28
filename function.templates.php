<?php
/* @var $this SmartySnippets */
if (!is_object(cmsms())) exit;
if (!$this->CheckPermission("Modify Templates")) {
    $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$this->CreateStubFiles();

$smarty->assign('title_smarty_blocks',
    $this->Lang('blocktemplates'));
$smarty->assign('title_smarty_functions',
    $this->Lang('functiontemplates'));

$smarty->assign('smarty_blocks_form',
    $this->ShowTemplateList($id,$returnid,'block_', null, 'templates', null, $this->Lang('blocktemplates')));

$smarty->assign('smarty_functions_form',
    $this->ShowTemplateList($id,$returnid,'function_', null, 'templates', null, $this->Lang('functiontemplates')));


echo $this->ProcessTemplate('templates_tab.tpl');
