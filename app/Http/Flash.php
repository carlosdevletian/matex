<?php

namespace App\Http;

class Flash {

	public function create($title, $message, $level, $key = 'flash_message', $button = 'Aceptar')
	{
		session()->flash($key, [
			'title'		=> $title,
			'message'	=> $message,
			'level'		=> $level,
			'button'	=> $button
		]);
	}

	public function info($title, $message)
	{
		return $this->create($title, $message, 'info');
	}

	public function success($title, $message)
	{
		return $this->create($title, $message, 'success');
	}

	public function error($title, $message)
	{
		return $this->create($title, $message, 'error');
	}

	public function overlay($title, $message, $level='success', $button = 'Aceptar')
	{
		return $this->create($title, $message, $level, 'flash_message_overlay', $button);
	}
}
