# MFF.dk [![Build Status]](https://github.com/TanvirAlam/mff-TDD)

This is an open source project that was built and maintained by @TanvirAlam with help of Laracast.com.

## Installation

### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet.
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart).

### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies.

```bash
git clone git@github.com:TanvirAlam/mff-TDD.git
cd council && composer install && npm install
php artisan council:install
npm run dev
```

### Step 2

Next, boot up a server and visit your forum. If using a tool like Laravel Valet, of course the URL will default to `http://mff.dev`.

1.  Visit: `http://mff/register` to register a new forum account.
2.  Edit `config/mff.php`, and add any email address that should be marked as an administrator.
3.  Visit: `http://mff/admin/channels` to seed your forum with one or more channels.
