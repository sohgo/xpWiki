<?php
/*
 * Created on 2007/06/29 by nao-pon http://hypweb.net/
 * $Id: gate.php,v 1.6 2008/11/13 00:30:22 nao-pon Exp $
 */

/*
 * $mydirname      : Module dirname
 * $mydirpath      : Module dirpath
 * $mytrustdirname : Trust dirname (xpwiki)
 */

@ ignore_user_abort(FALSE);

$xwGateOption['nocommonAllowWays'] = array('x2w');
$xwGateOption['nodosAllowWays'] = array('ref', 'fusen');
$xwGateOption['noumbAllowWays'] = array('ref', 'attach');
$xwGateOption['hypmodeAllowWays'] = array('w2x');

$mytrustdirpath = dirname( __FILE__ ) ;

$way = (isset($_GET['way']))? $_GET['way'] : ((isset($_POST['way']))? $_POST['way'] : '');
$way = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $way);

if ($xwGateOption['xmode']) {
	if (!in_array($way, $xwGateOption['nocommonAllowWays'])) xpWikiGate_goOut('Bad request.');
}

if ($xwGateOption['nodos']) {
	if (!in_array($way, $xwGateOption['nodosAllowWays'])) xpWikiGate_goOut('Bad request.');
}

if ($xwGateOption['noumb']) {
	if (!in_array($way, $xwGateOption['noumbAllowWays'])) xpWikiGate_goOut('Bad request.');
}

if (isset($xwGateOption['hypmode']) && $xwGateOption['hypmode']) {
	if (!in_array($way, $xwGateOption['hypmodeAllowWays'])) xpWikiGate_goOut('Bad request.');
}

$file_php = $mytrustdirpath . '/ways/' . $way . '.php';
if (file_exists($file_php)) {
	include $file_php;
} else {
	xpWikiGate_goOut('File not found.');
}

function xpWikiGate_goOut($str = '') {
	error_reporting(0);
	while( ob_get_level() ) {
		ob_end_clean() ;
	}
	header("HTTP/1.0 404 Not Found");
	exit($str);
}
?>