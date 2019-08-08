<?php
/*
 * Plugin Name: Action Scheduler - Test Data Generator
 * Plugin URI: https://github.com/Prospress/action-scheduler-test-data-generator/
 * Description: Generate a large number of dummy actions with Action Scheduler.
 * Author: Prospress Inc.
 * Author URI: https://prospress.com/
 * License: GPLv3
 * Version: 1.0.0
 * Requires at least: 4.0
 * Tested up to: 4.8
 *
 * GitHub Plugin URI: Prospress/action-scheduler-test-data-generator
 * GitHub Branch: master
 *
 * Copyright 2018 Prospress, Inc.  (email : freedoms@prospress.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package		Action Scheduler - Test Data Generator
 * @author		Prospress Inc.
 * @since		1.0
 */

function as_test_schedule_async_action() {

	if ( ! is_admin() || ! isset( $_GET['astdg_generate_actions'] ) ) {
		return;
	}

	$action_type  = isset( $_GET['astdg_action_type'] ) ? $_GET['astdg_action_type'] : 'async';
	$hook         = isset( $_GET['astdg_hook'] ) ? $_GET['astdg_hook'] : sprintf( 'astdg_test_%s_action', $action_type );
	$group        = isset( $_GET['astdg_group'] ) ? $_GET['astdg_group'] : sprintf( 'astdg_test_%s_actions', $action_type );
	$sleep_time   = isset( $_GET['astdg_sleep_time'] ) ? (int) $_GET['astdg_sleep_time'] : 0;
	$action_count = isset( $_GET['astdg_action_count'] ) ? (int) $_GET['astdg_action_count'] : 100;

	if ( isset( $_GET['astdg_start_time'] ) ) {
		$start_time = (int)$_GET['astdg_start_time'];
	} elseif ( isset( $_GET['astdg_start_date'] ) ) {
		$start_time = as_get_datetime_object( $_GET['astdg_start_date'] )->getTimestamp();
	} else {
		$start_time = time();
	}

	$args = array(
		'creation_timestamp' => time(),
		'sleep_time' => 1,
	);

	for ( $i = 1; $i <= $action_count; $i++ ) {

		$args['i'] = $i;

		switch ( $action_type ) {
			case 'async' :
				as_enqueue_async_action( $hook, $args, $group );
				break;
			case 'cron' :
				$recurrence = isset( $_GET['astdg_recurrence'] ) ? $_GET['astdg_recurrence'] : '0 */12 * * *';
				as_schedule_cron_action( $start_time, $recurrence, $hook, $args, $group );
				break;
			case 'recurring' :
				$recurrence = isset( $_GET['astdg_recurrence'] ) ? (int) $_GET['astdg_recurrence'] : 12 * HOUR_IN_SECONDS;
				as_schedule_recurring_action( $start_time, $recurrence, $hook, $args, $group );
				break;
			case 'single' :
				as_schedule_single_action( $start_time, $hook, $args, $group );
				break;
		}
	}
}
add_action( 'shutdown', 'as_test_schedule_async_action' );

/**
 * Add a default sleep based on params.
 */
function as_test_action_sleep( $creation_timestamp, $sleep_time ) {
	if ( $sleep_time > 0 ) {
		sleep( $sleep_time );
	}
}
add_action( 'astdg_test_async_action', 'as_test_action_sleep', 10, 2 );
add_action( 'astdg_test_cron_action', 'as_test_action_sleep', 10, 2 );
add_action( 'astdg_test_single_action', 'as_test_action_sleep', 10, 2 );
add_action( 'astdg_test_recurring_action', 'as_test_action_sleep', 10, 2 );
