<?php namespace Kodeks\LaravelFaye;

use Mockery\CountValidator\Exception;

class Faye {

	/**
	 * Utility function used to create the curl object with common settings
	 *
	 * @param $url
	 * @param $timeout
	 * @return resource
	 * @throws \Exception
	 */
	private function create_curl($url, $timeout)
	{
		$ch = curl_init();
		if ( $ch === false )
		{
			throw new \Exception('Could not initialise cURL!');
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Content-Type: application/json" ]);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		return $ch;
	}
	/**
	 * Utility function to execute curl and create capture response information.
	 *
	 * @param $ch
	 * @return array
	 */
	private function exec_curl($ch)
	{
		$response = [];
		$response[ 'body' ] = curl_exec( $ch );
		$response[ 'status' ] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close( $ch );
		return $response;
	}

	protected $server;
	protected $timeout = 30;
	public $last_error;


	public function connect($server, $timeout=30){
		$this->server = $server;
		$this->timeout = $timeout;
	}

	/**
	 * Send message
	 * @param string $channel message channel
	 * @param array  $data    Data to send
	 * @param array  $ext     Extra data
	 */
	public function send($channel, $data = array(), $ext = array()){
		if(empty($this->server))
			throw new \Exception('Need set up connection before faye can send message');
		$server = \Config::get('faye.name', '');
		if(!empty($server))
			$channel = '/'. \Config::get('faye.name', '') . $channel;

		$this->postJSON($this->server, json_encode([
			'channel' => $channel,
			'data' => $data,
			'ext' => $ext,
		]));
	}

	/**
	 * Exec a post request with json content type
	 * @param string $url  url to request
	 * @param string $body Body to send
	 *
	 * @return null
	 */
	public function postJSON($url, $body)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($body),
		));

		$response = [];
		$response[ 'body' ] = curl_exec( $curl );
		$response[ 'status' ] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		$status = json_decode($response[ 'body' ], true);
		if(!empty($status[0]['successful'])){
			return true;
		}else{
			if(!empty($status[0]['error'])){
				$this->last_error = $status[0]['error'];
			}
			return false;
		}
	}

	public function getLastError(){
		return $this->last_error;
	}

}
