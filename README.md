# Action Scheduler - Test Data Generator

Generate a large number of dummy actions with Action Scheduler.

### Usage

Append `?astdg_generate_actions=true` to an admin page to generate actions.

Additional parameters available:

* `(string)'astdg_action_type'`: Type of action to create. Can be `async`, `single`, `cron` or `recurring`. Default `async`.
* `(int)'astdg_start_time'`: Unix timestamp representing time to run the action, or in the case of Cron actions, time to schedule the first instance at or after. Not used for `async` actions. Default current time.
* `(string)'astdg_hook'`: String to use as the action's hook. Default 'astdg_test_{$action_type}_action'.
* `(string)'astdg_group'`: Group for the actions. Default 'astdg_test_{$action_type}_actions'.
* `(int)'astdg_sleep_time'`: Optional amount of time to sleep when the action runs. Only works if using default hook value. Default `0`.
* `(int)'astdg_action_count'`: Number of actions to create. Default 100. 
* `(int)|(string)'astdg_recurrence'`: Recurrence for recurring and cron actions.
	* For a recurring action, this should be an `int representing number of seconds between each recurrence. Default, every 12 hours: `43,200`.
	* For a cron action, this should be an `string` representing the cron schedule. Default, every 12 hours: `'0 */12 * * *'`.

#### Examples URLs:

* Create 10 Cron actions that run every 12 hours: `/wp-admin/?astdg_generate_actions=true&astdg_action_type=cron&astdg_action_count=10`
* Create 10 Cron actions that run once every day: `/wp-admin/?astdg_generate_actions=true&astdg_action_type=cron&astdg_action_count=10&0 0 * * *`
* Create 250 Recurring actions to recur every 12 hours: `/wp-admin/?astdg_generate_actions=true&astdg_action_type=recurring&astdg_action_count=250`
* Create 250 Recurring actions to recur every 24 hours: `/wp-admin/?astdg_generate_actions=true&astdg_action_type=recurring&astdg_action_count=250&recurrence=86400`
* Create 100 Single actions with hook `'my_test_action'`: `/wp-admin/?astdg_generate_actions=true&astdg_action_type=single&astdg_hook=my_test_action`
* Create 1,000 Single actions to run 1st January 2020: `/wp-admin/?astdg_generate_actions=true&astdg_action_type=single&astdg_action_count=1000&astdg_start_time=1577836800`

## Installation

To install:

1. Download the latest version of the plugin [here](https://github.com/Prospress/action-scheduler-test-data-generator/archive/master.zip)
1. Go to **Plugins > Add New > Upload** administration screen on your WordPress site
1. Select the ZIP file you just downloaded
1. Click **Install Now**
1. Click **Activate**

### Updates

To keep the plugin up-to-date, use the [GitHub Updater](https://github.com/afragen/github-updater).

## Reporting Issues

If you find an problem or would like to request this plugin be extended, please [open a new Issue](https://github.com/Prospress/action-scheduler-test-data-generator/issues/new).

---

<p align="center">
	<a href="https://prospress.com/">
		<img src="https://cloud.githubusercontent.com/assets/235523/11986380/bb6a0958-a983-11e5-8e9b-b9781d37c64a.png" width="160">
	</a>
</p>