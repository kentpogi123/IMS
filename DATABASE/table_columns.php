<?php

$table_columns_mapping = [
	'users' => [
		'user_pic', 'first_name', 'last_name', 'email', 'password', 'position', 'created_at', 'update_at'
	],
	'products' => [
		'product_name', 'product_type', 'quantity', 'unit', 'img', 'manufacture_date', 'expiration_date', 'created_by', 'created_at', 'updated_at'
	],
	'equipments' => [
		'equipment_name', 'EN_img', 'status', 'state', 'description', 'created_by', 'created_at', 'updated_at'
	],
	'facilities' => [
		'facility_name', 'state', 'description', 'facility_pic', 'status', 'created_by', 'created_at', 'updated_at'
	],
	'tablewares' => [
		'PC_tableware', 'tableware_pic', 'tableware_type', 'quantity', 'unit', 'g_condition', 'damage', 'missing', 'created_by', 'created_at', 'updated_at'
	],
	'utensils' => [
		'utensil_name', 'utensil_type', 'utensil_pic', 'quantity', 'unit', 'g_condition', 'missing', 'damage', 'created_by', 'created_at', 'updated_at'
	],
	'activitylogs' => [
		'user_id', 'action_made', 'created_at'
	],
	'loginlogs' => [
		'user_id', 'login_logout', 'created_at'
	]
]; 
?> 