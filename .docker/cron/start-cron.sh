#!/bin/bash

echo "Start cron"
exec /usr/sbin/crond -f
