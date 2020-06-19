# Cloudflare SDK (v4 API Binding for PHP 7)

[![Build Status](https://travis-ci.org/cloudflare/cloudflare-php.svg?branch=master)](https://travis-ci.org/cloudflare/cloudflare-php)

See: [cloudflare/cloudflare-php](https://github.com/cloudflare/cloudflare-php)

# Cloudflare SDK: added by Shellrent

- DNS Record is returned on creation:

`Class: Cloudflare\API\Endpoints\DNS`

```php
public function addRecord(
	string $zoneID,
	string $type,
	string $name,
	string $content,
	int $ttl = 0,
	bool $proxied = true,
	string $priority = '',
	array $data = []
): \stdClass {
	$options = [
		'type' => $type,
		'name' => $name,
		'content' => $content,
		'proxied' => $proxied
	];

	if ($ttl > 0) {
		$options['ttl'] = $ttl;
	}

	if (!empty($priority)) {
		$options['priority'] = (int)$priority;
	}

	if (!empty($data)) {
		$options['data'] = $data;
	}

	$user = $this->adapter->post('zones/' . $zoneID . '/dns_records', $options);

	$this->body = json_decode($user->getBody());

	return $this->body->result;
}
```
