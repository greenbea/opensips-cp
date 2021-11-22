<?php
 /*
 * Copyright (C) 2011 OpenSIPS Project
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
global $config;
$config->boxes = array(
    "mi_conn" => array(
		"default" => "json:127.0.0.1:8888/mi",
		"name"    => "MI connector",
		"tip"    => "Placeholder",
		"type"    => "text",
		'show_in_edit_form' => true,
	),
	"monit_conn" => array(
		"default" => "127.0.0.1:2812",
		"name"    => "Monit connector",
		"type"    => "text",
		'show_in_edit_form' => true,
    ),
	"monit_user" => array(
		"default" => "callid",
		"name"    => "Monit username",
		"type"    => "text",
		"validation_regex" => null,
		'show_in_edit_form' => true,
	),
	"monit_pass" => array(
		"default" => "",
		"name"    => "Monit password",
		"type"    => "password",
		"validation_regex" => null,
		'show_in_edit_form' => false,
	),
	"monit_ssl" => array(
		"default" => "/",
		"name"    => "Monit SSL",
        "options" => array('Disabled'=>'0', 'Enabled'=>'1'),
		"type"    => "dropdown",
		'show_in_edit_form' => true,
		"validation_regex" => null,
    ),
	"desc" => array(
		"default" => "/var/lib/opensips_cdrs",
		"name"    => "Box description",
		"type"    => "text",
		"validation_regex" => null,
		'show_in_edit_form' => true,
    ),
	"smonitcharts" => array(
		"default" => "/var/lib/opensips_cdrs",
		"name"    => "Smonitor charting",
        "options" => array('Off'=>'0', 'On'=>'1'),
		'show_in_edit_form' => true,
		"type"    => "dropdown",
		"validation_regex" => null,
    ),
	"assoc_id" => array(
		"default" => "/var/lib/opensips_cdrs",
		"name"    => "System name",
		"options" => get_assoc_id(),
		'show_in_edit_form' => true,
		"type"    => "dropdown",
		"validation_regex" => null,
    ),
);





 ?>