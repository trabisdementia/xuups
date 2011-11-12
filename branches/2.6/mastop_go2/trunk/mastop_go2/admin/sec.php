<?php
### =============================================================
### Mastop InfoDigital - Paix�o por Internet
### =============================================================
### Arquivo para Manipula��o de Se��es
### =============================================================
### Developer: Fernando Santos (topet05), fernando@mastop.com.br
### Copyright: Mastop InfoDigital � 2003-2007
### -------------------------------------------------------------
### www.mastop.com.br
### =============================================================
### $Id$
### =============================================================
include_once 'admin_header.php';


$op = (isset($_GET['op'])) ? $_GET['op'] : 'listar';
if (isset($_GET)) {
	foreach ($_GET as $k => $v) {
		$$k = $v;
	}
}

if (isset($_POST)) {
	foreach ($_POST as $k => $v) {
		$$k = $v;
	}
}

switch ($op) {
	case "section_editar":
		mgo_adm_menu();
		$sec_10_id = (!empty($sec_10_id)) ? $sec_10_id : 0;
		$sec_classe =& mgo_getClass(MGO_MOD_TABELA0, $sec_10_id);
		if (empty($sec_10_id) || $sec_classe->getVar('sec_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/".MGO_MOD_DIR."/admin/sec.php?op=listar", 3, MGO_ADM_404);
		}
		$form['titulo'] = MGO_ADM_SEC_EDIT;
		$form['op'] = "salvar";
		include XOOPS_ROOT_PATH."/modules/".MGO_MOD_DIR."/include/sec.form.inc.php";
		$sec_form->display();
		break;
	case "section_deletar":
		mgo_adm_menu();
		$sec_10_id = (!empty($sec_10_id)) ? $sec_10_id : 0;
		$sec_classe =& mgo_getClass(MGO_MOD_TABELA0, $sec_10_id);
		if (empty($sec_10_id) || $sec_classe->getVar('sec_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/".MGO_MOD_DIR."/admin/sec.php?op=listar", 3, MGO_ADM_404);
		}
		xoops_confirm(array('op' => 'section_deletar_ok', 'sec_10_id' => $sec_10_id), 'sec.php', sprintf(MGO_ADM_SEC_CONFIRMA_DEL, $sec_10_id, $sec_classe->getVar("sec_30_nome")));
		break;
	case "section_deletar_ok":
		$sec_10_id = (!empty($sec_10_id)) ? $sec_10_id : 0;
		$sec_classe =& mgo_getClass(MGO_MOD_TABELA0, $sec_10_id);
		$go2_classe =& mgo_getClass(MGO_MOD_TABELA1);
		if (empty($sec_10_id) || $sec_classe->getVar('sec_10_id') == '') {
			redirect_header(XOOPS_URL."/modules/".MGO_MOD_DIR."/admin/sec.php?listar", 3, MGO_ADM_404);
		}
		$go2_classe->deletaTodos(new Criteria("sec_10_id", $sec_10_id));
		$sec_classe->delete();
		redirect_header(XOOPS_URL."/modules/".MGO_MOD_DIR."/admin/sec.php?op=listar", 3,MGO_ADM_SUCESS_DEL);
		break;
	case 'novo':
		mgo_adm_menu();
		$sec_classe =& mgo_getClass(MGO_MOD_TABELA0);
		$form['titulo'] = MGO_ADM_SEC_NEW;
		$form['op'] = "salvar";
		include XOOPS_ROOT_PATH."/modules/".MGO_MOD_DIR."/include/sec.form.inc.php";
		$sec_form->display();
		break;
	case 'salvar':
		if (empty($sec_10_id)) {
			$sec_classe =& mgo_getClass(MGO_MOD_TABELA0);
		}else{
			$sec_classe =& mgo_getClass(MGO_MOD_TABELA0, $sec_10_id);
		}
		$sec_classe->setVar("sec_30_nome", $sec_30_nome);
		if ($sec_classe->getVar("sec_10_id") != "") {
			$msg = "UPD";
		}else{
			$msg = "ADD";
		}
		$erro = '';
		if(!$sec_classe->store()) {
			ob_start();
			xoops_error(MGO_ADM_DB_ERRO);
			$erro .= ob_get_clean();
		}else{
			redirect_header(XOOPS_URL."/modules/".MGO_MOD_DIR."/admin/sec.php?op=listar", 3,constant("MGO_ADM_SUCESS_".$msg));
		}
	case 'listar':
	default:
        mgo_adm_menu();

		echo (!empty($erro)) ? $erro."<br />" : '';
		$sec_classe =& mgo_getClass(MGO_MOD_TABELA0);
		$sec_10_id = (empty($sec_10_id)) ? null : $sec_10_id;
		// Op��es
		$c['op'] = 'listar';
		$c['form'] = 0; // 0 para exibir os registros em modo visualiza��o, 1 em modo edi��o
		$c['checks'] = 0;
		$c['print'] = 0;

		$c['nome'][1] = 'sec_10_id';
		$c['rotulo'][1] = MGO_ADM_ID;
		$c['tipo'][1] = "text";
		$c['tamanho'][1] = 5;
		$c['show'][1] = '$reg->getVar($reg->id)';

		$c['nome'][2] = 'sec_30_nome';
		$c['rotulo'][2] = MGO_ADM_NOME;
		$c['tipo'][2] = "text";

		$c['nome'][3] = 'destaques';
		$c['rotulo'][3] = MGO_ADM_GO2;
		$c['tipo'][3] = "none";
		$c['show'][3] = '($reg->contaDestaques() > 0) ? $reg->contaDestaques()." <a href=\''.XOOPS_URL.'/modules/'.MGO_MOD_DIR.'/admin/go2.php?op=listar_dstac&sec_10_id=".$reg->getVar($reg->id)."'.'\' title=\''.MGO_ADM_GO2.'\'><img src='. $pathImageIcon .'/search.png align=\'absmiddle\' alt=\''.MGO_ADM_GO2.'\'></a>": 0;';
		$c['nosort'][3] = 1;

		$c['botoes'][1]['link'] = XOOPS_URL.'/modules/'.MGO_MOD_DIR.'/admin/sec.php?op=section_editar';
		$c['botoes'][1]['imagem'] = $pathImageIcon .'/edit.png';
		$c['botoes'][1]['texto'] = _EDIT;

		$c['botoes'][2]['link'] = XOOPS_URL.'/modules/'.MGO_MOD_DIR.'/admin/sec.php?op=section_deletar';
		$c['botoes'][2]['imagem'] = $pathImageIcon .'/delete.png';
		$c['botoes'][2]['texto'] = _DELETE;

		// Tradu��o
		$c['lang']['titulo'] = MGO_ADM_SEC_TITULO;		
		echo $sec_classe->administracao(XOOPS_URL."/modules/".MGO_MOD_DIR."/admin/sec.php", $c);
		
		$sec_classe =& mgo_getClass(MGO_MOD_TABELA0, $sec_10_id);
		$form['titulo'] = ((empty($sec_10_id)) ? MGO_ADM_SEC_NEW : MGO_ADM_SEC_EDIT);
		$form['op'] = "salvar";
		include XOOPS_ROOT_PATH."/modules/".MGO_MOD_DIR."/include/sec.form.inc.php";
		$sec_form->display();
		
		break;
}
echo "<div align='center' style='margin-top:10px'><a target='_blank' href='http://www.mastop.com.br/conteudo/open-source/mastop-go2-english.mstp'><img src='images/mgo2_footer.gif'></a><br /><br /></div>";
include 'admin_footer.php';
