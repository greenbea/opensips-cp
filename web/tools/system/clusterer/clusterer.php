<?php
/*
* Copyright (C) 2016 OpenSIPS Project
*
* This file is part of opensips-cp, a free Web Control Panel Application for
* OpenSIPS SIP server.
*
* opensips-cp is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* opensips-cp is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

require("template/header.php");
require("lib/".$page_id.".main.js");
include("lib/db_connect.php");
require("../../../common/cfg_comm.php");

$table=$config->table_clusterer;
$current_page="current_page_address";

if (isset($_POST['action'])) $action=$_POST['action'];
else if (isset($_GET['action'])) $action=$_GET['action'];
else $action="";

if (isset($_GET['page'])) $_SESSION[$current_page]=$_GET['page'];
else if (!isset($_SESSION[$current_page])) $_SESSION[$current_page]=1;

$info="";
$errors="";

if ( $_SESSION['read_only'] && 
($action=="add" || $action=="do_add" || $action=="edit" || $action=="modify" || $action=="delete" || $action=="change_state") ) {
	$errors= "User with Read-Only Rights";
} else	

switch ($action) {

#################
# start add new #
#################
case "add":
	extract($_POST);
	require("template/".$page_id.".add.php");
	require("template/footer.php");
	exit();
#################
# end add new   #
#################


################
# start do add #
################
case "do_add":
	$cln_cid=$_POST['cluster_id'];
	$cln_sid=$_POST['node_id'];
	$cln_url=$_POST['url'];
	$cln_ping=$_POST['no_ping'];
	$cln_description=$_POST['description'];

	$sql = "INSERT INTO ".$table." (cluster_id, node_id, url, no_ping_retries, description) VALUES 
		(".$cln_cid.",".$cln_sid.",'".$cln_url."','".$cln_ping."','".$cln_description."')";
	$result = $link->exec($sql);
       	if(PEAR::isError($result)) {
		$errors = "Add/Insert to DB failed with: ".$result->getUserInfo();
	} else {
		$info="The new cluster node was added";
	}
	$link->disconnect();

	break;
##############
# end do add #
##############


#################
# start edit	#
#################
case "edit":
	extract($_POST);

	require("template/".$page_id.".edit.php");
	require("template/footer.php");
	exit();
#############
# end edit  #
#############


#################
# start modify	#
#################
case "modify":
	$cle_id = $_GET['id'];
	$cle_cid=$_POST['cluster_id'];
	$cle_sid=$_POST['node_id'];
	$cle_url=$_POST['url'];
	$cle_ping=$_POST['no_ping'];
	$cle_description=$_POST['description'];

	$sql = "UPDATE ".$table." set cluster_id=".$cle_cid.", node_id=".$cle_sid.", url='".$cle_url."', no_ping_retries='".$cle_ping."', description='".$cle_description."' where id=".$cle_id;
	$result = $link->exec($sql);
       	if(PEAR::isError($result)) {
		$errors = "Update to DB failed with: ".$result->getUserInfo();
	} else {
		$info="Cluster Node has been updated";
	}
	$link->disconnect();

	break;
#################
# end modify	#
#################


################
# start delete #
################
case "delete":
	$id=$_GET['id'];

	$sql = "DELETE FROM ".$table." WHERE id=".$id;
	$link->exec($sql);
	$link->disconnect();
	$info="Record has been deleted";

	break;
##############
# end delete #
##############


######################
# start change state #
######################
case "change_state":

	if ($_GET['state']=='1') {
		$desired_state = '0';
	} else if ($_GET['state']=='0'){
		$desired_state = '1';
	}

	$id = $_GET['id'];
	$address = $_GET['address'];

	$sql = "UPDATE ".$table." set state='".$desired_state."' where id=".$id;
	$result = $link->exec($sql);
       	if(PEAR::isError($result)) {
		$errors = "Update to DB failed with: ".$result->getUserInfo();
	} else {
		$info="Cluster Node has been updated";
	}
	$link->disconnect();

	break;
####################
# end change state #
####################

} // switch(action)



################
# start search #
################
if ($action=="search")
{
	$_SESSION['cl_cid']=$_POST['cl_cid'];
	$_SESSION['cl_url']=$_POST['cl_url'];
	extract($_POST);
	if ($show_all=="Show All") {
		$_SESSION['cl_cid']="";
		$_SESSION['cl_url']="";
	} else if($search=="Search"){
		$_SESSION['cl_cid']=$_POST['cl_cid'];
		$_SESSION['cl_url']=$_POST['cl_url'];
	}
}
##############
# end search #
##############

##############
# start main #
##############

require("template/".$page_id.".main.php");
if ($errors!="") echo('<tr><td align="center"><div class="formError">'.$errors.'</div></td></tr>');
if ($info!="") echo('<tr><td  align="center"><div class="formInfo">'.$info.'</div></td></tr>');
require("template/footer.php");
exit();

##############
# end main   #
##############
?>
