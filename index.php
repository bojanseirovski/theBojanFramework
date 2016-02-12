<?php

/**
 * Backend framework
 * 
 * Bojan Seirovski - bojan@seirovski.com
 */
include 'config.php';
try {
	$lib = $baseDir . "lib" . DIRECTORY_SEPARATOR;
	$lib2Util = $baseDir . "lib" . DIRECTORY_SEPARATOR. "util" . DIRECTORY_SEPARATOR;
	$res = $baseDir . "resource" . DIRECTORY_SEPARATOR;

	if (is_dir($lib)) {
		foreach (glob($lib . "*.php") as $filename) {
			include $filename;
		}
	}
	if (is_dir($lib2Util)) {
		foreach (glob($lib2Util . "*.php") as $filename) {
			include $filename;
		}
	}
	if (is_dir($res)) {
		foreach (glob($res . "*.php") as $filename) {
			include $filename;
		}
	}
	

	$log = new \BojanGles\lib\Log($config['log_file']);

	$log->info('Creating objects');

	$db = new \BojanGles\lib\DB($db['dsn'], $db['username'], $db['password']);
	$request = new \BojanGles\lib\Request();
	$response = new \BojanGles\lib\Response();

	$log->info('Objects created');

	$controllerName = $request->get('controller');
	if (isset($controllerName)) {
		$log->info('Controller to be loaded :' . $controllerName);
		$theControllerPath = '\\' . "BojanGles\\Resources\\" . $controllerName;
		$theController = new $theControllerPath($config, $db);
		try {
			//	process request
			$do = $theController->get($request);

			//	output
			$response->out($do);
		} catch (\Exception $e) {
			$log->error($e->getMessage());
		}

		$log->info('Response for ' . $controllerName . ' :' . json_encode($do));
	} else {
		$response->out(array('Error' => true, 'ErrorMessage' => 'Bad request : unknown route.'));
	}
} catch (\Exception $e) {
	error_log($e->getMessage());
	$error = array('Error' => true, 'ErrorMessage' => 'System error.');

	echo json_encode($error);
}