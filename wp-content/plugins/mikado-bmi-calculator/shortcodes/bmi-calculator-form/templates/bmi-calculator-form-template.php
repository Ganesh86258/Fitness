<div class="mkd-bmi-calculator-holder <?php if($skin == 'light') { ?>mkd-bmi-calculator-light<?php } ?>">
	<?php if($display_chart === 'yes') : ?>
		<div class="mkd-bmic-table-holder">
			<?php if($chart_title !== '') : ?>
				<div class="mkd-section-title-holder">
					<h3 class="mkd-section-title mkd-section-title-medium"><?php echo esc_html($chart_title); ?></h3>
				</div>
			<?php endif; ?>
			<table>
				<thead>
				<tr>
					<th><?php esc_html_e('BMI', 'mkd_bmi'); ?></th>
					<th><?php esc_html_e('Weight Status', 'mkd_bmi'); ?></th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td><?php esc_html_e('Below', 'mkd_bmi'); ?> 18.5</td>
					<td><?php esc_html_e('Underweight', 'mkd_bmi'); ?></td>
				</tr>
				<tr>
					<td>18.5 - 24.9</td>
					<td><?php esc_html_e('Healthy', 'mkd_bmi'); ?></td>
				</tr>
				<tr>
					<td>25.0 - 29.9</td>
					<td><?php esc_html_e('Overweight', 'mkd_bmi'); ?></td>
				</tr>
				<tr>
					<td>30.0 - <?php esc_html_e('and Above', 'mkd_bmi'); ?></td>
					<td><?php esc_html_e('Obese', 'mkd_bmi'); ?></td>
				</tr>
				</tbody>
			</table>
			<div class="mkd-bmic-legend">
				<span>
				<sup>*</sup> <strong>BMR</strong> Metabolic Rate / <strong>BMI</strong> Body Mass Index
				</span>
			</div>
		</div>
	<?php endif; ?>
	<div class="mkd-bmic-form-holder">
		<?php if($form_title !== '') : ?>
			<div class="mkd-section-title-holder">
				<h3 class="mkd-section-title mkd-section-title-medium"><?php echo esc_html($form_title); ?></h3>
			</div>
		<?php endif; ?>
		<div class="mkd-section-subtitle-holder">
			<div class="mkd-section-subtitle">
				<p><?php echo esc_html($form_description); ?></p>
			</div>
		</div>
		<form action="POST" class="mkd-bmic-form">
			<div class="mkd-bmic-form-row">
				<div class="mkd-bmic-form-col">
					<input type="text" name="height" placeholder="<?php esc_attr_e('Height / cm'); ?>">
				</div>
				<div class="mkd-bmic-form-col">
					<input type="text" name="weight" placeholder="<?php esc_attr_e('Weight / kg'); ?>">
				</div>
			</div>
			<div class="mkd-bmic-form-row">
				<div class="mkd-bmic-form-col">
					<input type="text" name="age" placeholder="<?php esc_attr_e('Age'); ?>">
				</div>
				<div class="mkd-bmic-form-col">
					<select name="sex">
						<option value=""><?php esc_html_e('Sex', 'mkd_bmi'); ?></option>
						<option value="male"><?php esc_html_e('Male', 'mkd_bmi'); ?></option>
						<option value="female"><?php esc_html_e('Female', 'mkd_bmi'); ?></option>
					</select>
				</div>
			</div>
			<div class="mkd-bmic-form-row">
				<div class="mkd-bmic-form-col-full">
					<select name="activity_level">
						<option value=""><?php esc_html_e('Select an activity factor:', 'mkd_bmi'); ?></option>
						<option value="little"><?php esc_html_e('Little or no Exercise/ desk job', 'mkd_bmi'); ?></option>
						<option value="light"><?php esc_html_e('Light exercise/ sports 1 – 3 days/ week', 'mkd_bmi'); ?></option>
						<option value="moderate"><?php esc_html_e('Moderate Exercise, sports 3 – 5 days/ week', 'mkd_bmi'); ?></option>
						<option value="heavy"><?php esc_html_e('Heavy Exercise/ sports 6 – 7 days/ week', 'mkd_bmi'); ?></option>
						<option value="very_heavy"><?php esc_html_e('Very heavy exercise/ physical job/ training 2 x/ day', 'mkd_bmi'); ?></option>
					</select>
				</div>
			</div>
			<div class="mkd-bmic-form-row mkd-bmic-submit-row">
				<div class="mkd-bmic-form-col-full">
					<input class="mkd-btn mkd-btn-solid mkd-btn-small mkd-btn-hover-outline" type="submit" value="<?php esc_attr_e('Calculate'); ?>">
				</div>
			</div>
		</form>
	</div>
	<div class="mkd-bmic-notifications-col">
		<div class="mkd-bmic-notifications">
			<span class="mkd-bmic-icon-holder">
				<span></span>
			</span>
			<span class="mkd-bmic-notification-text"></span>
			<a href="#" class="mkd-bmic-notification-close"></a>
		</div>
	</div>
</div>