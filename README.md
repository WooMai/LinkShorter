# Link Shorter

Just Another URL Shorter.<br>
Source code of https://9s.gs

## Requirements

- latest stable version of Nginx
- latest stable version of MariaDB/MySQL
- latest stable version of Redis
- PHP 8.0+ with `ext-redis`

## Deploy

### Clone Repository

```
git clone https://github.com/WooMai/LinkShorter
```

### Install Dependencies

```
composer install
```

### Example Nginx Configuration

```
root /path/to/root/dir/public;

location / {
  try_files $uri $uri/ /index.php?$query_string;
}

location ~ .*\.(html)?$ {
    if ($ssl_protocol = "") {
        return 301 https://$host$request_uri;
    }
    expires 30s;
    access_log off;
}

location ~ .*\.(js|css)?$ {
    expires 7d;
    access_log off;
}
```

### Fill the Configuration File

```
cp config/config.example.php config/config.php
vi config/config.php
```

### Database Template

```
--
-- Table structure for table `redirects`
--
CREATE TABLE `redirects` (
  `id` int(11) NOT NULL,
  `token` varchar(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `target` text NOT NULL,
  `manage_token` varchar(32) NOT NULL,
  `create_time` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `api_token` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for table `redirects`
--
ALTER TABLE `redirects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `manage_token` (`manage_token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_token` (`api_token`);

--
-- AUTO_INCREMENT for table `redirects`
--
ALTER TABLE `redirects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
```

## License

[Apache License 2.0](LICENSE)
